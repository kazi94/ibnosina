<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MedicRule implements Rule
{
    protected $msg;

    /**
     * Create a new rule instance.
     *
     * @param $min_rent
     */
    public function __construct()
    {
        //         
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
            $emp= false;
            foreach(array_unique($value) as $v)
            {
                if (empty($v) && count(array_unique($value))==1) {
                    $emp = true ;
                }
            }  

        if ($emp) {
            $this->msg= "Aucun medicament selectionné";
            return false;
        }
        if(count(array_unique($value))<count($value))
        {
            $this->msg= "Médicament dupliqué";
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg;
    }
}
