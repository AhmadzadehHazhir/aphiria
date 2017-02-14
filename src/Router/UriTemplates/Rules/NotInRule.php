<?php
namespace Opulence\Router\UriTemplates\Rules;

/**
 * Defines the not-in-array rule
 */
class NotInRule implements IRule
{
    /** @var array The list of acceptable values */
    private $acceptableValues = [];
    
    /**
     * @param array $acceptableValues The list of acceptable values
     */
    public function __construct(array $acceptableValues)
    {
        $this->acceptableValues = $acceptableValues;
    }
    
    /**
     * @inheritdoc
     */
    public function getSlug() : string
    {
        return 'notIn';
    }
    
    /**
     * @inheritdoc
     */
    public function passes($value) : bool
    {
        return !in_array($value, $this->acceptableValues);
    }
}
