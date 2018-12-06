<?php

namespace Estated\Requests;

use Estated\Clients\iEstatedClient;
use Estated\Exceptions\MissingParameterException;


class ApnFipsRequest extends BaseRequest
{
    protected $fips;

    protected $apn;

    public function __construct($args, iEstatedClient $client = null)
    {
        parent::__construct($args, $client);
    }

    public function buildRequest()
    {
        $requestUrl = self::ENDPOINT_URL . 'token=' . $this->token . '&apn=' . rawurlencode($this->apn) . '&fips=' . rawurlencode($this->fips);

        if ($this->format) {
            $requestUrl .= '&format=' . rawurlencode($this->format);
        }

        return $requestUrl;
    }

    public function validate()
    {
        $errors = "";

        $this->validateParameter($this->token, "token", $errors);
        $this->validateParameter($this->apn, "apn", $errors);
        $this->validateParameter($this->fips, "fips", $errors);

        if (!empty($errors)) {
            throw new MissingParameterException($errors);
        }
    }
}
