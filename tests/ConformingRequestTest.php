<?php

namespace Tests;

use Estated\Requests\ConformingRequest;
use Estated\Exceptions\MissingParameterException;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\MockEstatedClient;
use Tests\Mocks\MockGuzzleResponse;


class ConformingRequestTest extends TestCase
{
    protected const TOKEN = 'secret123';
    protected const ADDRESS = "220 S Rodeo Drive";
    protected const CITY = "Beverly Hills";
    protected const STATE = "CA";
    protected const ZIPCODE = "90212";
    protected const EXPECTED_REQUEST_URL = "https://api.estated.com/property/v3?token=secret123&address=220%20S%20Rodeo%20Drive&city=Beverly%20Hills&state=CA";

    protected $mockClient;

    public function test_BuildRequest_BuildsValidRequestUrl()
    {
        try {
            $request = new ConformingRequest([
                'token' => self::TOKEN,
                'address' => self::ADDRESS,
                'city' => self::CITY,
                'state' => self::STATE
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
        $request = new ConformingRequest([
            'address' => self::ADDRESS,
            'city' => self::CITY
        ]);
    }

    public function test_Constructor_DoesNotThrowExceptionWhenIncludingOptionalParameter()
    {
        try {
            $request = new ConformingRequest([
                'token' => self::TOKEN,
                'address' => self::ADDRESS,
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
            $request = new ConformingRequest([
                'token' => self::TOKEN,
                'address' => self::ADDRESS,
                'city' => self::CITY,
                'state' => self::STATE
            ], $this->mockClient);
        }
        catch (MissingParameterException $e) {
            $this->fail("Unexpected MissingParameterException thrown");
        }

        $response = $request->send();

        $this->assertEquals($response->httpStatusCode(),  MockGuzzleResponse::EXPECTED_HTTP_STATUS_CODE);
        $this->assertEquals($response->headers(), MockGuzzleResponse::EXPECTED_HEADERS);
        $this->assertEquals($response->body(), MockGuzzleResponse::EXPECTED_BODY);
    }

}
