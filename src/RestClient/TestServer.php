<?php

namespace PhpApiClient\RestClient;

class TestServer extends \Thread
{
    public function start()
    {
        passthru('php -S localhost:8888');
    }
}