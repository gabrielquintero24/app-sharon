<?php

namespace App\Http\Requests\Terceros;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateModistaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'celular' => 'required|numeric'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'direccion.required' => 'La direccion es requerida.',
            'celular.required' => 'El celular es requerido.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(array(
            'success' => false,
            'errors' => $validator->errors()
        ), 422));
    }
}
