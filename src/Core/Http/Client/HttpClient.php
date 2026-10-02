<?php

namespace Stella\Core\Http\Client;

use Stella\Core\Http\Response\HttpResponse;

class HttpClient implements HttpClientInterface
{
    public function __construct(
        private readonly TransportInterface $transport
    ) {}

    public function get(string $url, array $headers = []): HttpResponse
    {
        return $this->request('GET', $url, ['headers' => $headers]);
    }

    public function post(string $url, array $data = [], array $headers = []): HttpResponse
    {
        $options['body'] = json_encode($data);
        $options['headers']['Content-Type'] ??= 'application/json';

        return $this->request('POST', $url, $options);
    }

    public function put(string $url, array $data = [], array $headers = []): HttpResponse
    {
        $options['body'] = json_encode($data);
        $options['headers']['Content-Type'] ??= 'application/json';

        return $this->request('PUT', $url, $options);
    }

    public function delete(string $url, array $headers = []): HttpResponse
    {
        return $this->request('DELETE', $url, ['headers' => $headers]);
    }

    public function request(string $method, string $url, array $options = []): HttpResponse
    {
        return $this->transport->send($method, $url, $options);
    }
}
