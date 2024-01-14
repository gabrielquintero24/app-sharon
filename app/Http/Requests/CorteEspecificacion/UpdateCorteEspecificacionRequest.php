<?php

namespace App\Http\Requests\CorteEspecificacion;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCorteEspecificacionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'corte_id' => 'required|integer',
            'especificacion_id' => 'required|integer',
            'cantidad' => 'required|integer',
            'precio' => 'required|decimal:2',
        ];
    }

    public function messages(): array
    {
        return [
            'corte_id.required' => 'El corte es requerido.',
            'especificacion_id.required' => 'La especifiacion es requerida.',
            'cantidad.required' => 'La cantidad es requerida.',
            'precio.required' => 'El precio es requerido.',
            'precio.decimal' => 'El precio debe contener dos decimales.',
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
