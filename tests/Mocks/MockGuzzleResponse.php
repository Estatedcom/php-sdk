<?php

namespace Tests\Mocks;


class MockGuzzleResponse
{
    protected $httpStatusCode;

    protected $headers;

    protected $body;

    public const EXPECTED_HTTP_STATUS_CODE = 200;

    public const EXPECTED_HEADERS = ['X-Foo' => 'Bar'];

    public const EXPECTED_BODY = '{ "success": true, "codes": {}, "properties": [] }';

    function __construct($statusCode, $headers, $body)
    {
        $this->httpStatusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getStatusCode()
    {
        return $this->httpStatusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }
}