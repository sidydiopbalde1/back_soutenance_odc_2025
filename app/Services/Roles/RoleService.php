<?php
namespace App\Services\Roles;

use App\Repository\Roles\RoleRepository;
use App\Services\Interfaces\IRole;

class RoleService implements IRole {

    private $roleRepository;

    public function __construct(RoleRepository $roleRepository){
        $this->roleRepository = $roleRepository;
      
    }
    public function getRoles()
    {
        return $this->roleRepository->getAllRoles();
    }
}