<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\Users\UserService;
use App\Traits\HasResponseMessageTrait;

class UserController extends Controller{

    use HasResponseMessageTrait;
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function index(){
        $users = $this->userService->getUsers();
        $this->setResponseMessage("liste des utilisateurs");
        return $users;
    }
    public function store(StoreUserRequest $request){

        $validated = $request->validated();
        $user = $this->userService->saveUser($validated);

        $this->setResponseMessage("Utilisateur créé avec succés");
        
        return $user;
    }
}