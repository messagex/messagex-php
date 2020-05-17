<?php


namespace PhpApiClient\models;

use PhpApiClient\RestClient\RestClient;


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
        $response = $this->client->makeRequest($method, $path, $payload);

        $this->statusCode = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
        $this->body = (string)$response->getBody();
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
        return $this->body;
    }

    public function populateModel($json)
    {
        $json = json_decode($json);
        foreach ($json->data as $key=>$value) {
            $this->$key = $value;
        }
    }
}