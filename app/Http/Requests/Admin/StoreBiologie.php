<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


class StoreBiologie extends FormRequest
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
        if ($this->method() == "PATCH")
            return [
                'nom'                     => 'string|required|max:100', //bail|: Stopping On First Validation Failure
                'prenom'                  => 'string|required|max:100',
                'date_naissance'          => "required|date|before:today",
                'sexe'                    => "required",
                'tabagiste_depuis'        => "nullable|numeric",
                'alcoolique_depuis'       => "nullable|date|before:tomorrow",
                'drogué_depuis'           => "nullable|date|before:tomorrow",
                'date_admission'          => "nullable|date",
                'taille'                  => 'numeric|between:0,200|nullable', // numeric veut dire entre 2 et 4 , ex : 3
                'poids'                   => 'numeric|between:0,199.99|nullable',
                'chambre'                 => 'numeric|nullable',
                'lit'                     => 'numeric|nullable',
                'nbre_enfants'            => 'numeric|nullable',
                'num_tel_1'               => 'max:12',
                'num_tel_2'               => 'max:12',
                'code_national'           => 'unique:patients|nullable',
            ];
        else
            return [
                'nom'                     => 'string|required|max:100', //bail|: Stopping On First Validation Failure
                'prenom'                  => 'string|required|max:100',
                'num_securite_sociale'    => 'nullable|string|unique:patients,num_securite_sociale,' . $this->patient_id . '|max:50', //nullable if you do not want the validator to consider null values as invalid
                'date_naissance'          => "required|date|before:today",
                'sexe'                    => "required",
                'tabagiste_depuis'        => "nullable|numeric",
                'alcoolique_depuis'       => "nullable|date|before:tomorrow",
                'drogué_depuis'           => "nullable|date|before:tomorrow",
                'date_admission'          => "nullable|date",
                'taille'                  => 'numeric|between:0,200|nullable', // numeric veut dire entre 2 et 4 , ex : 3
                'poids'                   => 'numeric|between:0,199.99|nullable',
                'chambre'                 => 'numeric|nullable',
                'lit'                     => 'numeric|nullable',
                'nbre_enfants'            => 'numeric|nullable',
                'num_tel_1'               => 'max:12',
                'num_tel_2'               => 'max:12',
                'code_national'           => 'unique:patients|nullable',
            ];
    }

    public function messages()
    {
        return [
            'required' => "Le champs :attribute doit ètre renseigné !",
            'before'   => "La date doit ètre avant le:" . date("Y-m-d", strtotime('tomorrow')) . " !",
            'max'      => "Le champs :attribute doit ètre infèrieur à :max !",
            'unique'   => "Le champs :attribute est déja renseigné !",
            'between'  => "Le champs :attribute doit ètre entre :min et :max"
        ];
    }
}
