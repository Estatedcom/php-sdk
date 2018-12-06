<?php

namespace Tests;

use Estated\Requests\ApnFipsRequest;
use PHPUnit\Framework\TestCase;
use Estated\Exceptions\MissingParameterException;
use Tests\Mocks\MockEstatedClient;
use Tests\Mocks\MockGuzzleResponse;

class ApnFipsRequestTest extends TestCase
{
    protected const TOKEN = 'secret123';
    protected const APN = 'US-02434';
    protected const FIPS = '06037';
    protected const EXPECTED_REQUEST_URL = "https://api.estated.com/property/v3?token=secret123&apn=US-02434&fips=06037";
    protected const FORMAT = 'xml';

    protected $mockClient;

    public function test_BuildRequest_BuildsValidRequestUrl()
    {
        try {
            $request = new ApnFipsRequest([
                'token' => self::TOKEN,
                'apn' => self::APN,
                'fips' => self::FIPS
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
        $request = new ApnFipsRequest([
            'apn' => self::APN,
            'fips' => self::FIPS
        ]);
    }

    public function test_Constructor_DoesNotThrowExceptionWhenIncludingOptionalParameter()
    {
        try {
            $request = new ApnFipsRequest([
                'token' => self::TOKEN,
                'apn' => self::APN,
                'fips' => self::FIPS,
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
            $request = new ApnFipsRequest([
                'token' => self::TOKEN,
                'apn' => self::APN,
                'fips' => self::FIPS
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
