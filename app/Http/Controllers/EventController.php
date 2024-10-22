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
     * @OA\Get(
     *     path="/api/events",
     *     summary="Exibir todos os eventos",
     *     tags={"Events"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de eventos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Event")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $events = $this->eventService->getAllEvents();
        return response()->json(['events' => $events], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/events",
     *     summary="Adicionar um novo evento",
     *     tags={"Events"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "date"},
     *             @OA\Property(property="name", type="string", description="Nome do evento"),
     *             @OA\Property(property="description", type="string", description="Descrição do evento"),
     *             @OA\Property(property="date", type="string", format="date", description="Data do evento")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Evento criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="event", ref="#/components/schemas/Event")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $event = $this->eventService->createEvent($request->all());
        return response()->json(['message' => 'Evento criado com sucesso!', 'event' => $event], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     summary="Exibir um evento específico",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do evento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evento retornado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evento não encontrado"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/events/{id}",
     *     summary="Editar um evento existente",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do evento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description", "date"},
     *             @OA\Property(property="name", type="string", description="Nome do evento"),
     *             @OA\Property(property="description", type="string", description="Descrição do evento"),
     *             @OA\Property(property="date", type="string", format="date", description="Data do evento")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evento atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="event", ref="#/components/schemas/Event")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evento não encontrado"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/events/{id}",
     *     summary="Remover um evento",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do evento",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evento removido com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evento não encontrado"
     *     )
     * )
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
