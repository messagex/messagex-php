<?php


namespace PhpApiClient\Models;


class BaseModel
{
    /**
     * Parse JSON response to key value pairs.
     *
     * @param $data
     * @return \stdClass
     */
    public function parseResponse($data)
    {
        $res = new \stdClass;

        $data = json_decode($data);
        foreach ($data->data as $key=>$value) {
            $res->$key = $value;
        }

        return $res;
    }

    public function parseSuccess($data)
    {
        $res = new \stdClass;

        $data = json_decode($data);
        foreach ($data as $key=>$value) {
            $res->$key = $value;
        }

        return $res;
    }
}