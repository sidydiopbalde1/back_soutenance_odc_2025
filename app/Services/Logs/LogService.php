<?php

namespace App\Services\Logs;

use App\Repository\Logs\LogRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class LogService
{
    // protected LogRepository $logRepository;
    private LogRepository $logRepository;


    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function getLogs(int $perPage = 20): LengthAwarePaginator
    {
        return $this->logRepository->getAllLogs($perPage);
        dd($logs); // Vérifier si on récupère bien les logs
        return $logs;
    }


    public function logAction($action, $message, $status)
    {
        $user = Auth::user();
        $context = [];

        // Ajouter uniquement des informations pertinentes au contexte
        if ($user) {
            $context = [
                'user_id' => $user->id,
                'user_name' => $user->nom . ' ' . $user->prenom,
                'email' => $user->email, // Si nécessaire, tu peux ajouter l'email ici mais ne pas loguer le mot de passe.
                'ip_address' => request()->ip(),
            ];
        } else {
            // Si l'utilisateur n'est pas connecté, ajouter des informations minimales au contexte
            $context = [
                'ip_address' => request()->ip(),
                'message' => 'Utilisateur inconnu',
            ];
        }

        // Préparer les données à insérer dans la base
        $data = [
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->nom . ' ' . $user->prenom : 'Utilisateur inconnu',
            'ip_address' => request()->ip(),
            'context' => json_encode($context, JSON_UNESCAPED_UNICODE),
            'action' => $action,
            'message' => $message,
            'status' => $status,
        ];

        // Créer le log
        Log::create($data);
    }
}
