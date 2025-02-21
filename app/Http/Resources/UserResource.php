<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transforme la ressource en tableau.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'telephone' => $this->telephone,
            'matricule' => $this->Matricule,
            'email' => $this->email,
            'login' => $this->login,
            'role' => $this->role->libelle ?? null,
            "isActive"=>$this->isActive,
            "first_connexion"=>$this->first_connexion,
        ];
    }
}
