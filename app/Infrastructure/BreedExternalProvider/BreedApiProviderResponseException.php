<?php

namespace App\Infrastructure\BreedExternalProvider;

use Exception;

class BreedApiProviderResponseException extends Exception
{
    public function __construct(
        public readonly string $requestedUrl,
        public readonly int $httpStatus
    ) {
        parent::__construct('[' . $httpStatus . '] ' . $requestedUrl);
    }
}
