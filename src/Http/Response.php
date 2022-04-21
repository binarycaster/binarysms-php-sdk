<?php

namespace Binarycaster\Binarysms\Http;

class Response
{
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function __call($method, $args)
    {
        if (method_exists($this->response, $method)) {
            return call_user_func_array([$this->response, $method], $args);
        }

        return false;
    }

    public function getParseData()
    {
        $contentType = $this->getMimeType();

        if ($contentType == 'application/json' || $contentType == 'text/json') {
            $contents = $this->responseToJson();
        } else {
            $contents = $this->responseToRaw();
        }

        return $contents;
    }

    /**
     * Get content mime type
     *
     * @return string
     */
    public function getMimeType()
    {
        $header = explode(';', $this->response->getHeader('Content-Type')[0]);

        return $header[0];
    }


    /**
     * Parse raw contents if JSON
     *
     * @param bool $array
     *
     * @return bool|mixed|string
     */
    public function responseToJson($array = false)
    {
        $type = $this->getMimeType();

        if ($type == 'application/json' || $type == 'text/json') {
            $contents = $this->getBody()->getContents();

            if (json_last_error($contents = json_decode($contents, $array)) == JSON_ERROR_NONE) {
                return $contents;
            }
        }

        return false;
    }

    public function responseToRaw()
    {
        return $this;
    }

}
