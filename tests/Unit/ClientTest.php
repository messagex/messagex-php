<?php

namespace tests\Unit;

use PHPUnit\Framework\TestCase;
use PhpApiClient\Client;
use PhpApiClient\Models\Mail;

class ClientTest extends TestCase
{
    public function testConstructor()
    {
        $c = new Client('abc', '123');

        $instance = $c instanceOf Client;

        $this->assertEquals(true, $instance);
    }

    public function testMailInstance()
    {
        $c = new Client('abc', '123');
        $mail = $c->mail();

        $instance = $mail instanceOf Mail;

        $this->assertEquals(true, $instance);
    }

    public function testRequest()
    {
        $payload = [
            'statusCode' => 200,
            'body' => '{
                "success": true
             }'
        ];

        $c = new Client('abc', '123');
        $response = $c->request('POST', 'mail/send', $payload);

        $this->assertEquals($response, 200);
    }
}