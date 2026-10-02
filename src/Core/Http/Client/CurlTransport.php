<?php

namespace Stella\Core\Http\Client;

use Stella\Core\Http\Response\HttpResponse;
use Stella\Core\Http\Response\JsonResponse;

class CurlTransport implements TransportInterface
{
    public function send(
        string $method,
        string $url,
        array $options = []
    ): HttpResponse {
        $ch = curl_init();

        if ($ch === false) {
            throw new \RuntimeException('Failed to initialize cURL session');
        }

        $headers = $options['headers'] ?? [];
        $body = $options['body'] ?? null;

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => $this->formatHeaders($headers),
        ]);

        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $responseContent = curl_exec($ch);

        if ($responseContent === false) {
            $error = curl_error($ch);

            curl_close($ch);

            throw new \RuntimeException('cURL error: ' . $error);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        curl_close($ch);

        $rawHeaders = substr($responseContent, 0, $headerSize);
        $body = substr($responseContent, $headerSize);

        return new JsonResponse($body, $statusCode, $this->parseHeaders($rawHeaders));
    }

    private function formatHeaders(array $headers): array
    {
        $formattedHeaders = [];

        foreach ($headers as $key => $value) {
            $formattedHeaders[] = "$key: $value";
        }

        return $formattedHeaders;
    }

    private function parseHeaders(string $rawHeaders): array
    {
        $headers = [];
        $headerLines = explode("\r\n", $rawHeaders);

        foreach ($headerLines as $line) {
            if (! str_contains($line, ':')) {
                continue;
            }

            [$name, $value] = explode(':', $line, 2);
            $headers[trim($name)] = trim($value);
        }

        return $headers;
    }
}
