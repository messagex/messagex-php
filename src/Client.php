<?php

namespace PhpApiClient;

use PhpApiClient\Models\Mail;
use PhpApiClient\RestClient\RestClient;

class Client
{
    protected $restClient;

    public $body;
    public $statusCode;
    public $reasonPhrase;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->restClient = new RestClient($apiKey, $apiSecret);
    }

    public function mail()
    {
        return new Mail($this);
    }

    public function request(string $method, string $path, array $payload=[])
    {
        $response = $this->restClient->makeRequest($method, $path, $payload);

        $this->statusCode = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
        $this->body = (string)$response->getBody();
    }

    public function populateModel($data)
    {
        $data = json_decode($data);
        foreach ($data->data as $key=>$value) {
            $this->$key = $value;
        }
    }

    public function extractData($data)
    {
        $res = new \stdClass;

        $data = json_decode($data);
        foreach ($data as $key=>$value) {
            $res->$key = $value;
        }

        return $res;
    }

    public static function logger($msg)
    {
        $logFile = __DIR__.'/../../api/storage/logs/laravel-2020-05-18.log';
        file_put_contents($logFile, "sdk--  ". print_r($msg, true) ." \n", FILE_APPEND);
    }

}