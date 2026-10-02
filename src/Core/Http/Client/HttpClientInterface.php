<?php

namespace Stella\Core\Http\Client;

use Stella\Core\Http\Response\HttpResponse;

interface HttpClientInterface
{
    public function get(string $url, array $headers = []): HttpResponse;

    public function post(string $url, array $data = [], array $headers = []): HttpResponse;

    public function put(string $url, array $data = [], array $headers = []): HttpResponse;

    public function delete(string $url, array $headers = []): HttpResponse;

    public function request(string $method, string $url, array $options = []): HttpResponse;
}
