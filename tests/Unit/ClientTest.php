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
            "from" => [
                "address" => "damien.buttler@smsglobal.com",
                "name" => "MessageX"
            ],
            "to" => [
                [
                    "address" => "damien.buttler@smsglobal.com",
                    "name" => "testtesttest"
                ],
            ],
            "subject" => "Transactional Email 1",
            "content" => [
                [
                    "type" => "text/html",
                    "body" => "<body>This is the body. Go to <a href=\"http://theage.com.au?one=two\">The Age</a> to see the news. Or go to <a href=\"https://google.com\">Google</a> to search for more</body>"
                ],
                [
                    "type" => "text/plain",
                    "body" => "AAA Plaintext email content."
                ]
            ],
        ];

        $c = new Client('abc', '123');
        $response = $c->request('POST', 'mail/send', $payload);

        $this->assertEquals($response, 200);
    }
}