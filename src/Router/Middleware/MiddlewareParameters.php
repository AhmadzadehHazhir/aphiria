<?php
namespace Opulence\Router\Middleware;

/**
 * Defines a middleware's parameters
 */
class MiddlewareParameters
{
    /** @var string The middleware class name */
    private $middlewareClassName = "";
    /** @var array The middleware parameters */
    private $parameters = [];

    /**
     * @param string $middlewareClassName The middleware class name
     * @param array $parameters The middleware parameters
     */
    public function __construct(string $middlewareClassName, array $parameters)
    {
        $this->middlewareClassName = $middlewareClassName;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getMiddlewareClassName() : string
    {
        return $this->middlewareClassName;
    }

    /**
     * @return array
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }
}