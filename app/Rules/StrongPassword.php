<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z\d])[A-Za-z\d\S]{8,}$/', $value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.';
    }
}