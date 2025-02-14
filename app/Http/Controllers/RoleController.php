<?php

namespace App\Http\Controllers;

use App\Services\Roles\RoleService;
use App\Traits\HasResponseMessageTrait;
use Illuminate\Http\Request;

class RoleController extends Controller{

    use HasResponseMessageTrait;
    private $roleService;

    public function __construct(RoleService $roleService){
        $this->roleService = $roleService;
    }
    public function index(Request $request)
    {
        $roles = $this->roleService->getRoles();
        if(!$roles){
            $this->setResponseMessage("Aucun roletrouvé");
            return [];
        }
        $this->setResponseMessage("Liste des roles");
        return $roles;
    }

}