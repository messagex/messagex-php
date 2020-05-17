<?php

namespace PhpApiClient\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class RestClient
{
    protected $version = '';
    protected $host = 'http://localhost:8000/api/';

    public $client;

    public function __construct()
    {
        $host = $this->host . $this->version;

        $this->client = new Client([
            'base_uri' => $host,
            'timeout' => 2.0,
            'headers' => [
                'Accept'     => 'application/json',
                'Content-Type'     => 'application/json',
            ],
            'http_errors' => false, // $response will never be populated if left as true.
        ]);
    }

    public function makeRequest(string $method, string $path, array $payload=[])
    {
        try {
            $response = $this->client->request($method, $path, ['json' => $payload]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        if (!isset($response)) {
            $msg = 'There is an issue connecting to Messagex Api';
            throw new \Exception($msg);
        }

        return $response;
    }
}
