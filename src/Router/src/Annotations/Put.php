<?php

/**
 * Aphiria
 *
 * @link      https://www.aphiria.com
 * @copyright Copyright (C) 2019 David Young
 * @license   https://github.com/aphiria/route-annotations/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Aphiria\RouteAnnotations\Annotations;

use Doctrine\Annotations\Annotation\Target;

/**
 * Defines the PUT route annotation
 * @Annotation
 * @Target({"METHOD"})
 */
final class Put extends Route
{
    /**
     * @param array $values The mapping of value names to values
     */
    public function __construct(array $values)
    {
        $values['httpMethods'] = ['PUT'];
        parent::__construct($values);
    }
}
