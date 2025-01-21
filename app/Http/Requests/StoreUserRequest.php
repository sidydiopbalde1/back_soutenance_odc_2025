<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette demande.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Autoriser cette requête. Ajoutez des restrictions ici si nécessaire.
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
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'Matricule' => 'required|string|max:255|unique:users,Matricule', // Vérifie que le matricule n'est pas déjà utilisé.
            'telephone' => 'required|string|max:15|unique:users,telephone',
            'email' => 'required|email|max:255|unique:users,email',
            'login' => 'required|string|max:255|unique:users,login',
            'password' => 'required|string|min:6',
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id'), // Vérifie que l'ID existe dans la table `roles`
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
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',

            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',

            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 15 caractères.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',

            'login.required' => 'Le login est obligatoire.',
            'login.string' => 'Le login doit être une chaîne de caractères.',
            'login.max' => 'Le login ne peut pas dépasser 255 caractères.',
            'login.unique' => 'Ce login est déjà utilisé.',

            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',

            'role_id.required' => 'Le rôle est obligatoire.',
            'role_id.integer' => 'Le rôle doit être un identifiant numérique.',
            'role_id.exists' => 'Le rôle sélectionné est invalide.',

            'Matricule.required' => 'le matricule est obligatoire.',
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
