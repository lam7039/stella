<?php

namespace Stella\Core\Http\Client;

use Stella\Core\Http\Response\Response;

interface HttpClientInterface
{
    public function get(string $url, array $headers = []): Response;

    public function post(string $url, array $data = [], array $headers = []): Response;

    public function put(string $url, array $data = [], array $headers = []): Response;

    public function delete(string $url, array $headers = []): Response;

    public function request(string $method, string $url, array $options = []): Response;
}
