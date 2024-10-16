<?php

namespace App\Repositories;

use App\Models\NotificationPreference;

class NotificationPreferenceRepositoryImpl implements NotificationPreferenceRepository
{
    public function getAll()
    {
        return NotificationPreference::all();
    }

    public function findById($id)
    {
        return NotificationPreference::find($id);
    }

    public function create(array $data)
    {
        return NotificationPreference::create($data);
    }

    public function update($id, array $data)
    {
        $notificationPreference = NotificationPreference::find($id);

        if ($notificationPreference) {
            $notificationPreference->update($data);
        }

        return $notificationPreference;
    }

    public function delete($id)
    {
        $notificationPreference = NotificationPreference::find($id);

        if ($notificationPreference) {
            return $notificationPreference->delete();
        }

        return false;
    }
}
