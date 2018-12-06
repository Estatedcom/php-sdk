<?php

namespace Estated\Requests;

use Estated\Exceptions\MissingParameterException;


/**
 * Class ConformingRequest
 *
 * @package Estated\Requests
 */
class ConformingRequest extends BaseRequest
{
    /**
     * @var string The full street address of the property.
     */
    protected $address;

    /**
     * @var string The city the property is in.
     */
    protected $city;

    /**
     * @var string The 2-char abbreviation of the state the property is in.
     */
    protected $state;

    /**
     * @var string The zip code for the property.
     */
    protected $zipcode;

    /**
     * Creates a new Conforming request object.
     *
     * @param $args
     * @param $client
     * @throws MissingParameterException
     */
    public function __construct($args, $client = null)
    {
        parent::__construct($args, $client);
    }

    /**
     * Builds a complete Conforming request url.
     *
     * @return string
     */
    public function buildRequest()
    {
        $requestUrl = self::ENDPOINT_URL . 'token=' . $this->token . '&address=' . rawurlencode($this->address) . '&city=' . rawurlencode($this->city) . '&state=' . rawurldecode($this->state);

        if ($this->zipcode) {
            $requestUrl .= '&zipcode=' . rawurlencode($this->zipcode);
        }

        if ($this->format) {
            $requestUrl .= '&format=' . rawurlencode($this->format);
        }

        return $requestUrl;
    }

    /**
     * Validates the required parameters for a valid Conforming request call.
     *
     * @throws MissingParameterException
     */
    protected function validate()
    {
        $errors = "";

        $this->validateParameter($this->token, "token", $errors);
        $this->validateParameter($this->address, "address", $errors);
        $this->validateParameter($this->city, "city", $errors);
        $this->validateParameter($this->state, "state", $errors);

        if (!empty($errors)) {
            throw new MissingParameterException($errors);
        }
    }
}
