<?php 

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Interfaces\IAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuth
{  
    public function login(array $credentials)
    {
     
        if (Auth::attempt($credentials)) {
            $user = User::find(Auth::user()->id);
            if($user->first_connexion){
               return throw new AuthenticationException('Votre première connexion, veuillez changer votre mot de passe.');
            }
            if(!$user->isActive){
                return throw new AuthenticationException();
            }
            $token = $user->createToken('PassportAuthToken')->accessToken;
            return [
                'user'        => $user,
                'token'       => $token
            ];
        }
      
        return throw new AuthenticationException();
    }

    public function changePassword(array $data)
    {
        $user = User::find(Auth::user()->id);
        if (!$user || !$user->first_connexion) {
            return [    
                'status' => 400,
                'message' => 'Ce n\'est pas votre première connexion.',
              ];
        }
        Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->password =  Hash::make($data['password']);
        $user->first_connexion = false;
        $user->save();
    
        return $user;
    }
    
         
    public function logout(): void
    {
        $user = User::find(Auth::user()->id);

        if ($user) {
            // Révoquer tous les tokens de l'utilisateur
            $user->tokens()->delete();
        }

        // Déconnecter l'utilisateur
        Auth::logout();
    }

    public function isAuthenticated(): bool
    {
        return Auth::check();
    }
}
