<?php

namespace PhpApiClient;

use PhpApiClient\Models\Authorise;

class Client
{
    public $authorise;

    public function __construct()
    {
        $this->authorise = new Authorise;
    }

    public static function logger($msg)
    {
        $logFile = __DIR__.'/../../api/storage/logs/laravel-2020-05-15.log';
        file_put_contents($logFile, "sdk--  ". print_r($msg, true) ." \n", FILE_APPEND);
    }

}