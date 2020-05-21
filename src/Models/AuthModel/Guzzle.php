<?php


namespace PhpApiClient\Models\AuthModel;


class Guzzle
{
    protected $restClient;

    public function __construct($restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * Log into host to retrieve bearer token.
     *
     * @param $apiKey
     * @param $apiSecret
     * @return mixed
     */
    public function getBearerToken($apiKey, $apiSecret)
    {
        $payload = ['apiKey' => $apiKey, 'apiSecret' => $apiSecret];
        $response = $this->restClient->request('POST', 'authorise', ['json' => $payload]);

        if ($response->getStatusCode() == 201) {
            return $response->getBody();
        }

        return false;
    }
}