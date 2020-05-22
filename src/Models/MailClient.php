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
        $data = $this->parseSuccess($response->getBody());

        return $data;
    }

    public function parseSuccess($data)
    {
        $res = new \stdClass;

        $data = json_decode($data);
        foreach ($data as $key=>$value) {
            $res->$key = $value;
        }

        return $res;
    }
}