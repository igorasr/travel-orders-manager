<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllowedArrayKeys implements ValidationRule
{
    protected array $allowedKeys;

    public function __construct(array $allowedKeys)
    {
        $this->allowedKeys = $allowedKeys;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            $fail("O campo $attribute deve ser um array.");
            return;
        }

        $invalidKeys = array_diff(array_keys($value), $this->allowedKeys);

        if (!empty($invalidKeys)) {
            $fail("As chaves do campo $attribute são inválidas: " . implode(', ', $invalidKeys));
        }
    }
}
