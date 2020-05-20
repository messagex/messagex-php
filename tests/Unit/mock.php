<?php

class TalksToApi
{
    public $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function talkToApi($message)
    {
        return $this->client->post('url', ['message' => $message]);
    }
}


class TalksToApiTest extends TestCase
{
    public function testAPI()
    {
        $guzzleHandler = new GuzzleHttp\Handler\MockHandler();

        $guzzleClient = new \GuzzleHttp\Client([
            'handler' => \GuzzleHttp\HandlerStack::create($guzzleHandler),
        ]);

        $talksToApi = new TalksToApi($guzzleClient);
        $guzzleHandler->append(new Response(200, [], json_encode(['answer' => 42])));

        $response = $talksToApi->talkToApi('What is the meaning of life?');
    }
}