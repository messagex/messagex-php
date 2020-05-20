<?php

namespace tests\Unit;

use PHPUnit\Framework\TestCase;
use PhpApiClient\RestClient\RestClient;
use PhpApiClient\RestClient\TestServer;
use PhpApiClient\Client;

class RestClientTest extends TestCase
{
    public function testGetBearerToken()
    {
        $rc = new RestClient('abc', '123');
        $bearerToken = $rc->getBearerToken('abc', '123');

        $this->assertEquals($bearerToken, 'auth-bearer-token-abc123');
    }

    public function testRetrieveToken()
    {
        $token = 'abcdef';

        $json = json_encode(['data' => ['bearerToken' => $token]]);
        $this->assertEquals(
            RestClient::retrieveToken($json),
            $token
        );
    }

    public function testGetHost()
    {
        $rc = new RestClient('abc', '123');
        $this->assertEquals($rc->gethost(), getenv('apiHost'));
    }

    public function testMakeRequest()
    {
        $payload = ['apiKey' => 'abc', 'apiSecret' => '132'];

        $rc = new RestClient('abc', '123');
        $response = $rc->makeRequest('POST', 'authorise', $payload);
        $this->assertEquals($response->getStatusCode(), 201);
    }
}