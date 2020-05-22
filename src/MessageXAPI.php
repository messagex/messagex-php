<?php

namespace PhpApiClient;

use GuzzleHttp\Client;

use PhpApiClient\Clients\AuthClient;
use PhpApiClient\Clients\MailClient;

class MessageXAPI
{
    private $authClient;
    private $mailClient;

    protected $restClient;

    protected $version = '';
    protected $host = 'http://localhost:8000/api/';

    public function __construct(string $apiKey, string $apiSecret)
    {
        $restClient = $this->createClient();
        $bearerToken = $this->login($restClient, $apiKey, $apiSecret);
        $this->restClient = $this->createClient($bearerToken);
    }

    private function login($restClient, $apiKey, $apiSecret)
    {
        $bearerToken = $this->authClient($restClient)->getBearerToken($apiKey, $apiSecret);

        return $bearerToken;
    }

    /**
     * Initialise $authClient.
     *
     * @param $restClient
     * @return Clients\AuthClient
     */
    private function authClient($restClient)
    {
        if (!$this->authClient) {
            $this->authClient = new AuthClient($restClient);
        }

        return $this->authClient;
    }

    /**
     * Instantiate mail model.
     *
     * @return MailClient
     */
    public function mail()
    {
        if (!$this->mailClient) {
            $this->mailClient = new MailClient($this->restClient);
        }

        return $this->mailClient;
    }

    /**
     * Instantiate client for to make requests to remote host.
     *
     * @param string $bearerToken
     * @return Client
     */
    public function createClient(string $bearerToken=null)
    {
        $host = $this->host . $this->version;

        $restClient = new Client([
            'base_uri' => $host,
            'timeout' => 2.0,
            'headers' => [
                'Accept'     => 'application/json',
                'Content-Type'     => 'application/json',
                'Authorization'    => 'Bearer '. $bearerToken,
            ],
            'http_errors' => false, // $response will never be populated if left as true on non 2XX responses.
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