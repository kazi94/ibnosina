<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescription extends FormRequest
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
            'nbr_jours.*' => 'nullable|numeric',
            'dose.*'      => 'nullable|numeric|min:0',
            //'med_sp_id.*' => 'required|string'            
        ];
    }

    public function messages() {
        return [
            'required' => "Le champs médicament doit ètre renseigné",
            'numeric'  => "Le champs :attribute doit ètre numérique",
            'min'      => "Le champs :attribute doit ètre superieur à :min",
        ];
    }
}
