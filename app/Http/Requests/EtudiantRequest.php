<?php

namespace App\Http\Requests;
use illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class EtudiantRequest extends FormRequest
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

        ];

    }
    public function failedValidation (Validator $validator)
        {
            throw new HttpResponseException(response()->json([
                'success'=>false,
                'message'=> 'Bon d\'entree Validation errors',
                'data'   => $validator->errors()
            ]));
        }
}
