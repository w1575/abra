<?php

namespace App\Storages\Traits;

use Psr\Http\Message\ResponseInterface;

trait DecodeResponseBodyTrait
{
    public function decodeResponseBody(ResponseInterface $response)
    {
        return json_decode((string)$response->getBody());
    }
}