<?php

/**
 * Parse JSON success response into an object.
 *
 * @param $data
 * @return stdClass
 */
function parseSuccess($data)
{
    $res = new \stdClass;

    $data = json_decode($data);
    foreach ($data as $key=>$value) {
        $res->$key = $value;
    }

    return $res;
}

/**
 * Parse response data from JSON into an object.
 *
 * @param $data
 * @return stdClass
 */
function parseResponse($data)
{
    $res = new \stdClass;

    $data = json_decode($data);
    foreach ($data->data as $key=>$value) {
        $res->$key = $value;
    }

    return $res;
}