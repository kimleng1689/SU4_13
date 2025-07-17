<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NumberFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( !preg_match('/^\d{1,3}(,\d{3})*\.\d{2}$/', $value) ) {
            $fail("Invalid format. The correct format is: 
                0.00 or 00,000.00");
        }   
    }
}

