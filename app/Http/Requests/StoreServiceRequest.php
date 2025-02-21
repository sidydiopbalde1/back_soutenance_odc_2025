<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:services,code',
            'description' => 'required|string|max:255',
            'cibles' => 'required|string|in:C,P,All',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.required' => 'Le code du service est requis',
            'code.unique' => 'Ce code de service existe déjà',
            'code.max' => 'Le code ne peut pas dépasser 255 caractères',
            'description.required' => 'La description du service est requise',
            'description.max' => 'La description ne peut pas dépasser 255 caractères',
            'cibles.required' => 'Les cibles du service sont requises',
            'cibles.in' => 'Les cibles doivent être C, P ou All',
        ];
    }
}