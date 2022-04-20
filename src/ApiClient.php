<?php

namespace Binarycaster\Binarysms;

use GuzzleHttp\Client;

abstract class ApiClient
{
    private $client;
    protected $baseUri;
    protected $endpoint = '';
    protected $params = [];
    protected $data;
    protected $paginator;
    protected $headers = [];

    public function __construct()
    {
        $this->baseUri = 'https://smscore.binarycaster.net';
        $this->client = $this->buildClient();
    }

    private function buildClient()
    {
        return new Client([
            'base_uri' => $this->baseUri,
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function setParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->params[$key] = $value;
        }

        return $this;
    }

    public function getParams()
    {
        $params = [];

        if (!empty($this->params)) {
            foreach ($this->params as $key => $value) {
                $params[$key] = $value;
            }
        }

        return $params;
    }

    /**
     * Execute the request
     *
     * @param string $url Endpoint
     * @param array|null Request parameters
     *
     * @var array
     */
    private function exec($url, $params = null)
    {
        $method = strtolower(debug_backtrace()[1]['function']);
        $clientMethod = !in_array($method, ['get', 'post']) ? 'post' : $method;
        $response = $this->client->{$clientMethod}($url, $params);

        return $response;
    }

    public function get($url, $params = null)
    {
        return $this->exec($url, [
            'query' => $params,
            'headers' => $this->getHeaders(),
        ]);
    }

    public function post($url, $contents = null, $multipart = false)
    {
        $params = $contents === null ? ['body' => ''] : ['json' => $contents];

        $params['headers'] = $this->getHeaders();

        return $this->exec($url, $params);
    }

    public function put($url, $contents = null, $multipart = false)
    {
        $contents = $contents + ['_method' => 'PUT'];

        $params = $contents === null ? ['body' => ''] : ['json' => $contents];

        $params['headers'] = $this->getHeaders();

        return $this->exec($url, $params);
    }

    public function patch($url, $contents = null, $multipart = false)
    {
        $contents = $contents + ['_method' => 'PATCH'];

        $params = $contents === null ? ['body' => ''] : ['json' => $contents];

        $params['headers'] = $this->getHeaders();

        return $this->exec($url, $params);
    }

    public function delete($url, $contents = [])
    {
        $contents = $contents + ['_method' => 'DELETE'];

        $params = $contents === [] ? ['body' => ''] : ['json' => $contents];

        $params['headers'] = $this->getHeaders();

        return $this->exec($url, $params);
    }

    private function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders(array $params = [])
    {
        $this->headers = array_merge($this->headers, $params);

        return $this;
    }
}
