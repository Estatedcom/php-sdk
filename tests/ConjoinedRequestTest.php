<?php

namespace Tests;

use Estated\Requests\ConjoinedRequest;
use PHPUnit\Framework\TestCase;
use Estated\Exceptions\MissingParameterException;
use Tests\Mocks\MockEstatedClient;
use Tests\Mocks\MockGuzzleResponse;


class ConjoinedRequestTest extends TestCase
{
    protected const TOKEN = 'secret123';
    protected const UNIT_NUMBER = 101;
    protected const UNIT_TYPE = 'apt';
    protected const STREET_NUMBER = 220;
    protected const STREET_NAME = 'S Rodeo';
    protected const STREET_SUFFIX = 'Drive';
    protected const CITY = "Beverly Hills";
    protected const STATE = "CA";
    protected const ZIPCODE = "90212";
    protected const EXPECTED_REQUEST_URL = "https://api.estated.com/property/v3?token=secret123&street_number=220&street_name=S%20Rodeo&street_suffix=Drive&city=Beverly%20Hills&state=CA&zipcode=90212";

    protected $mockClient;

    public function test_BuildRequest_BuildsValidRequestUrl()
    {

        try {
            $request = new ConjoinedRequest([
                'token' => self::TOKEN,
                'street_number' => self::STREET_NUMBER,
                'street_name' => self::STREET_NAME,
                'street_suffix' => self::STREET_SUFFIX,
                'city' => self::CITY,
                'state' => self::STATE,
                'zipcode' => self::ZIPCODE
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
        $request = new ConjoinedRequest([
            'token' => self::TOKEN,
            'street_number' => self::STREET_NUMBER,
            'street_name' => self::STREET_NAME,
            'street_suffix' => self::STREET_SUFFIX,
            'city' => self::CITY,
            'state' => self::STATE
        ]);
    }

    public function test_Constructor_DoesNotThrowExceptionWhenIncludingOptionalParameters()
    {
        try {
            $request = new ConjoinedRequest([
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
            $request = new ConjoinedRequest([
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
