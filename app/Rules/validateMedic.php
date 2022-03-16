<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class validateMedic implements Rule
{

    protected $patient;
    protected $type;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($patient , $type)
    {
        $this->patient = $patient;
        $this->type = $type;
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
        if ($this->type =='a')
        $cnt = DB::table('ligneprescriptions')
                ->join('automedications','automedications.id','=','ligneprescriptions.automedication_id')
                ->where('automedications.patient_id','=',$this->patient)
                ->where('ligneprescriptions.med_sp_id','=',$value)
                ->count();
        else
                    $cnt = DB::table('ligneprescriptions')
                ->join('traitementchroniques','traitementchroniques.id','=','ligneprescriptions.traitementchronique_id')
                ->where('traitementchroniques.patient_id','=',$this->patient)
                ->where('ligneprescriptions.med_sp_id','=',$value)
                ->count();
        if($cnt==0)
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le médicament est déja renseigné.';
    }
}
