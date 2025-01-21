<?php
namespace App\Services\Users;
use App\Repository\Users\UserRepository;
use App\Services\Interfaces\IUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;
use App\Services\Mail\MailService;

class UserService implements IUser{

    private $userRepository;
    private $mailService;

    public function __construct(UserRepository $userRepository, MailService $mailService){
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
    }
    public function getUsers(){
        return $this->userRepository->allUsers();
    }
    public function getUser($id){
        return $this->userRepository->getUser($id);
    }
    public function saveUser($data){

        $user = [
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'login' => $data['login'],
            'Matricule' => $data['Matricule'],
            'password' => Hash::make($data['password']),
            'first_connexion' => true,
            'role_id' => $data['role_id'],
        ];
        $message = "Vos informations de connexion";
        $user = $this->userRepository->create($data);
        $this->mailService->sendEmail($user, $message);
        
        return $user;
    }
    public function updateUser($user){
     return $this->userRepository->update($user);
    }

    public function deleteUser($id){
        return $this->userRepository->delete($id);
    }

}