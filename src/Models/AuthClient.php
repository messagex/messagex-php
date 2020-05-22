<?php

namespace PhpApiClient\Models;


class AuthClient
{
    protected $restClient;

    public function __construct($restClient)
    {
        $this->restClient = $restClient;
    }

    public function getBearerToken($apiKey, $apiSecret)
    {
        $payload = ['apiKey' => $apiKey, 'apiSecret' => $apiSecret];
        $response = $this->restClient->request('POST', 'authorise', ['json' => $payload]);


        if ($response->getStatusCode() == 201) {
            $data = $this->parseResponse($response->getBody());
            return $data->bearerToken;
        }

        return false;
    }

    public function parseResponse($data)
    {
        $res = new \stdClass;

        $data = json_decode($data);
        foreach ($data->data as $key=>$value) {
            $res->$key = $value;
        }

        return $res;
    }
}