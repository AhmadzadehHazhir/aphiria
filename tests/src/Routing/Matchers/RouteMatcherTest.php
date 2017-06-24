<?php

/*
 * Opulence
 *
 * @link      https://www.opulencephp.com
 * @copyright Copyright (C) 2017 David Young
 * @license   https://github.com/opulencephp/route-matcher/blob/master/LICENSE.md
 */

namespace Opulence\Routing\Matchers;

use Opulence\Routing\Matchers\Constraints\IRouteConstraint;
use Opulence\Routing\Matchers\Regexes\GroupRegex;
use Opulence\Routing\Matchers\Regexes\GroupRegexCollection;
use Opulence\Routing\Matchers\UriTemplates\UriTemplate;

/**
 * Tests the route matcher
 */
class RouteMatcherTest extends \PHPUnit\Framework\TestCase
{
    /** @var RouteMatcher The matcher to use in tests */
    private $matcher = null;
    /** @var GroupRegexCollection|\PHPUnit_Framework_MockObject_MockObject The regex collection to use in tests */
    private $regexes = null;

    /**
     * Sets up the tests
     */
    public function setUp() : void
    {
        $this->regexes = $this->createMock(GroupRegexCollection::class);
        $this->matcher = new RouteMatcher($this->regexes);
    }

    /**
     * Tests that a matching route with a failed constraint causes the matcher to throw an exception
     */
    public function testFailedConstraintThrowsException() : void
    {
        $this->expectException(RouteNotFoundException::class);
        $expectedRoute = new Route('GET', new UriTemplate('', false), $this->createMock(RouteAction::class));
        $expectedRegexes = [
            new GroupRegex(
                '#^(^foo$)$#',
                [0 => $expectedRoute]
            )
        ];
        $constraint = $this->createMock(IRouteConstraint::class);
        $constraint->expects($this->once())
            ->method('isMatch')
            ->with('', 'foo', ['foo' => 'bar'], $expectedRoute)
            ->willReturn(false);
        $matcher = new RouteMatcher($this->regexes, [$constraint]);
        $this->regexes->expects($this->once())
            ->method('getByMethod')
            ->with('GET')
            ->willReturn($expectedRegexes);
        $matcher->match('GET', '', 'foo', ['foo' => 'bar']);
    }

    /**
     * Tests that matching can occur on URI templates with differing numbers of capturing groups
     */
    public function testMatchingCanOccurOnUriTemplatesWithDifferingNumbersOfCapturingGroups() : void
    {
        $expectedRegexes = [
            new GroupRegex(
                '#^(^foo(1)$)|(^bar(2)(3)(4)$)|(^baz(5)(6)$)$#',
                [
                    0 => new Route(
                        'GET',
                        new UriTemplate('', false, ['var1']),
                        $this->createMock(RouteAction::class)
                    ),
                    2 => new Route(
                        'GET',
                        new UriTemplate('', false, ['var2', 'var3', 'var4']),
                        $this->createMock(RouteAction::class)
                    ),
                    6 => new Route(
                        'GET',
                        new UriTemplate('', false, ['var5', 'var6']),
                        $this->createMock(RouteAction::class)
                    )
                ]
            )
        ];
        $this->regexes->expects($this->exactly(3))
            ->method('getByMethod')
            ->with('GET')
            ->willReturn($expectedRegexes);
        $matchingPaths = [
            'foo1' => ['var1' => '1'],
            'bar234' => ['var2' => '2', 'var3' => '3', 'var4' => '4'],
            'baz56' => ['var5' => '5', 'var6' => '6']
        ];

        foreach ($matchingPaths as $matchingPath => $expectedRouteVars) {
            $matchedRoute = $this->matcher->match('GET', '', $matchingPath, []);
            $this->assertEquals($expectedRouteVars, $matchedRoute->getRouteVars());
        }
    }

    /**
     * Tests a matching route with vars after a route that has no vars
     */
    public function testMatchingRouteWithVarsThatIsCheckedAfterMissedRouteWithNoVars() : void
    {
        $expectedMatchedAction = $this->createMock(RouteAction::class);
        $expectedRegexes = [
            new GroupRegex(
                '#^(^foo$)|(^bar(1)(2)$)$#',
                [
                    0 => new Route(
                        'GET',
                        new UriTemplate('', false),
                        $this->createMock(RouteAction::class)
                    ),
                    1 => new Route(
                        'GET',
                        new UriTemplate('', false),
                        $expectedMatchedAction
                    )
                ]
            )
        ];
        $this->regexes->expects($this->once())
            ->method('getByMethod')
            ->with('GET')
            ->willReturn($expectedRegexes);
        $matchedRoute = $this->matcher->match('GET', '', 'bar12', []);
        $this->assertSame($expectedMatchedAction, $matchedRoute->getAction());
    }

    /**
     * Tests no match for a URI throws an exception
     */
    public function testNoMatchForUriThrowsException() : void
    {
        $this->expectException(RouteNotFoundException::class);
        $expectedRegexes = [
            new GroupRegex(
                '#^(^foo$)$#',
                [
                    0 => new Route(
                        'GET',
                        new UriTemplate('', false),
                        $this->createMock(RouteAction::class)
                    )
                ]
            )
        ];
        $this->regexes->expects($this->once())
            ->method('getByMethod')
            ->with('GET')
            ->willReturn($expectedRegexes);
        $this->matcher->match('GET', '', 'bar', []);
    }

    /**
     * Tests that a passing constraint does not filter a route
     */
    public function testPassingConstraintDoesNotFilterRoute() : void
    {
        $expectedMatchedAction = $this->createMock(RouteAction::class);
        $expectedRoute = new Route(
            'GET',
            new UriTemplate('', false),
            $expectedMatchedAction
        );
        $expectedRegexes = [
            new GroupRegex(
                '#^(^foo$)$#',
                [0 => $expectedRoute]
            )
        ];
        $constraint = $this->createMock(IRouteConstraint::class);
        $constraint->expects($this->once())
            ->method('isMatch')
            ->with('', 'foo', ['foo' => 'bar'], $expectedRoute)
            ->willReturn(true);
        $matcher = new RouteMatcher($this->regexes, [$constraint]);
        $this->regexes->expects($this->once())
            ->method('getByMethod')
            ->with('GET')
            ->willReturn($expectedRegexes);
        $matchedRoute = $matcher->match('GET', '', 'foo', ['foo' => 'bar']);
        $this->assertSame($expectedMatchedAction, $matchedRoute->getAction());
    }
}
