<?php

/**
 * Aphiria
 *
 * @link      https://www.aphiria.com
 * @copyright Copyright (C) 2019 David Young
 * @license   https://github.com/aphiria/serialization/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Aphiria\Serialization\Tests\Encoding\Mocks;

/**
 * Mocks a class that can hold a circular reference
 */
class CircularReferenceB
{
    private CircularReferenceA $foo;

    public function __construct(CircularReferenceA $foo)
    {
        $this->foo = $foo;
    }

    public function getFoo(): CircularReferenceA
    {
        return $this->foo;
    }
}