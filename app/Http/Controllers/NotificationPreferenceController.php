<?php

namespace App\Http\Controllers;

use App\Services\NotificationPreferenceService;
use Illuminate\Http\Request;

class NotificationPreferenceController extends Controller
{
    protected $notificationPreferenceService;

    public function __construct(NotificationPreferenceService $notificationPreferenceService)
    {
        $this->notificationPreferenceService = $notificationPreferenceService;
    }

    /**
     * Exibir Preferências de Notificação do Usuário
     */
    public function show()
    {
        $preferences = $this->notificationPreferenceService->getPreferences();
        return response()->json(['preferences' => $preferences], 200);
    }

    /**
     * Atualizar Preferências de Notificação do Usuário
     */
    public function update(Request $request)
    {
        $preferences = $this->notificationPreferenceService->updatePreferences($request->input('preferences'));
        return response()->json(['message' => 'Preferências de notificação atualizadas com sucesso!', 'preferences' => $preferences], 200);
    }
}
