<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SeqRule implements Rule
{
    protected  $seq_j;

    /**
     * Create a new rule instance.
     *
     * @param $min_rent
     */
    public function __construct()
    {
                
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
        $j=0;
        foreach($value as $seq)
        {
            if($seq>$j){
                $j = $seq;
            }
            else{return false;}
        }  
        return true;      
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // Customize the error message
        return 'Valeur jour de sequence incorrecte'; 
    }
}