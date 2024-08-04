<?php

namespace App\Domain\Shared\Email;

use Exception;

class InvalidEmailException extends Exception
{
    public function __construct(string $invalidEmail)
    {
        parent::__construct('"' . $invalidEmail . '" is not a valid email.');
    }
}
