<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

  
    public function index()
    {
        $events = $this->eventService->getAllEvents();
        return response()->json($events, 200);
    }

    public function store(Request $request)
    {
        $event = $this->eventService->createEvent($request->all());
        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = $this->eventService->getEventById($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json(['event' => $event], 200);
    }

    public function update(Request $request, $id)
    {
        $event = $this->eventService->updateEvent($id, $request->all());

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json(['message' => 'Evento atualizado com sucesso!', 'event' => $event], 200);
    }

  
    public function destroy($id)
    {
        $deleted = $this->eventService->deleteEvent($id);

        if (!$deleted) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json(['message' => 'Evento removido com sucesso!'], 200);
    }
}
