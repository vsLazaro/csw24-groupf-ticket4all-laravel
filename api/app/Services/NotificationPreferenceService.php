<?php

namespace App\Services;

use App\Repositories\NotificationPreferenceRepository;

class NotificationPreferenceService
{
    protected $notificationPreferenceRepository;

    public function __construct(NotificationPreferenceRepository $notificationPreferenceRepository)
    {
        $this->notificationPreferenceRepository = $notificationPreferenceRepository;
    }

    public function getAllNotificationPreferences()
    {
        return $this->notificationPreferenceRepository->getAll();
    }

    public function getNotificationPreferenceById($id)
    {
        return $this->notificationPreferenceRepository->findById($id);
    }

    public function createNotificationPreference($data)
    {
        return $this->notificationPreferenceRepository->create($data);
    }

    public function updateNotificationPreference($id, $data)
    {
        return $this->notificationPreferenceRepository->update($id, $data);
    }

    public function deleteNotificationPreference($id)
    {
        return $this->notificationPreferenceRepository->delete($id);
    }
}
