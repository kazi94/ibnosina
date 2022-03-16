<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduit extends FormRequest
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
        if ($this->isMethod('PATCH'))
            return [
                'produit_naturel_fr'     => 'required|string|max:60',
                'produit_naturel_latin'  => 'max:50|string|nullable',
                'produits_arabe'         => '',
            ];

        return [
            'produit_naturel_fr'    => 'required|string|max:60',
            'produit_naturel_latin'  => 'max:50|string|nullable',
            'produits_arabe'    => '',
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
        ];
    }
}
