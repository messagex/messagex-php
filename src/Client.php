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
        self::logger("request made: $method - $path");
        $response = $this->restClient->makeRequest($method, $path, $payload);

        $this->statusCode = $response->getStatusCode();
        $this->reasonPhrase = $response->getReasonPhrase();
        $this->body = (string)$response->getBody();
        self::logger('statusCode: '. $this->statusCode);

        return $this->statusCode;
    }

    /**
     * Logger for dev. @todo remove
     *
     * @param $msg
     */
    public static function logger($msg)
    {
        $logFile = __DIR__.'/../../api/storage/logs/laravel-2020-05-20.log';
        $logFile = '/tmp/phpd.log';
        file_put_contents($logFile, "sdk--  ". print_r($msg, true) ." \n", FILE_APPEND);
    }

}