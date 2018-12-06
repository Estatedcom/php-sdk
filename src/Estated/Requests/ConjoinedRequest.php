<?php

namespace Estated\Requests;

use Estated\Exceptions\MissingParameterException;


/**
 * Class ConjoinedRequest
 *
 * @package Estated\Requests
 */
class ConjoinedRequest extends BaseRequest
{
    /**
     * @var int The number of the unit.
     */
    protected $unit_number;

    /**
     * @var int The number on the street for the property.
     */
    protected $street_number;

    /**
     * @var string The name of the street.
     */
    protected $street_name;

    /**
     * @var string The suffix of the street
     */
    protected $street_suffix;

    /**
     * @var string The name of the city.
     */
    protected $city;

    /**
     * @var string The 2-char abbreviation of the state name.
     */
    protected $state;

    /**
     * @var string The zip code for the property.
     */
    protected $zipcode;

    /**
     * Creates a new Conjoined request object.
     *
     * @param $args
     * @param $client
     * @throws MissingParameterException
     */
    function __construct($args, $client = null){
        parent::__construct($args, $client);
    }

    /**
     * Builds a valid Conjoined type request url.
     *
     * @return string   $requestUrl
     */
    public function buildRequest()
    {
        $requestUrl = self::ENDPOINT_URL . 'token=' . $this->token .
            '&street_number=' . rawurlencode($this->street_number) .
            '&street_name=' . rawurlencode($this->street_name) .
            '&street_suffix=' . rawurlencode($this->street_suffix) .
            '&city=' . rawurlencode($this->city) .
            '&state=' . rawurlencode($this->state) .
            '&zipcode=' . rawurlencode($this->zipcode);

        if ($this->unit_number) {
            $requestUrl .= '&unit_number=' . rawurlencode($this->unit_number);
        }

        if ($this->format) {
            $requestUrl .= '&format=' . rawurlencode($this->format);
        }

        return $requestUrl;
    }

    /**
     * Validates all required parameters for a Conjoined type request.
     *
     * @throws MissingParameterException
     */
    protected function validate()
    {
        $errors = "";

        $this->validateParameter($this->token, "token", $errors);
        $this->validateParameter($this->street_number, "street_number", $errors);
        $this->validateParameter($this->street_name, "street_name", $errors);
        $this->validateParameter($this->street_suffix, "street_suffix", $errors);
        $this->validateParameter($this->city, "city", $errors);
        $this->validateParameter($this->state, "state", $errors);
        $this->validateParameter($this->zipcode, "zipcode", $errors);

        if (!empty($errors)) {
            throw new MissingParameterException($errors);
        }
    }


}