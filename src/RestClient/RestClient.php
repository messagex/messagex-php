<?php

namespace PhpApiClient\RestClient;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class RestClient
{
    const STATUS_CODE_OK = 200;
    const STATUS_CODE_CREATED = 201;
    const STATUS_CODE_NO_CONTENT = 204;
    const STATUS_CODE_NOT_FOUND = 404;
    const STATUS_CODE_VALIDATION_ERROR = 422;

    protected $version = '';
    protected $host = 'http://localhost:8000/api/';

    public $client;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->createClient();
        $this->getBearerToken($apiKey, $apiSecret);
    }

    protected function getBearerToken($apiKey, $apiSecret)
    {
        $response = $this->makeRequest('POST', 'authorise', ['apiKey' => $apiKey, 'apiSecret' => $apiSecret]);

        if ($response->getStatusCode() == 201) {
            $bearerToken = $this->retrieveToken($response->getbody());

            $this->createClient($bearerToken);
        } else {
            throw new \Exception('Unable to login with API credentials.');
        }
    }

    public function createClient(string $bearerToken=null)
    {
        $host = $this->host . $this->version;

        $this->client = new Client([
            'base_uri' => $host,
            'timeout' => 2.0,
            'headers' => [
                'Accept'     => 'application/json',
                'Content-Type'     => 'application/json',
                'Authorization'    => 'Bearer '. $bearerToken,
            ],
            'http_errors' => false, // $response will never be populated if left as true.
        ]);
    }

    public function retrieveToken($json)
    {
        $json = json_decode($json);

        return $json->data->bearerToken ?? null;
    }

    public function setBearerToken($token)
    {
        $this->client = $this->createClient($token);
    }

    public function makeRequest(string $method, string $path, array $payload=[])
    {
        try {
            $response = $this->client->request($method, $path, ['json' => $payload]);
        } catch (RequestException $e) {
            $msg = 'There is an issue connecting to Messagex Api';
            throw new \Exception($msg);
        }

//        if (!isset($response)) {
//            $msg = 'There is an issue connecting to Messagex Api';
//            throw new \Exception($msg);
//        }

        return $response;
    }
}
