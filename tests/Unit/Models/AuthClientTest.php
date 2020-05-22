<?php

namespace tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use PhpApiClient\Models\AuthClient;

class AuthClientTest extends TestCase
{
    public function testGetBearerToken()
    {
        $mock = new MockHandler([
            new Response(201, [], '{"data": {"id": 1, "bearerToken": "asdsjsdlkfjsdlkfjs"}}'),
            new Response(401, [], '{"message": "The given data is invalid"}'),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $restClient = new Client(['handler' => $handlerStack, 'http_errors' => false]);

        $authClient = new AuthClient($restClient);

        // Test successful request.
        $response = $authClient->getBearerToken('apiKey', 'apiSecret');
        $this->assertEquals($response, 'asdsjsdlkfjsdlkfjs');

        // Test failed request.
        $response = $authClient->getBearerToken('apiKey', 'apiSecret');
        $this->assertEquals($response, false);
    }
}