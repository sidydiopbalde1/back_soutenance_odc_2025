<?php
namespace App\Repository\Interfaces;

interface IUser{

    public function allUsers();
    public function getUser($id);
    public function create($user);
    public function update($user, array $data);
    public function delete($user);
    public function getUserRestored();
    public function activeOrDesactiveUser($id);
}