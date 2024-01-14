<?php

namespace App\Http\Requests\Asignacion;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAsignacionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'corte_id' => 'required|integer',
            'modista_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'corte_id.required' => 'El corte es requerido.',
            'modista_id.required' => 'La modista es requerida.',
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
