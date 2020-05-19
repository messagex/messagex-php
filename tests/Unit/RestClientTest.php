<?php

namespace tests\Unit;

use PHPUnit\Framework\TestCase;
use PhpApiClient\RestClient\RestClient;

class RestClientTest extends TestCase
{
//    public function testGetBearerToken()
//    {
//        $this->assertEquals()
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