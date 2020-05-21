<?php


namespace PhpApiClient\Models\MailModel;


class MailHttp
{
    protected $restClient;

    public function __construct($restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * Log into host to retrieve bearer token.
     *
     * @param $payload
     * @return mixed
     */
    public function send($payload)
    {
        $response = $this->restClient->request('POST', 'mail/send', ['json' => $payload]);

        return $response->getBody();
    }
}