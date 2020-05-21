<?php


namespace PhpApiClient\Models;

use PhpApiClient\Models\MailModel\MailHttp;
use PhpApiClient\Models\MailModel\Mail;

class MailClient
{
    private $mailHttp;
    private $model;

    public function __construct($restClient)
    {
        $this->mailHttp = new MailHttp($restClient);
        $this->model = new Mail;
    }

    public function send($payload)
    {
        $response = $this->mailHttp->send($payload);

        if (!$response) {
            return;
        }

        return $this->model->parseSuccess($response);
    }
}