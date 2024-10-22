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

    
    public function index()
    {
        $notifications = $this->notificationPreferenceService->getAllNotificationPreferences();
        return response()->json($notifications, 200);
    }

    public function show($id)
    {
        $notification = $this->notificationPreferenceService->getNotificationPreferenceById($id);

        if (!$notification) {
            return response()->json(['message' => 'Preferencia de notificação não encontrada.'], 404);
        }

        return response()->json($notification, 200);
    }

    public function store(Request $request)
    {
        $notification = $this->notificationPreferenceService->createNotificationPreference($request->all());
        return response()->json($notification, 201);
    }

    public function update(Request $request, $id)
    {
        $notification = $this->notificationPreferenceService->updateNotificationPreference($id, $request->all());

        if (!$notification) {
            return response()->json(['message' => 'Preferencia de notificação não encontrada.'], 404);
        }

        return response()->json($notification, 200);
    }

    public function destroy($id)
    {
        $deleted = $this->notificationPreferenceService->deleteNotificationPreference($id);

        if (!$deleted) {
            return response()->json(['message' => 'Preferencia de notificação não encontrada.'], 404);
        }

        return response()->json(['message' => 'Preferencia de notificação removida com sucesso!'], 200);
    }
}
