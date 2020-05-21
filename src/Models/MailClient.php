<?php


namespace PhpApiClient\Models;

use PhpApiClient\Models\MailModel\Guzzle;
use PhpApiClient\Models\MailModel\Mail;

class MailClient
{
    private $guzzle;
    private $model;

    public function __construct($restClient)
    {
        $this->guzzle = new Guzzle($restClient);
        $this->model = new Mail;
    }

    public function send($payload)
    {
        $response = $this->guzzle->send($payload);

        if (!$response) {
            return;
        }

        return $this->model->parseSuccess($response);
    }
}