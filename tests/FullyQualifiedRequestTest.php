<?php

namespace Tests;

use Estated\Requests\FullyQualifiedRequest;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\MockEstatedClient;
use Tests\Mocks\MockGuzzleResponse;
use Estated\Exceptions\MissingParameterException;


class FullyQualifiedRequestTest extends TestCase
{
    protected const TOKEN = 'secret123';
    protected const UNIT_NUMBER = 101;
    protected const UNIT_TYPE = 'apt';
    protected const STREET_NUMBER = 220;
    protected const STREET_NAME = 'Rodeo';
    protected const STREET_SUFFIX = 'Drive';
    protected const STREET_DIRECTION = 'S';
    protected const CITY = "Beverly Hills";
    protected const STATE = "CA";
    protected const ZIPCODE = "90212";
    protected const EXPECTED_REQUEST_URL = "https://api.estated.com/property/v3?token=secret123&street_number=220&street_name=Rodeo&street_suffix=Drive&city=Beverly%20Hills&state=CA";

    protected $mockClient;

    public function test_BuildRequest_BuildsValidRequestUrl()
    {
        try {
            $request = new FullyQualifiedRequest([
                'token' => self::TOKEN,
                'street_number' => self::STREET_NUMBER,
                'street_name' => self::STREET_NAME,
                'street_suffix' => self::STREET_SUFFIX,
                'city' => self::CITY,
                'state' => self::STATE,
            ]);
        } catch (MissingParameterException $e) {
            $this->fail("Unexpected MissingParameterException thrown");
        }

        if (!empty($request)) {
            $this->assertEquals($request->buildRequest(), self::EXPECTED_REQUEST_URL);
        } else {
            $this->fail("Unexpected Error: Test failed");
        }
    }

    /**
     * @expectedException \Estated\Exceptions\MissingParameterException
     */
    public function test_Constructor_ThrowsExceptionWhenMissingRequiredParameter()
    {
        $request = new FullyQualifiedRequest([
            'token' => self::TOKEN,
            'street_number' => self::STREET_NUMBER,
            'street_name' => self::STREET_NAME,
            'city' => self::CITY,
            'state' => self::STATE
        ]);
    }

    public function test_Constructor_DoesNotThrowExceptionWhenIncludingOptionalParameters()
    {
        try {
            $request = new FullyQualifiedRequest([
                'token' => self::TOKEN,
                'unit_number' => self::UNIT_NUMBER,
                'unit_type' => self::UNIT_TYPE,
                'street_number' => self::STREET_NUMBER,
                'street_name' => self::STREET_NAME,
                'street_suffix' => self::STREET_SUFFIX,
                'city' => self::CITY,
                'state' => self::STATE,
                'zipcode' => self::ZIPCODE
            ]);
        } catch (MissingParameterException $e) {
            $this->fail('Unexpected MissingParameterException thrown');
        }

        $this->assertTrue(true);
    }

    public function test_Send_ReturnsExpectedResponse()
    {
        $request = null;
        $this->mockClient = new MockEstatedClient();

        try {
            $request = new FullyQualifiedRequest([
                'token' => self::TOKEN,
                'street_number' => self::STREET_NUMBER,
                'street_name' => self::STREET_NAME,
                'street_suffix' => self::STREET_SUFFIX,
                'city' => self::CITY,
                'state' => self::STATE,
                'zipcode' => self::ZIPCODE
            ], $this->mockClient);
        } catch (MissingParameterException $e) {
            $this->fail("Unexpected MissingParameterException thrown");
        }

        $response = $request->send();

        $this->assertEquals($response->httpStatusCode(),  MockGuzzleResponse::EXPECTED_HTTP_STATUS_CODE);
        $this->assertEquals($response->headers(), MockGuzzleResponse::EXPECTED_HEADERS);
        $this->assertEquals($response->body(), MockGuzzleResponse::EXPECTED_BODY);
    }
}