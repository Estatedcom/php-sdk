<?php

namespace Estated\Requests;

use Estated\Clients\iEstatedClient;
use Estated\Exceptions\MissingParameterException;


class UpiRequest extends BaseRequest
{
    protected $upi;

    public function __construct($args, iEstatedClient $client = null)
    {
        parent::__construct($args, $client);
    }

    public function buildRequest()
    {
        $requestUrl = self::ENDPOINT_URL . 'token=' . $this->token . '&upi=' . rawurlencode($this->upi);

        if ($this->format) {
            $requestUrl .= '&format=' . rawurlencode($this->format);
        }

        return $requestUrl;
    }

    public function validate()
    {
        $errors = "";

        $this->validateParameter($this->token, "token", $errors);
        $this->validateParameter($this->upi, "upi", $errors);

        if (!empty($errors)) {
            throw new MissingParameterException($errors);
        }
    }
}