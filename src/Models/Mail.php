<?php

namespace PhpApiClient\Models;

use PhpApiClient\Client;


class Mail
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function send(array $payload)
    {
        $this->client->request('POST', 'mail/send', $payload);
        $res = $this->client->extractJson($this->client->body);

        if ($this->client->statusCode == 200) {
            Client::logger($this->client->body);

            return $res;

        } elseif ($this->client->statusCode == 422) {
            $res->success = false;
            return $res;
        } else {
            return false;
        }
    }
}
