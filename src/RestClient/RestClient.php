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
        $bearerToken = $this->getBearerToken($apiKey, $apiSecret);
        // Login with bearer token
        $this->createClient($bearerToken);
    }

    /**
     * Log into host to retrieve bearer token.
     *
     * @param $apiKey
     * @param $apiSecret
     * @return |null
     * @throws \Exception
     */
    public function getBearerToken($apiKey, $apiSecret)
    {
        $response = $this->makeRequest('POST', 'authorise', ['apiKey' => $apiKey, 'apiSecret' => $apiSecret]);

        if ($response->getStatusCode() == 201) {
            $bearerToken = $this->retrieveToken($response->getbody());
            file_put_contents('/tmp/phpd.log', '--------- '. $bearerToken, FILE_APPEND);
        } else {
            throw new \Exception('Unable to login with API credentials.');
        }

        file_put_contents('/tmp/phpd.log', '--------- HERE HERE HERE', FILE_APPEND);
        return $bearerToken;
    }

    /**
     * Instantiate client for to make requests to remote host.
     *
     * @param string|null $bearerToken
     */
    public function createClient(string $bearerToken=null)
    {
        $host = $this->getHost() . $this->version;

        if (getenv('environment') == 'testing') {
            $host = 'localhost:8889';
        }

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

    public function getHost()
    {
        if ($devHost = getenv('messagexHost')) {
            return $devHost;
        }

        return $this->host;
    }

    /**
     * Retrieve bearer token from authorisation response.
     *
     * @param $json
     * @return |null
     */
    public function retrieveToken($json)
    {
        $json = json_decode($json);

        return $json->data->bearerToken ?? null;
    }

    /**
     * Make request to remote host.
     *
     * @param string $method
     * @param string $path
     * @param array $payload
     * @return mixed
     * @throws \Exception
     */
    public function makeRequest(string $method, string $path, array $payload=[])
    {
        try {
            $response = $this->client->request($method, $path, ['json' => $payload]);
        } catch (RequestException $e) {
            throw new \Exception('There is an issue connecting to Messagex Api');
        }

        return $response;
    }
}
