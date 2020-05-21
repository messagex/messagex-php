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
            'responseCode' => 200,
            'responseBody' => '{
                "success": true
             }'
        ];
        $client = new Client('abc', '123');
        $mail = new Mail($client);
        $response = $mail->send($payload);

        $this->assertEquals($response->success, true);
    }

    public function testSendFailure()
    {
        $payload = [
            'responseCode' => 422,
            'responseBody' => '{
                "success": false
             }'
        ];
        $client = new Client('abc', '123');
        $mail = new Mail($client);
        $response = $mail->send($payload);

        $this->assertEquals($response->success, false);
    }
}