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
     *     path="/api/notifications",
     *     summary="Retorna os dados de preferencia de notificação",
     *     description="Retorna todos as preferencias de notificação",
     *     tags={"Preferencias de notificação"},
     *     @OA\Response(
     *         response=200,
     *         description="Array contendo os dados das preferencias de notificação",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="client_id", type="integer", example=1),
     *                 @OA\Property(property="receive_email", type="boolean", example=true),
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        $notifications = $this->notificationPreferenceService->getAllNotificationPreferences();
        return response()->json($notifications, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/notification/{id}",
     *     summary="Retorna os dados de preferencia de notificação",
     *     description="Retorna os dados de preferencia de notificação",
     *     tags={"Preferencias de notificação"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id da preferencia de notificação",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),

     *     @OA\Response(
     *         response=200,
     *         description="Objeto contendo os dados do domínio e mapeamentos vinculados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="receive_email", type="boolean", example=true),
     *         ),
     *     ),
     * )
     */
    public function show($id)
    {
        $notification = $this->notificationPreferenceService->getNotificationPreferenceById($id);

        if (!$notification) {
            return response()->json(['message' => 'Preferencia de notificação não encontrada.'], 404);
        }

        return response()->json($notification, 200);
    }

    /**
     * @OA\Post(
     *    path="/api/notification",
     *    summary="Registra uma nova preferencia de notificação",
     *    description="Registra uma nova preferencia de notificação",
     *    tags={"Preferencias de notificação"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="client_id", type="integer", example=1),
     *                @OA\Property(property="receive_email", type="boolean", example=true),
     *            )
     *        ),
     *    @OA\Response(
     *        response=201,
     *        description="Preferencia de notificação registrada com sucesso",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="client_id", type="integer", example=1),
     *            @OA\Property(property="receive_email", type="boolean", example=true),
     *        ),
     *    ),
     * )
     */
    public function store(Request $request)
    {
        $notification = $this->notificationPreferenceService->createNotificationPreference($request->all());
        return response()->json($notification, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/notification/{id}",
     *     summary="Atualiza os dados de preferencia de notificação",
     *     description="Atualiza os dados de preferencia de notificação",
     *     tags={"Preferencias de notificação"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id da preferencia de notificação",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="receive_email", type="boolean", example=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objeto contendo os dados do domínio e mapeamentos vinculados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="receive_email", type="boolean", example=true),
     *         ),
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Preferencia de notificação não encontrada",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="message", type="string", example="Preferencia de notificação não encontrada")
     *     )
     *   ),
     * )
     */
    public function update(Request $request, $id)
    {
        $notification = $this->notificationPreferenceService->updateNotificationPreference($id, $request->all());

        if (!$notification) {
            return response()->json(['message' => 'Preferencia de notificação não encontrada.'], 404);
        }

        return response()->json($notification, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/notification/{id}",
     *     summary="Remove uma preferencia de notificação",
     *     description="Remove uma preferencia de notificação",
     *     tags={"Preferencias de notificação"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id da preferencia de notificação",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preferencia de notificação removida com sucesso",
     *     ),
     *    @OA\Response(
     *         response=404,
     *        description="Preferencia de notificação não encontrada",
     *       @OA\JsonContent(
     *          type="object",
     *         @OA\Property(property="message", type="string", example="Preferencia de notificação não encontrada")
     *     )
     *   ),
     * )
     */
    public function destroy($id)
    {
        $deleted = $this->notificationPreferenceService->deleteNotificationPreference($id);

        if (!$deleted) {
            return response()->json(['message' => 'Preferencia de notificação não encontrada.'], 404);
        }

        return response()->json(['message' => 'Preferencia de notificação removida com sucesso!'], 200);
    }
}
