<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NbrcureRule implements Rule
{
    protected  $cure_min;

    /**
     * Create a new rule instance.
     *
     * @param $min_rent
     */
    public function __construct($cure_min)
    {
        // Here we are passing the min-rent value to use it in the validation.
        $this->cure_min = $cure_min;         
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // This is where you define the condition to be checked.
        return $value > $this->cure_min;         
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // Customize the error message
        return 'La valeur du nombre de cure maximum dois etre superieure'; 
    }
}