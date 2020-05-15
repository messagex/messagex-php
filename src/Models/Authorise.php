<?php

namespace PhpApiClient\Models;

use PhpApiClient\Client;


class Authorise extends BaseModel
{
    protected $client;

    protected $response;

    public function login(string $apiKey, string $apiSecret)
    {
         Client::logger($apiKey .' - '. $apiSecret);
         $this->makeRequest('POST', 'authorise', ['apiKey' => $apiKey, 'apiSecret' => $apiSecret]);

         if ($this->statusCode == 201) {
             Client::logger('returning value');
             Client::logger($this->getBody());
             return 'hi';//$this->getBody();
         } else {
             die("failed. Status code: ". $this->statusCode ."\n");
         }
    }
}
