<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditChargeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:5'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Le montant de la recharge est obligatoire',
            'amount.numeric' => 'Le montant est invalide',
            'amount.min' => 'Le montant minimum est 5 fr'
        ];
    }
}
