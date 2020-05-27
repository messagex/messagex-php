<?php

namespace MessageX\Clients;

/**
 * This MailClient class will make mail related requests.
 *
 * Class MailClient
 * @package PhpApiClient\Clients
 */

class MailClient
{
    private $restClient;

    public function __construct($restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * Make request to send an email.
     *
     * @param $payload
     * @return \stdClass
     */
    public function send($payload)
    {
        $response = $this->restClient->request('POST', 'mail/send', ['json' => $payload]);
        $data = parseSuccess($response->getBody());

        return $data;
    }
}