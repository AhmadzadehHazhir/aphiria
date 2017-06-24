<?php

/**
 * Opulence
 *
 * @link      https://www.opulencephp.com
 * @copyright Copyright (C) 2017 David Young
 * @license   https://github.com/opulencephp/route-matcher/blob/master/LICENSE.md
 */

namespace Opulence\Routing\Matchers\Regexes;

/**
 * Defines a regex for a group of routes
 */
class GroupRegex
{
    /** @var string The group regex */
    private $groupRegex = '';
    /** @var array The mapping of regex capturing group offsets to routes */
    private $routesByCapturingGroupOffsets = [];
    
    /**
     * @param string $groupRegex The group regex
     * @param array $routesByCapturingGroupOffsets The mapping of regex capturing group offsets to routes
     */
    public function __construct(string $groupRegex, array $routesByCapturingGroupOffsets)
    {
        $this->groupRegex = $groupRegex;
        $this->routesByCapturingGroupOffsets = $routesByCapturingGroupOffsets;
    }
    
    /**
     * Gets the group regex
     * 
     * @return string The group regex
     */
    public function getGroupRegex() : string
    {
        return $this->groupRegex;
    }
    
    /**
     * Gets the mapping of regex capturing group offsets to routes
     * 
     * @return array The mapping of regex capturing group offsets to routes
     */
    public function getRoutesByCapturingGroupOffsets() : array
    {
        return $this->routesByCapturingGroupOffsets;
    }
}
