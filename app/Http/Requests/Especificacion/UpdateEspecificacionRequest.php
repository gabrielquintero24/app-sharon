<?php

namespace App\Http\Requests\Especificacion;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEspecificacionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'descripcion' => 'required|string|max:512',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'descripcion.required' => 'La descripcion es requerida.',
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
