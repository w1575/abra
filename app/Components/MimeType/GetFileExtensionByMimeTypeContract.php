<?php

namespace App\Components\MimeType;

interface GetFileExtensionByMimeTypeContract
{
    public function __invoke(string $mimeType): string;
}