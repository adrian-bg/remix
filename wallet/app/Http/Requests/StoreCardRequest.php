<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'card_type_id' => 'required|exists:card_types,id',
            'card_provider_id' => 'required|exists:card_providers,id',
            'names' => 'required|max:200',
            'number' => 'required|numeric|unique:cards',
            'cvv' => 'required',
            'expire_at' => 'required|date|date_format:Y-m|after:today',
        ];
    }
}
