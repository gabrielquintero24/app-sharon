<?php

namespace App\Http\Requests\Cortes;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCorteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'codigo_referencia' => [
                'required',
                'string',
                Rule::unique('corte', 'codigo_referencia')->ignore(request('id'))
            ],
            'cantidad_salida' => 'required|integer',
            'cantidad_entrada' => 'nullable|integer',
            'fecha_creacion' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'codigo_referencia.required' => 'El codigo referencia es requerido.',
            'codigo_referencia.unique' => 'El codigo referencia debe ser unico.',
            'cantidad_salida.required' => 'El cantidad de salida es requerida.',
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
