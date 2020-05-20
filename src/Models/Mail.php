<?php

namespace PhpApiClient\Models;

use PhpApiClient\Client;
use PhpApiClient\RestClient\RestClient;


class Mail
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Send mail
     *
     * @param array $payload
     * @return bool
     */
    public function send(array $payload)
    {
        $this->client->request('POST', 'mail/send', $payload);
        $res = $this->client->extractData($this->client->body);

        if ($this->client->statusCode == RestClient::STATUS_CODE_OK) {
            Client::logger($this->client->body);

            return $res;

        } elseif ($this->client->statusCode == RestClient::STATUS_CODE_VALIDATION_ERROR) {
            $res->success = false;
            return $res;
        } else {
            return false;
        }
    }
}
