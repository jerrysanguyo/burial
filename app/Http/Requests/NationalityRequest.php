<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NationalityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:nationalities,name,' . $this->route('nationality')?->id,
            'remarks' => 'nullable|string|max:255',
        ];
    }
}