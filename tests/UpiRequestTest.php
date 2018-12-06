<?php

namespace Tests;

use Estated\Requests\UpiRequest;
use PHPUnit\Framework\TestCase;
use Estated\Exceptions\MissingParameterException;
use Tests\Mocks\MockGuzzleResponse;
use Tests\Mocks\MockEstatedClient;


class UpiRequestTest extends TestCase
{
    protected const TOKEN = 'secret123';
    protected const UPI = 'US-13435-234-N';
    protected const EXPECTED_REQUEST_URL = "https://api.estated.com/property/v3?token=secret123&upi=US-13435-234-N";
    protected const FORMAT = 'xml';

    protected $mockClient;

    public function test_BuildRequest_BuildsValidRequestUrl()
    {
        try {
            $request = new UpiRequest([
                'token' => self::TOKEN,
                'upi' => self::UPI,
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
        $request = new UpiRequest([
            'upi' => self::UPI,
        ]);
    }

    public function test_Constructor_DoesNotThrowExceptionWhenIncludingOptionalParameter()
    {
        try {
            $request = new UpiRequest([
                'token' => self::TOKEN,
                'upi' => self::UPI,
                'format' => self::FORMAT
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
            $request = new UpiRequest([
                'token' => self::TOKEN,
                'upi' => self::UPI,
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