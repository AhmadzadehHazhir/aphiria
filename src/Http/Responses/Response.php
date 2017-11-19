<?php

/*
 * Opulence
 *
 * @link      https://www.opulencephp.com
 * @copyright Copyright (C) 2017 David Young
 * @license   https://github.com/opulencephp/net/blob/master/LICENSE.md
 */

namespace Opulence\Net\Http\Responses;

use Opulence\Net\Http\HttpHeaders;
use Opulence\Net\Http\IHttpBody;

/**
 * Defines an HTTP response message
 */
class Response implements IHttpResponseMessage
{
    /** @var IHttpBody|null The body of the response if there is one, otherwise null */
    protected $body = null;
    /** @var HttpHeaders The list of response headers */
    protected $headers = null;
    /** @var string|null The response reason phrase if there is one, otherwise null */
    protected $reasonPhrase = null;
    /** @var int The response status code */
    protected $statusCode = HttpStatusCodes::HTTP_OK;
    /** @var string The HTTP protocol version */
    protected $protocolVersion = '';

    /**
     * @param int $statusCode The response status code
     * @param HttpHeaders|null $headers The list of response headers
     * @param IHttpBody|null $body The response body
     * @param string $protocolVersion The HTTP protocol version
     */
    public function __construct(
        int $statusCode = HttpStatusCodes::HTTP_OK,
        HttpHeaders $headers = null,
        ?IHttpBody $body = null,
        string $protocolVersion = '1.1'
    ) {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = ResponseStatusCodes::getDefaultReasonPhrase($this->statusCode);
        $this->headers = $headers ?? new HttpHeaders;
        $this->body = $body;
        $this->protocolVersion = $protocolVersion;
    }

    /**
     * @inheritdoc
     */
    public function __toString() : string
    {
        $startLine = "HTTP/{$this->protocolVersion} {$this->statusCode}";

        if ($this->reasonPhrase !== null) {
            $startLine .= " {$this->reasonPhrase}";
        }

        $headers = '';

        if (count($this->headers) > 0) {
            $headers .= "\r\n{$this->headers}";
        }

        $response = $startLine . $headers . "\r\n\r\n";

        if ($this->body !== null) {
            $response .= (string)$this->getBody();
        }

        return $response;
    }

    /**
     * @inheritdoc
     */
    public function getBody() : ?IHttpBody
    {
        return $this->body;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders() : HttpHeaders
    {
        return $this->headers;
    }

    /**
     * @inheritdoc
     */
    public function getProtocolVersion() : string
    {
        return $this->protocolVersion;
    }

    /**
     * @inheritdoc
     */
    public function getReasonPhrase() : ?string
    {
        return $this->reasonPhrase;
    }

    /**
     * @inheritdoc
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    /**
     * @inheritdoc
     */
    public function setBody(IHttpBody $body) : void
    {
        $this->body = $body;
    }

    /**
     * @inheritdoc
     */
    public function setStatusCode(int $statusCode, ?string $reasonPhrase = null) : void
    {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase ?? ResponseStatusCodes::getDefaultReasonPhrase($this->statusCode);
    }
}
