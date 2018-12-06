<?php

namespace Tests\Mocks;

use Estated\Clients\iEstatedClient;


class MockEstatedClient implements iEstatedClient
{
    public function get($requestUrl)
    {
        return new MockGuzzleResponse(MockGuzzleResponse::EXPECTED_HTTP_STATUS_CODE, MockGuzzleResponse::EXPECTED_HEADERS, MockGuzzleResponse::EXPECTED_BODY);
    }
}