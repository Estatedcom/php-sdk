<?php

namespace Estated\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


/**
 * Class EstatedClient
 *
 * @package Estated\Clients
 */
class EstatedClient implements iEstatedClient
{
    /**
     * @var Client|null The http client sending the requests
     */
    protected $guzzleClient;

    /**
     * Creates a new EstatedClient object.
     *
     * @param Client|null $guzzleClient
     */
    function __construct(Client $guzzleClient = null)
    {
        $this->guzzleClient = $guzzleClient ?? new Client();
    }

    /**
     * Sends a GET request to the request url passed in.
     *
     * @param $requestUrl
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function get($requestUrl){

        try {
            $response = $this->guzzleClient->get($requestUrl);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }
}