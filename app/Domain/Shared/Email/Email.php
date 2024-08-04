<?php

namespace App\Domain\Shared\Email;

final readonly class Email
{
    public string $value;

    /**
     * @throws InvalidEmailException
     */
    public function __construct(string $value)
    {
        $this->ensureEmailIsValid($value);
        $this->value = $value;
    }

    /**
     * @throws InvalidEmailException
     */
    private function ensureEmailIsValid(string $value): void
    {
        if (str_contains($value, '@') === false) {
            throw new InvalidEmailException($value);
        }
    }
}
