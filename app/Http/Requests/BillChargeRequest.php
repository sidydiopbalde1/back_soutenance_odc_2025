<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillChargeRequest extends FormRequest
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
            'bill_reference' => [
                'required',
               'numeric',
                // 'regex:/^\d{5}$/', // Vérifie exactement 5 chiffres
            ],
            'amount' => [
                'required',
                'numeric',
                // 'min:1000'
            ]

        ];
    }

    public function messages(): array
    {
        return [
            'bill_reference.required' => 'La référence de facture est obligatoire.',
            'bill_reference.numeric' => 'La référence de facture doit être un nombre.',
            // 'bill_reference.regex' => 'La référence de facture doit contenir exactement 5 chiffres.',

            'amount.required' => 'Le montant est obligatoire.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            // 'amount.min' => 'Le montant doit être au minimum de 1000.',
        ];
    }
}
