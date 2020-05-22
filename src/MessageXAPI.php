<?php

namespace PhpApiClient;

use PhpApiClient\Models\MailClient;

class MessageXAPI
{
    protected $authRestClient;

    protected $version = '';
    protected $host = 'http://localhost:8000/api/';

    public function __construct(string $apiKey, string $apiSecret)
    {
        $restClient = $this->createClient();
        $bearerToken = $this->login($restClient, $apiKey, $apiSecret);
        $this->authRestClient = $this->createClient($bearerToken);
    }

    private function login($restClient, $apiKey, $apiSecret)
    {
        $bearerToken = $this->authClient($restClient)->getBearerToken($apiKey, $apiSecret);

        return $bearerToken;
    }

    private function authClient($restClient)
    {
        return new Models\AuthClient($restClient);
    }

    /**
     * Instantiate mail model.
     *
     * @return MailClient
     */
    public function mail()
    {
        return new MailClient($this->authRestClient);
    }

    /**
     * Instantiate client for to make requests to remote host.
     *
     * @param string|null $bearerToken
     */
    public function createClient(string $bearerToken=null)
    {
        $host = $this->host . $this->version;

        $restClient = new \GuzzleHttp\Client([
            'base_uri' => $host,
            'timeout' => 2.0,
            'headers' => [
                'Accept'     => 'application/json',
                'Content-Type'     => 'application/json',
                'Authorization'    => 'Bearer '. $bearerToken,
            ],
            'http_errors' => false, // $response will never be populated if left as true.
        ]);

        return $restClient;
    }

    /**
     * Logger for dev. @todo remove
     *
     * @param $msg
     */
    public static function logger($msg)
    {
        $logFile = '/tmp/phpd.log';
        file_put_contents($logFile, "sdk--  ". print_r($msg, true) ." \n", FILE_APPEND);
    }

}