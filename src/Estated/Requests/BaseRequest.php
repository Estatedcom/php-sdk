<?php

namespace Estated\Requests;

use Estated\Clients\EstatedClient;
use GuzzleHttp\Exception\RequestException;
use Estated\EstatedResponse;
use Estated\Exceptions\MissingParameterException;
use Estated\Clients\iEstatedClient;


/**
 * Class BaseRequest
 *
 * @package Estated\Request
 */
abstract class BaseRequest
{
    /**
     * @var string The token or api key assigned to you from Estated.
     */
    protected $token;

    /**
     * @var string The response output format.
     */
    protected $format;

    /**
     * const string The endpoint url without query string parameters.
     */
    protected const ENDPOINT_URL = 'https://api.estated.com/property/v3?';

    /**
     * @var EstatedClient The http client to send requests.
     */
    protected $client;

    /**
     * Creates a new BaseRequest object.
     *
     * @param $args
     * @param $client
     * @throws MissingParameterException
     */
    function __construct($args, iEstatedClient $client = null){

        if (is_null($client)) {
            $this->client = new EstatedClient();
        } else {
            $this->client = $client;
        }

        foreach ($args as $key => $value) {
            $this->$key = $value;
        }

        $this->validate();
    }

    /**
     * Validate method to be implemented in each inheriting class.
     * @return mixed
     */
    abstract protected function validate();

    /**
     * Builds a request url.  To be implemented in each inheriting class.
     * @return mixed
     */
    abstract protected function buildRequest();

    /**
     * Sends the request to Estated for property search.
     *
     * @return EstatedResponse
     */
    public function send()
    {
        try {
            $response = $this->client->get($this->buildRequest());
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return new EstatedResponse($this->buildRequest(), $response->getStatusCode(), $response->getHeaders(), $response->getBody());
    }

    /**
     * Validates that the parameter passed in is not null.  If null, the parameter name gets added to a string
     * list of errors.
     *
     * @param $parameter|mixed  The parameter to validate.
     * @param $name|string      The name of the parameter to validate.
     * @param $errors|string    A string of errors.
     */
    protected function validateParameter($parameter, $name, &$errors) {
        if (empty($parameter)) {
            empty($errors) ? $errors .= $name : $errors .= ", " . $name;
        }
    }
}