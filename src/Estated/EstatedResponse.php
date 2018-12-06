<?php

namespace Estated;


/**
 * Class EstatedResponse
 *
 * @package Estated
 */
class EstatedResponse
{
    /**
     * @var int The http status code returned from the request.
     */
    protected $httpStatusCode;

    /**
     * @var array The headers of the response.
     */
    protected $headers;

    /**
     * @var string The raw body of the response.
     */
    protected $body;

    /**
     * @var array|mixed The decoded body of the response.
     */
    protected $decoded_body = [];

    /**
     * @var string The request URL sent to Estated.
     */
    protected $request;

    /**
     * Creates a new EstatedResponse object.
     *
     * @param $request
     * @param $httpStatusCode
     * @param $headers
     * @param $body
     */
    public function __construct($request, $httpStatusCode, $headers, $body)
    {
        $this->request = $request;
        $this->httpStatusCode = $httpStatusCode;
        $this->headers = $headers;
        $this->body = $body;
        $this->decoded_body = json_decode($body);
    }

    /**
     * Accessor method returns the http status code of the response.
     *
     * @return int
     */
    public function httpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Accessor method returns the headers of the response.
     *
     * @return array
     */
    public function headers(){
        return $this->headers;
    }

    /**
     * Accessor method returns the raw body of the response.
     *
     * @return string
     */
    public function body(){
        return $this->body;
    }

    /**
     * Accessor method returns the response body as an associative array.
     *
     * @return array|mixed
     */
    public function decodedBody(){
        return $this->decoded_body;
    }

    /**
     * Accessor method returns the original request URL.
     *
     * @return string
     */
    public function request()
    {
        return $this->request;
    }

}