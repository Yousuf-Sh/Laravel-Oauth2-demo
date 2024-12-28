<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Password implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check minimum length
        if (strlen($value) < 8) {
            $fail('The password must be at least 8 characters.');
        }

        // Check for at least one letter
        if (!preg_match('/[a-zA-Z]/', $value)) {
            $fail('The password must contain at least one letter.');
        }

        // Check for at least one number
        if (!preg_match('/[0-9]/', $value)) {
            $fail('The password must contain at least one number.');
        }

        // Check for at least one special character
        if (!preg_match('/[^A-Za-z0-9]/', $value)) {
            $fail('The password must contain at least one special character.');
        }

        // Check for mixed case
        if (!preg_match('/[A-Z]/', $value) || !preg_match('/[a-z]/', $value)) {
            $fail('The password must contain both uppercase and lowercase letters.');
        }
    }
}