<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Interfaces\IAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Logs\LogService;
use Illuminate\Auth\AuthenticationException;

class AuthService implements IAuth
{
    private LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            $this->logService->logAction(
                'Login',
                'Tentative de connexion échouée pour l\'email: ' . $credentials['email'].'le'. now()->format('d-m-Y H:i:s'),
                'failed'
            );
            throw new AuthenticationException('Identifiants incorrects');
        }

        $user = User::find(Auth::user()->id);

        if ($user->first_connexion) {
            $this->logService->logAction(
                'Login',
                'Utilisateur ' . $user->nom . ' ' . $user->prenom . ' doit changer son mot de passe pour la première connexion',
                'warning'
            );
            throw new AuthenticationException('Votre première connexion, veuillez changer votre mot de passe.');
        }

        if (!$user->isActive) {
            $this->logService->logAction(
                'Login',
                'Compte désactivé pour l\'utilisateur ' . $user->nom . ' ' . $user->prenom,
                'warning'
            );
            throw new AuthenticationException('Votre compte est désactivé.');
        }

        // Loguer la connexion réussie
        $this->logService->logAction(
            'Login',
            'Utilisateur ' . $user->nom . ' ' . $user->prenom . ' s\'est connecté avec succès le ' . now()->format('d-m-Y H:i:s'),
            'success'
        );

        // Générer le token d'authentification
        $token = $user->createToken('PassportAuthToken')->accessToken;

        return [
            'message' => 'Connexion réussie',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];
    }

    public function changePassword(array $data)
    {
        $user = User::find(Auth::user()->id);

        if (!$user || !$user->first_connexion) {
            return [
                'status'  => 400,
                'message' => 'Ce n\'est pas votre première connexion.',
            ];
        }

        $user->password = Hash::make($data['password']);
        $user->first_connexion = false;
        $user->save();

        // Loguer le changement de mot de passe
        $this->logService->logAction(
            'ChangePassword',
            'Utilisateur ' . $user->nom . ' ' . $user->prenom . ' a changé son mot de passe',
            'success'
        );

        return [
            'message' => 'Mot de passe changé avec succès',
            'data' => $user
        ];
    }

    public function logout(): void
    {
        $user = User::find(Auth::user()->id);

        if ($user) {
            // Révoquer tous les tokens de l'utilisateur
            $user->tokens()->delete();

            // Loguer la déconnexion
            $this->logService->logAction(
                'Logout',
                'Utilisateur ' . $user->nom . ' ' . $user->prenom . ' s\'est déconnecté',
                'success'
            );
        }

        Auth::logout();
    }

    public function isAuthenticated(): bool
    {
        return Auth::check();
    }
}