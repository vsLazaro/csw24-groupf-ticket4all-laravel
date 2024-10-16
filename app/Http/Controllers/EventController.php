<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Exibir todos os eventos
     */
    public function index()
    {
        $events = $this->eventService->getAllEvents();
        return response()->json(['events' => $events], 200);
    }

    /**
     * Adicionar um novo evento
     */
    public function store(Request $request)
    {
        $event = $this->eventService->createEvent($request->all());
        return response()->json(['message' => 'Evento criado com sucesso!', 'event' => $event], 201);
    }

    /**
     * Exibir um evento específico
     */
    public function show($id)
    {
        $event = $this->eventService->getEventById($id);

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json(['event' => $event], 200);
    }

    /**
     * Editar um evento existente
     */
    public function update(Request $request, $id)
    {
        $event = $this->eventService->updateEvent($id, $request->all());

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json(['message' => 'Evento atualizado com sucesso!', 'event' => $event], 200);
    }

    /**
     * Remover um evento
     */
    public function destroy($id)
    {
        $deleted = $this->eventService->deleteEvent($id);

        if (!$deleted) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json(['message' => 'Evento removido com sucesso!'], 200);
    }
}
