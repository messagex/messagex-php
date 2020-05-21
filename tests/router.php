<?php

$r = new Router();
$r->processRequest();

class Router
{
    private $method;
    private $uri;
    private $protocol;
    private $data;
    private $requestIndex;


    public function __construct()
    {
        $this->logger('--------- constructing');
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->protocol = $_SERVER['SERVER_PROTOCOL'];

        $this->requestIndex = $this->method .' '. $this->uri;

        $this->data = $this->parseInput();
    }

    private function getRequestMap()
    {
        return [
            'POST /authorise' => 'authorise.php',
        ];
    }

    public function processRequest()
    {
        if (array_key_exists($this->requestIndex, $this->getRequestMap()))
        {
            $this->logger("------------- request made: ". $this->requestIndex);
            include (__DIR__ .'/Factories/'. $this->getRequestMap()[$this->requestIndex]);

            $this->sendResponse($response);
        }

        $this->sendResponse($this->data);
    }




    private function sendResponse($response)
    {
        http_response_code($response['statusCode']);
        header('Content-Type', 'application/json');
        echo $response['body'];
        exit;
    }

    private function parseInput()
    {
        $data = file_get_contents('php://input');

        return json_decode($data, true);
    }

    private function logger($msg)
    {
        file_put_contents('/tmp/phpd.log', date('Y-m-d H:i:s') . ' - ' . print_r($msg, true) . "\n", FILE_APPEND);
    }
}