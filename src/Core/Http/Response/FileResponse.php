<?php

namespace Stella\Core\Http\Response;

class FileResponse extends HttpResponse
{
    public function __construct(
        private readonly string $path,
        int $statusCode = 200,
        array $headers = [],
    )
    {
        $headers['Content-Type'] ??= mime_content_type($this->path);
        parent::__construct($statusCode, $headers);
    }

    protected function getContent(): string
    {
        return file_get_contents($this->path);
    }
}

// TODO: file_get_contents loads the entire file into memory, which can be inefficient for large files. Consider using a streaming approach or readfile() for better performance.
// Response -> FileResponse -> stream file -> output, which means my current abstraction of getContent(): string is not suitable for large files. I need to rethink the design of the Response class to accommodate streaming responses.

