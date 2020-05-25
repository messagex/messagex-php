<?php

namespace PhpApiClient;

use GuzzleHttp\Client;

use PhpApiClient\Clients\AuthClient;
use PhpApiClient\Clients\MailClient;

class MessageXAPI
{
    /**
     * @var $authClient
     */
    private $authClient;

    /**
     * @var $mailClient
     */
    private $mailClient;

    /**
     * Rest client to make API requests.
     *
     * @var Client
     */
    protected $restClient;

    /**
     * @var string
     */
    protected $version = '';

    /**
     * @var string
     */
    protected $host = 'http://localhost:8000/api/';

    /**
     * This is the entry point to the SDK. It will use the API keys to login to obtain
     * the bearer token to make authenticated requests.
     *
     * MessageXAPI constructor.
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function __construct(string $apiKey, string $apiSecret)
    {
        $restClient = $this->createClient();
        $bearerToken = $this->login($restClient, $apiKey, $apiSecret);
        $this->restClient = $this->createClient($bearerToken);
    }

    /**
     * Login with API keys to obtain bearer tokens.
     *
     * @param $restClient
     * @param $apiKey
     * @param $apiSecret
     * @return bool
     */
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
        ]);

        return $restClient;
    }
}