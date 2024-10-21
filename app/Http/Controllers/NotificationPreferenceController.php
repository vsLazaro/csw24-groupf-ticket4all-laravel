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
     * @OA\Get(
     *     path="/api/notification-preferences",
     *     summary="Exibir Preferências de Notificação do Usuário",
     *     tags={"Notification Preferences"},
     *     @OA\Response(
     *         response=200,
     *         description="Preferências de notificação do usuário",
     *         @OA\JsonContent(
     *             @OA\Property(property="preferences", type="object", description="Preferências de notificação")
     *         )
     *     )
     * )
     */
    public function show()
    {
        $preferences = $this->notificationPreferenceService->getPreferences();
        return response()->json(['preferences' => $preferences], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/notification-preferences",
     *     summary="Atualizar Preferências de Notificação do Usuário",
     *     tags={"Notification Preferences"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"preferences"},
     *             @OA\Property(property="preferences", type="object", description="Preferências de notificação atualizadas")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preferências de notificação atualizadas com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="preferences", type="object", description="Preferências de notificação")
     *         )
     *     )
     * )
     */
    public function update(Request $request)
    {
        $preferences = $this->notificationPreferenceService->updatePreferences($request->input('preferences'));
        return response()->json(['message' => 'Preferências de notificação atualizadas com sucesso!', 'preferences' => $preferences], 200);
    }
}
