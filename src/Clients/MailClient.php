<?php

namespace PhpApiClient\Clients;


class MailClient
{
    private $restClient;

    public function __construct($restClient)
    {
        $this->restClient = $restClient;
    }

    public function send($payload)
    {
        $response = $this->restClient->request('POST', 'mail/send', ['json' => $payload]);
//        die(var_dump($response->getBody()));
        $data = parseSuccess($response->getBody());

        return $data;
    }
}