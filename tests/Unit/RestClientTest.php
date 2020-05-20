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
//        $response->assertStatus(400);
    }
//    public function testGetBearerToken()
//    {
//        $rc = new Client('abc', '123');
//        $bearerToken = $rc->request('POST', 'authorise', []);
//
//        die(var_dump($bearerToken));
////        $this->assertEquals($response->);
//        $response->assertStatus(400);
//    }

    public function testRetrieveToken()
    {
        $token = 'abcdef';

        $json = json_encode(['data' => ['bearerToken' => $token]]);
        $this->assertEquals(
            RestClient::retrieveToken($json),
            $token
        );
    }
}