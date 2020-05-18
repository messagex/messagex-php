<?php

namespace PhpApiClient\Models;

use PhpApiClient\Client;


class Authorise extends BaseModel
{
    protected $bearerToken;
    protected $refreshToken;
    protected $expiresAt;
    protected $apiKeyId;

    public function login(string $apiKey, string $apiSecret)
    {
         $this->makeRequest('POST', 'authorise', ['apiKey' => $apiKey, 'apiSecret' => $apiSecret]);

         if ($this->statusCode == 201) {
             $this->populateModel($this->getBody());
             return $this;
         } else {
             return false;
         }
    }

    public function getBearerToken()
    {
        return $this->bearerToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function getApiKeyId()
    {
        return $this->apiKeyId;
    }

    public function getExpiryDate()
    {
        return $this->expiresAt;
    }
}
