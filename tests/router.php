<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$protocol = $_SERVER['SERVER_PROTOCOL'];

$data = parseInput();
logger("====================");
logger($data);
logger("====================");
$request = $method .' '. $uri;

$requestMap = [
    'POST /authorise' => 'authorise.php',
];

if (array_key_exists($request, $requestMap)) {
    logger("------------- request made: $request");
    include(__DIR__ .'/Factories/'. $requestMap[$request]);

    sendResponse($response);
}

sendResponse($data);

function sendResponse($response)
{
    http_response_code($response['statusCode']);
    header('Content-Type', 'application/json');
    echo $response['body'];
    exit;
}

function parseInput()
{
    $data = file_get_contents('php://input');

    return json_decode($data, true);
}

function logger($msg)
{
    file_put_contents('/tmp/phpd.log', date('Y-m-d H:i:s') .' - '. print_r($msg, true) ."\n", FILE_APPEND);
}