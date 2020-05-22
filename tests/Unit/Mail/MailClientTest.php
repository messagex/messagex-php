<?php

namespace tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\HandlerStack;
use PhpApiClient\Models\MailClient;
use GuzzleHttp\Psr7\Response;

class MailClientTest extends TestCase
{
    public function testSendMail()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"success": true}'),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $restClient = new Client(['handler' => $handlerStack]);

        $rc = new MailClient($restClient);
        $response = $rc->send([]);

        $this->assertEquals($response->success, true);
    }
}