<?php

namespace App\Http\Requests;

use App\Services\Interfaces\IDatabase;
use Illuminate\Foundation\Http\FormRequest;

class CampagneRequest extends FormRequest
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
            'libelle' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $existingCampagne = app(IDatabase::class)->getCollection('campagnes');
                    foreach ($existingCampagne as $campagne) {
                        if ($campagne['libelle'] === $value && ($this->campagne->id ?? null) !== $campagne['_id']) {
                            $fail('Le champ ' . $attribute . ' doit être unique.');
                        }
                    }
                },
            ],
            'description' => 'nullable|string',
        ];
    }


    public function messages()
    {
        return [
            'libelle.required' => 'Le libellé est requis.',
            'libelle.unique' => 'Ce libellé existe déjà.',
            'description.string' => 'La description doit être une chaîne de caractères.',
        ];
    }
}
