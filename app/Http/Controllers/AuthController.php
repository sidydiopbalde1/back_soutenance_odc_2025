<?php
namespace App\Http\Controllers;

use App\Services\Interfaces\IAuth;
use Illuminate\Http\Request;
use App\Traits\HasResponseMessageTrait;
use App\Http\Requests\LoginRequest;
use Illuminate\Auth\AuthenticationException;
 

class AuthController extends Controller
{
    use HasResponseMessageTrait;

    private IAuth $authService;

    public function __construct(IAuth $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        try {
            $result = $this->authService->login($credentials);
            $this->setResponseMessage('Connexion réussie');
            return response()->json($result, 200);
        } catch (AuthenticationException $e) {
            // Pas de log ici, on laisse le LogService dans AuthService gérer ça
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function changePassword(Request $request)
    {
        $user = $this->authService->changePassword($request->all());
        $this->setResponseMessage('Mot de passe changé avec succés');
        return $user;
    }
    public function logout()
    {
        $this->authService->logout();
        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }

    public function isAuthenticated(): bool
    {
        return $this->authService->isAuthenticated();
    }
}
