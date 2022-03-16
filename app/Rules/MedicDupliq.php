<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MedicDupliq implements Rule
{
    protected  $med_sp_id_prem;

    /**
     * Create a new rule instance.
     *
     * @param $min_rent
     */
    public function __construct($med_sp_id_prem)
    {
        // Here we are passing the min-rent value to use it in the validation.
        $this->med_sp_id_prem = $med_sp_id_prem;         
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
        foreach($value as $v)
        {
            foreach($this->med_sp_id_prem as $vv)
            {
                if($v == $vv)
                {
                    return false;
                }
            }
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
        return 'Meme meédicament trouvé en prémidication et traitement';
    }
}
