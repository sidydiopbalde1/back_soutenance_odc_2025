<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette demande.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'Matricule' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users', 'Matricule')->ignore($this->route('id')),
            ],
            'telephone' => [
                'sometimes',
                'string',
                'max:15',
                Rule::unique('users', 'telephone')->ignore($this->route('id')),
            ],
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('id')),
            ],
            'login' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users', 'login')->ignore($this->route('id')),
            ],
            'password' => 'sometimes|string|min:6|confirmed',
            'role_id' => [
                'sometimes',
                'integer',
                Rule::exists('roles', 'id'),
            ],
        ];
    }

    /**
     * Obtenez les messages de validation personnalisés.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',

            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',

            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 15 caractères.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',

            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'login.string' => 'Le login doit être une chaîne de caractères.',
            'login.max' => 'Le login ne peut pas dépasser 255 caractères.',
            'login.unique' => 'Ce login est déjà utilisé.',

            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',

            'role_id.integer' => 'Le rôle doit être un identifiant numérique.',
            'role_id.exists' => 'Le rôle sélectionné est invalide.',

            'Matricule.string' => 'Le matricule doit être une chaîne de caractères.',
            'Matricule.max' => 'Le matricule ne peut pas dépasser 255 caractères.',
            'Matricule.unique' => 'Ce matricule est déjà utilisé.',
        ];
    }

    /**
     * Gère l'échec de la validation.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Échec de la validation.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
