<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class ActivePatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required'
        ];
    }
}
