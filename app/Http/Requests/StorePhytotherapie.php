<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StorePhytotherapie extends FormRequest
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
            'produitalimentaire_id' => 'required|string',
            'frequence_date'        => 'date|sometimes|before:tomorrow|nullable',       
        ];
    }

    public function messages() {
        return [
            'required' => "Le champs produit alimentaire doit ètre renseigné !", 
            'before'   => "La date doit ètre avant le:".date("Y-m-d", strtotime('tomorrow'))." !",
            'date'     => "La date n'est pas renseigné !",
        ];
    }
}
