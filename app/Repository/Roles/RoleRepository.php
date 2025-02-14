<?php
namespace App\Repository\Roles;

use App\Models\Role;
use App\Repository\Interfaces\IRole;
class RoleRepository implements IRole{

    public function getAllRoles(){
        return Role::all();
    }
}