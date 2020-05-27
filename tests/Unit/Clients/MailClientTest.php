<?php

namespace tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use MessageX\Clients\MailClient;

class MailClientTest extends TestCase
{
    public function testSendMail()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"success": true}'),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $restClient = new Client(['handler' => $handlerStack]);

        $mailClient = new MailClient($restClient);
        $response = $mailClient->send([]);

        $this->assertEquals($response->success, true);
    }
}