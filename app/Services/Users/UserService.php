<?php
namespace App\Services\Users;
use App\Repository\Users\UserRepository;
use App\Services\Interfaces\IUser;
use Illuminate\Support\Facades\Hash;
use App\Services\Mail\MailService;
use App\Services\Logs\LogService;
use Illuminate\Support\Facades\Auth;

class UserService implements IUser{

    private $userRepository;
    private $mailService;
    private LogService $logService;

    public function __construct(UserRepository $userRepository, MailService $mailService, LogService $logService){
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
        $this->logService = $logService;
    }
    
    public function getUsers($role = null, $search = null)
    {
        try {
            return $this->userRepository->allUsers($role, $search);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUser($id){
        try {
            return $this->userRepository->getUser($id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function saveUser($data)
    {
        $currentUser = Auth::user();
        try {
            $user = $this->userRepository->create($data);

            $this->mailService->sendEmail($user, "Vos informations de connexion");

            $this->logService->logAction(
                'User Created',
                "{$currentUser->nom} {$currentUser->prenom} a créé l'utilisateur {$user->nom} {$user->prenom} avec succès le " . now()->format('d-m-Y H:i:s'),
                'success'
            );

            return $user;
        } catch (\Throwable $e) {
            $this->logService->logAction(
                'User Creation Failed',
                "{$currentUser->nom} {$currentUser->prenom} a tenté de créer l'utilisateur {$data['nom']} {$data['prenom']} mais a échoué le " . now()->format('d-m-Y H:i:s'),
                'error'
            );
            throw $e;
        }
    }

    public function updateUser($user, array $data)
    {
        $currentUser = Auth::user();
        try {
            $updateUser = $this->userRepository->update($user, $data);
            $this->logService->logAction(
                'User Updated',
                "{$currentUser->nom} {$currentUser->prenom} a mis à jour l'utilisateur {$user->nom} {$user->prenom} le " . now()->format('d-m-Y H:i:s'),
                'info'
            );
            return $updateUser;
        } catch (\Throwable $e) {
            throw $e;
        }
    }    

    public function deleteUser($user)
    {
        $currentUser = Auth::user();
        try {
            $this->userRepository->delete($user); 
            $this->logService->logAction(
                'User Deleted',
                "{$currentUser->nom} {$currentUser->prenom} a supprimé l'utilisateur {$user->nom} {$user->prenom} le " . now()->format('d-m-Y H:i:s'),
                'warning'
            );
            return true;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUsertoRestore($id){
        try {
            return $this->userRepository->getUsertoRestore($id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
    
    public function restoreUser($user)
    {
        $currentUser = Auth::user();
        try {
            $this->userRepository->restore($user);
            $this->logService->logAction(
                'User Restored',
                "{$currentUser->nom} {$currentUser->prenom} a restauré l'utilisateur {$user->nom} {$user->prenom} le " . now()->format('d-m-Y H:i:s'),
                'success'
            );
            return true;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function getUserRestored(){
        try {
            return $this->userRepository->getUserRestored();
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function activeOrDesactiveUser($id){
        $currentUser = Auth::user();
        try {
            $user = $this->userRepository->activeOrDesactiveUser($id);
            $status = $user->isActive ? 'activé' : 'désactivé';
            $this->logService->logAction(
                'User Status Changed',
                "{$currentUser->nom} {$currentUser->prenom} a {$status} l'utilisateur {$user->nom} {$user->prenom} le " . now()->format('d-m-Y H:i:s'),
                'info'
            );
            return $user;
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
