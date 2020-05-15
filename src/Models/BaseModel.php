<?php


namespace PhpApiClient\models;

use PhpApiClient\Client\RestClient;


class BaseModel
{
    protected $client;

    protected $statusCode;
    protected $reasonPhrase;
    protected $body;

    public function __construct()
    {
        $this->client = new RestClient();
    }

    protected function makeRequest(string $method, string $path, array $payload=[])
    {
        $this->response = $this->client->makeRequest($method, $path, $payload);

        $this->statusCode = $this->response->getStatusCode();
        $this->reasonPhrase = $this->response->getReasonPhrase();
        $this->body = $this->response->getBody();
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getReasonCode()
    {
        return $this->reasonCode;
    }

    public function getBody()
    {
        return $this->getBody();
    }
}