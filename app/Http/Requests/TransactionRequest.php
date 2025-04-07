<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
                'min:5', // Minimum 5 FCFA par exemple
                function ($attribute, $value, $fail) {
                    $client = Client::find($this->route('id')); // Récupérer le client
                    if ($client && $client->solde < $value) {
                        $fail("Votre solde est insuffisant pour effectuer ce transfert.");
                    }
                }
            ],
            // 'receiver_number' => 'required|digits:9|regex:/^7[0-9]{8}$/' // Numéro valide commençant par 7
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Le montant est obligatoire.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant minimum est de 5 FCFA.',
            'receiver_number.required' => 'Le numéro du destinataire est requis.',
            'receiver_number.digits' => 'Le numéro doit contenir exactement 9 chiffres.',
            // 'receiver_number.regex' => 'Le numéro doit commencer par 7.',
        ];
    }
}
