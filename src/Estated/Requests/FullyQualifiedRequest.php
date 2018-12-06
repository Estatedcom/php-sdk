<?php

namespace Estated\Requests;

use Estated\Exceptions\MissingParameterException;


/**
 * Class FullyQualifiedRequest
 *
 * @package Estated\Requests
 */
class FullyQualifiedRequest extends BaseRequest
{

    /**
     * @var string The name of the street.
     */
    protected $street_name;

    /**
     * @var string The suffix of the street.
     */
    protected $street_suffix;

    /**
     * @var int The number on the street.
     */
    protected $street_number;

    /**
     * @var string The name of the city.
     */
    protected $city;

    /**
     * @var string The 2-char abbreviation of the state.
     */
    protected $state;

    /**
     * @var int The number corresponding to the unit of the property.
     */
    protected $unit_number;

    /**
     * @var string The unit type of the property (i.e. 'apt' for apartment).
     */
    protected $unit_type;

    /**
     * @var string The direction of the street.
     */
    protected $street_direction;

    /**
     * @var string The zip code for the property.
     */
    protected $zipcode;

    /**
     * Creates a new FullyQualified request object.
     *
     * @param $args
     * @param $client
     * @throws MissingParameterException
     */
    function __construct($args, $client = null){
        parent::__construct($args, $client);
    }

    /**
     * Validates that all the required parameters are supplied.
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

        if (!empty($errors)) {
            throw new MissingParameterException($errors);
        }
    }

    /**
     * Builds a complete Fully Qualified request URL.
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
            '&state=' . rawurlencode($this->state);

        if ($this->unit_number) {
            $requestUrl .= '&unit_number=' . rawurlencode($this->unit_number);
        }

        if ($this->street_direction) {
            $requestUrl .= '&street_direction=' . rawurlencode($this->street_direction);
        }

        if ($this->zipcode) {
            $requestUrl .= '&zipcode=' . rawurlencode($this->zipcode);
        }

        if ($this->format) {
            $requestUrl .= '&format=' . rawurlencode($this->format);
        }

        return $requestUrl;
    }
}
