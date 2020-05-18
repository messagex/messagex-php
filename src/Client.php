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

    /**
     * Instantiate mail model.
     *
     * @return Mail
     */
    public function mail()
    {
        return new Mail($this);
    }

    /**
     * Make request to host and catch response.
     *
     * @param string $method
     * @param string $path
     * @param array $payload
     * @throws \Exception
     */
    public function request(string $method, string $path, array $payload=[])
    {
        $response = $this->restClient->makeRequest($method, $path, $payload);

        $this->statusCode = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
        $this->body = (string)$response->getBody();
    }

    /**
     * Parse Json data response with key value pairs.
     *
     * @param $data
     */
    public function populateModel($data)
    {
        $data = json_decode($data);
        foreach ($data->data as $key=>$value) {
            $this->$key = $value;
        }
    }

    /**
     * Parse JSON response to key value pairs.
     *
     * @param $data
     * @return \stdClass
     */
    public function extractData($data)
    {
        $res = new \stdClass;

        $data = json_decode($data);
        foreach ($data as $key=>$value) {
            $res->$key = $value;
        }

        return $res;
    }

    /**
     * Logger for dev. @todo remove
     *
     * @param $msg
     */
    public static function logger($msg)
    {
        $logFile = __DIR__.'/../../api/storage/logs/laravel-2020-05-18.log';
        file_put_contents($logFile, "sdk--  ". print_r($msg, true) ." \n", FILE_APPEND);
    }

}