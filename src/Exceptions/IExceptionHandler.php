<?php

/*
 * Aphiria
 *
 * @link      https://www.aphiria.com
 * @copyright Copyright (c) 2019 David Young
 * @license   https://github.com/aphiria/api/blob/master/LICENSE.md
 */

namespace Aphiria\Api\Exceptions;

use Aphiria\Net\Http\IHttpRequestMessage;
use ErrorException;
use Throwable;

/**
 * Defines the interface for exception handlers to implement
 */
interface IExceptionHandler
{
    /**
     * Handles an error
     *
     * @param int $level The level of the error
     * @param string $message The message
     * @param string $file The file the error occurred in
     * @param int $line The line number the error occurred at
     * @param array $context The symbol table
     * @throws ErrorException Thrown because the error is converted to an exception
     */
    public function handleError(
        int $level,
        string $message,
        string $file = '',
        int $line = 0,
        array $context = []
    ): void;

    /**
     * Handles an exception
     *
     * @param Throwable $ex The exception to handle
     */
    public function handleException(Throwable $ex): void;

    /**
     * Handles a PHP shutdown
     */
    public function handleShutdown(): void;

    /**
     * Registers the exception and error handlers with PHP
     */
    public function registerWithPhp(): void;

    /**
     * Sets the current request
     * This can't be set via a constructor because it's not known until a little way into the app pipeline
     *
     * @param IHttpRequestMessage $request The current request
     */
    public function setRequest(IHttpRequestMessage $request): void;
}
