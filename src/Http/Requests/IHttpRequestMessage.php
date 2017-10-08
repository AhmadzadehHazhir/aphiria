<?php

/*
 * Opulence
 *
 * @link      https://www.opulencephp.com
 * @copyright Copyright (C) 2017 David Young
 * @license   https://github.com/opulencephp/net/blob/master/LICENSE.md
 */

namespace Opulence\Net\Http\Requests;

use Opulence\Collections\HashTable;
use Opulence\Net\Http\IHttpMessage;
use Opulence\Net\Uri;

/**
 * Defines the interface for HTTP request messages to implement
 */
interface IHttpRequestMessage extends IHttpMessage
{
    /**
     * Gets the HTTP method for the request
     *
     * @return string The HTTP method
     */
    public function getMethod() : string;

    /**
     * Gets the properties of the request
     *
     * @return HashTable The collection of properties
     */
    public function getProperties() : HashTable;

    /**
     * Gets the URI of the request
     *
     * @return Uri The URI
     */
    public function getUri() : Uri;
}
