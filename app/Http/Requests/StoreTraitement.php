<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\validateMedic;

class StoreTraitement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
        'date_etats.*'  => 'required|date_format:Y-m-d|before:tomorrow',
        'med_sp_id.*'   => 'required|string',
        'med_sp_id.*'   => new validateMedic($this->patient_id, 't')  
        ];
    }

    public function messages() {
        return [
            'required' => "Le champs :attribute est obligatoire",
            'numeric'  => "Le nombre de jours doit ètre numérique",
            'unique'   => "Le médicament  est dèja renseigné !",
        ];
    }
}
