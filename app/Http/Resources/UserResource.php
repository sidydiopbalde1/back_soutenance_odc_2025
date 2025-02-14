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
            'matricule' => $this->Matricule,
            'email' => $this->email,
            'role' => $this->role->libelle ?? null,
            "isActive"=>$this->isActive,
            "first_connexion"=>$this->first_connexion,
        ];
    }
}
