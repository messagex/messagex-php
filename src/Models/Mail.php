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

         Client::logger($this->client->statusCode);
         if ($this->client->statusCode == 200) {
             Client::logger($this->client->body);
             $res = $this->client->extractJson($this->client->body);

             return $res->success;
         } else {
             return false;
         }
    }
}
