<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompte extends FormRequest
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
            "patient_id"    => "required",
            "email"      => "email|string|unique:comptes",
            "password"   => "required|min:6|string"
        ];
    }
           /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => "Le champ :attribute est obligatoire",
            'max' => "Le champ :attribute maximum :max alphabets",
            'min' => "Le champ :attribute minimum :min caractères",
            'unique' => "Le champ :attribute est déja pris",
            'email' => "Le champ :attribute doit ètre un email",
        ];
    }
}
