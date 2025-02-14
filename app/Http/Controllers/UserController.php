<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\Users\UserService;
use App\Traits\HasResponseMessageTrait;
use Illuminate\Http\Request;

class UserController extends Controller{

    use HasResponseMessageTrait;
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $role = $request->query('role_id');
        $search = $request->query('search');
        $users = $this->userService->getUsers($role, $search);
        if(!$users){
            $this->setResponseMessage("Aucun utilisateur trouvé");
            return [];
        }
        $this->setResponseMessage("Liste des utilisateurs");
    
        return $users;
    }
    public function store(StoreUserRequest $request){

        $validated = $request->validated();
        $user = $this->userService->saveUser($validated);
        $this->setResponseMessage("Utilisateur créé avec succés");
        return $user;
    }
    public function show($id){
        $id = intval($id);
        if(!$id){
            return $this->setResponseMessage("ID non valide");
        }
        $user = $this->userService->getUser($id);
        if(!$user){
            return response()->json(['message' =>"User does not exist"]);
        }
        $this->setResponseMessage("Utilisateur trouvé");
        return $user;
    }
    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();
        $user = $this->userService->getUser($id);
        if (!$user) {
            $this->setResponseMessage("Aucun utilisateur trouvé");
            return [];
        }
        $updatedUser = $this->userService->updateUser($user, $validated);
        $this->setResponseMessage("Utilisateur modifié avec succès");
        return $updatedUser;
    }
    //delete users
    public function delete($id)
    {
        $user = $this->userService->getUser($id);
        if (!$user) {
            $this->setResponseMessage("Utilisateur non trouvé");
            return [];
        }
        $this->userService->deleteUser($user);
        $this->setResponseMessage("Utilisateur supprimé avec succès");
        return [];
    }
    //restore users
    public function restoreUser($id)
    {   
       
        $user = $this->userService->getUsertoRestore($id);
        if (!$user) {
            $this->setResponseMessage("Utilisateur supprimé avec");
            return [] ;
        }
        $users= $this->userService->restoreUser($user);
        $this->setResponseMessage("Utilisateur restauré avec succès");
        return $users;
    }

    public function showUserRestored()
    {
        $users = $this->userService->getUserRestored();
        if ($users->isEmpty()) {
            $this->setResponseMessage("Aucun utilisateur restaurés");
            return [];
        }
        $this->setResponseMessage("Liste des utilisateur restaurés");
        return $users;
    }
    //active user
    public function activeOrDesactiveUser($id){

        if(!$this->userService->getUser($id)){
            $this->setResponseMessage("Aucun utilisateur correspondant");
            return [];
        }
        $user = $this->userService->activeOrDesactiveUser($id);
        $this->setResponseMessage("Compte activé  avec succés!");
        // "Utilisateur " . ($user->isActive ? "activé" : "désactivé") . " avec succès",
        return $user;
    }
}







