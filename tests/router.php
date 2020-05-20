<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$protocol = $_SERVER['SERVER_PROTOCOL'];

$request = $method .' '. $uri;

logger("request made: $request");
$requestMap = [
    'POST /authorise' => 'authorise.php',
];

if (!array_key_exists($request, $requestMap)) {
    http_response_code(404);
}

include(__DIR__ .'/Factories/'. $requestMap[$request]);

http_response_code($response['statusCode']);
echo $response['body'];

logger($response['body']);



function logger($msg)
{
    file_put_contents('/tmp/phpd.log', date('Y-m-d H:i:s') .' - '. print_r($msg, true) ."\n", FILE_APPEND);
}