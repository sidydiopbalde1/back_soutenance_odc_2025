<?php

namespace App\Repository\Users;
use App\Models\User;
use App\Repository\Interfaces\IUser;
class UserRepository implements IUser{

    public function allUsers($role = null, $search = null)
    {
        $query = User::query();
    
        if ($role) {
            $query->where('role_id', $role);
        }
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%$search%")
                  ->orWhere('prenom', 'LIKE', "%$search%");
            });
        }
    
        return $query->paginate(10);
    }
    
    public function getUser($id){
        // dd($id);
        return User::find($id);
    }
    public function create($user)
    {
        return User::create($user);
    }
    public function update($user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete($user){
        return $user->delete();
    }
    public function getUsertoRestore($id){
        return User::withTrashed()->find($id);
    }
    public function restore($user){
        return $user->restore();
    }
    public function getUserRestored()
    {
        return User::onlyTrashed()->get();
    }
    
    public function activeOrDesactiveUser($id)
    {
        $user = User::find($id);

        $user->update(["isActive" => !$user->isActive]);
        return  $user;
        
    }
    
}