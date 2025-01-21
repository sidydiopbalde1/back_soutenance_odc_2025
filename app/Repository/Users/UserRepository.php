<?php

namespace App\Repository\Users;
use App\Models\User;
use App\Repository\Interfaces\IUser;
class UserRepository implements IUser{

    public function allUsers()
    {
        return User::paginate(1);
    }
    public function getUser($id){
        return User::find($id);
    }
    public function create($user)
    {
        return User::create($user);
    }
    public function update($user)
    {
        return User::where('id', $user->id)->update($user->toArray());
    }
    public function delete($id){
        return User::destroy($id);
    }
}