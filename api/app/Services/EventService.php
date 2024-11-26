<?php

namespace App\Services;

use App\Repositories\EventRepositoryImpl;

class EventService
{
    protected $eventRepository;

    public function __construct(EventRepositoryImpl $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getAllEvents()
    {
        return $this->eventRepository->getAll();
    }

    public function getEventById($id)
    {
        return $this->eventRepository->findById($id);
    }

    public function createEvent($data)
    {
        return $this->eventRepository->create($data);
    }

    public function updateEvent($id, $data)
    {
        return $this->eventRepository->update($id, $data);
    }

    public function deleteEvent($id)
    {
        return $this->eventRepository->delete($id);
    }
}
