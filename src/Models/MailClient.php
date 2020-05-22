<?php

namespace PhpApiClient\Models;


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
        $data = \parseSuccess($response->getBody());

        return $data;
    }
}