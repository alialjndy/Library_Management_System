<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use function PHPUnit\Framework\isEmpty;

class ValidBook implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($attribute == 'title' && empty($value)){
            $fail('Title is Empty');
        }
        if($attribute == 'author' && strlen($value) < 3){
            $fail('author length must be greater than 3');
        }
    }
}
