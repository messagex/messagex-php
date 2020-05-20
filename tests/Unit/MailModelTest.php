<?php

namespace tests\Unit;

use PhpApiClient\Client;
use PHPUnit\Framework\TestCase;
use PhpApiClient\Models\Mail;

class MailModelTest extends TestCase
{
    public function testSendSuccess()
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
        $client = new Client('abc', '123');
        $mail = new Mail($client);
        $response = $mail->send($payload);

        $this->assertEquals($response->success, true);
    }

    public function DISABLEDtestSendFailure()
    {
        $payload = [
            "froml" => [
                "address" => "damien.buttler@smsglobal.com",
                "name" => "MessageX"
            ],
        ];
        $client = new Client('abc', '123');
        $mail = new Mail($client);
        $response = $mail->send($payload);

        $this->assertEquals($response->success, false);
    }
}