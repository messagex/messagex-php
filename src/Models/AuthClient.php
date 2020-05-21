<?php


namespace PhpApiClient\Models;

use PhpApiClient\Models\AuthModel\Guzzle;
use PhpApiClient\Models\AuthModel\Auth;

class AuthClient
{
    private $guzzle;
    private $model;

    public function __construct($restClient)
    {
        $this->guzzle = new Guzzle($restClient);
        $this->model = new Auth;
    }

    public function getBearerToken($apiKey, $apiSecret)
    {
        $response = $this->guzzle->getBearerToken($apiKey, $apiSecret);

        if (!$response) {
            return;
        }

        $model = $this->model->parseResponse($response);

        return $model->bearerToken;
    }
}