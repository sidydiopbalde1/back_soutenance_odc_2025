<?php
namespace App\Repository\Interfaces;

interface IUser{

    public function allUsers();
    public function getUser($id);
    public function create($user);
    public function update($user);
    public function delete($id);
}