<?php

namespace PhpApiClient\Clients;

/**
 * This class will is to make a login request to the API to obtain the bearer token for
 * making authenticated requests.
 *
 * Class AuthClient
 * @package PhpApiClient\Clients
 */

class AuthClient
{
    protected $restClient;

    public function __construct($restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * Make a request to the API to get the bearer token.
     *
     * @param $apiKey
     * @param $apiSecret
     * @return bool
     */
    public function getBearerToken($apiKey, $apiSecret)
    {
        $payload = ['apiKey' => $apiKey, 'apiSecret' => $apiSecret];
        $response = $this->restClient->request('POST', 'authorise', ['json' => $payload]);

        if ($response->getStatusCode() == 201) {
            $data = parseResponse($response->getBody());

            return $data->bearerToken;
        }

        return false;
    }
}