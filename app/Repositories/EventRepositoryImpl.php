<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepositoryImpl implements EventRepository
{
    public function getAll()
    {
        return Event::all();
    }

    public function findById($id)
    {
        return Event::find($id);
    }

    public function create(array $data)
    {
        return Event::create($data);
    }

    public function update($id, array $data)
    {
        $event = Event::find($id);

        if ($event) {
            $event->update($data);
        }

        return $event;
    }

    public function delete($id)
    {
        $event = Event::find($id);

        if ($event) {
            return $event->delete();
        }

        return false;
    }
}
