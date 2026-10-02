<?php

namespace Stella\Core\Http\Client;

use Stella\Core\Http\Response\Response;

class HttpClient implements HttpClientInterface
{
    public function __construct(
        private readonly TransportInterface $transport
    ) {}

    public function get(string $url, array $headers = []): Response
    {
        return $this->request('GET', $url, ['headers' => $headers]);
    }

    public function post(string $url, array $data = [], array $headers = []): Response
    {
        $options['body'] = json_encode($data);
        $options['headers']['Content-Type'] ??= 'application/json';

        return $this->request('POST', $url, $options);
    }

    public function put(string $url, array $data = [], array $headers = []): Response
    {
        $options['body'] = json_encode($data);
        $options['headers']['Content-Type'] ??= 'application/json';

        return $this->request('PUT', $url, $options);
    }

    public function delete(string $url, array $headers = []): Response
    {
        return $this->request('DELETE', $url, ['headers' => $headers]);
    }

    public function request(string $method, string $url, array $options = []): Response
    {
        return $this->transport->send($method, $url, $options);
    }
}
