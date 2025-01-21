<?php


namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface IAuth
{
    public function login(array $credentials);

    public function changePassword(array $data);

    public function logout(): void;

    public function isAuthenticated(): bool;
}
