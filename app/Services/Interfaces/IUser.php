<?php
namespace App\Services\Interfaces;

interface IUser {
    public function getUsers();
    public function getUser(string $userId);
    public function saveUser(array $userData);
    public function deleteUser(string $userId);
}