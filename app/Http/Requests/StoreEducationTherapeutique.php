<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreEducationTherapeutique extends FormRequest
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
            'type'       => 'string|required', //bail|: Stopping On First Validation Failure
            'description'=> 'nullable|string',
            'date_et'    => 'nullable|date|before:tomorrow' //nullable if you do not want the validator to consider null values as invalid
        ];
    }

    public function messages() {
        return [
            'required' => "Le champs :attribute doit ètre renseigné !", 
            'before'   => "La date doit ètre avant le:".date("Y-m-d", strtotime('tomorrow'))." !",
        ];
    }
}
