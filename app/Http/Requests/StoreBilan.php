<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreBilan extends FormRequest
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
            'valeurs.*'      => 'numeric|between:0.00,1000.00|nullable', // pour tester sur le contenu des valeurs[]
            'commentaires.*' => 'string|max:400|nullable',
            'laboratoires.*' => 'string|max:200|nullable',
            'fichiers.*'     => 'mimes:jpeg,png,jpg,mp4,mp3,3gp',
            'unites.*'       => 'required',
            'typeElements.*' => 'required',
            'typeBilans.*'   => 'required',
            'date_analyses.*'=> 'required|date|before:tomorrow'
        ];
    }

    public function messages() {
        return [
            'required' => "Le champs :attribute est obligatoire",
            'numeric'  => "Le champs :attribute doit ètre numérique",
            'between'  => "Le champs :attribute doit ètre entre :min et :max",
            'max'      => "Le champs :attribute maximum :max lettres",
            'mimes'    => "Le champs :attribute doit ètre de type :.jpeg,.png,.mp4,.mp3,.3gb ",
            'tomorrow' => "Le champs :attribute doit ètre de date infèrieur à demain ",
        ];
    }
}
