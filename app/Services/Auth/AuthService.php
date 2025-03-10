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
        // Vérifier que l'ID utilisateur est fourni dans les données
        if (!isset($data['userId'])) {
            return response()->json([
                'status'  => 400,
                'message' => 'L\'ID utilisateur est requis.'
            ], 400);
        }
    
        // Récupérer l'utilisateur à partir de l'ID fourni par le front
        $user = User::find($data['userId']);
    
        // Vérifier que l'utilisateur existe et que c'est bien sa première connexion
        if (!$user || !$user->first_connexion) {
            return response()->json([
                'status'  => 400,
                'message' => 'Ce n\'est pas votre première connexion.'
            ], 400);
        }
    
        // Valider les données du formulaire
        $validator = Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Les données fournies sont invalides.',
                'errors'  => $validator->errors()
            ], 422);
        }
    
        // Mettre à jour le mot de passe et désactiver le flag first_connexion
        $user->password = Hash::make($data['password']);
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
