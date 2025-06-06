<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelationshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:relationships,name,' . $this->route('relationship')?->id,
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}