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

 
    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Retorna os dados do evento",
     *     description="Retorna todos os evento",
     *     tags={"Eventos"},
     *     @OA\Response(
     *         response=200,
     *         description="Array contendo os dados dos eventos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="event_id", type="integer", example=1),
     *                 @OA\Property(property="event_name", type="string", example="love bar"),
     *                 @OA\Property(property="type", type="string", example="festa dos guri"),
     *                 @OA\Property(property="tenant_id", type="integer", example=1),
     *                 @OA\Property(property="location", type="string", example="Porto Alegre"),
     *                 @OA\Property(property="event_date", type="string", format="date", example="2024-10-23"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        $events = $this->eventService->getAllEvents();
        return response()->json($events, 200);
    }


     /**
     * @OA\Post(
     *    path="/api/event",
     *    summary="Registra um novo event",
     *    description="Registra um novo evento",
     *    tags={"Eventos"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="event_name", type="string", example="love bar"),
     *                @OA\Property(property="type", type="string", example="festa dos guri"),
     *                @OA\Property(property="tenant_id", type="integer", example=1),
     *                @OA\Property(property="location", type="string", example="Porto Alegre"),
     *                @OA\Property(property="event_date", type="string", format="date", example="2024-10-23"),
     *            )
     *        ),
     *    @OA\Response(
     *        response=201,
     *        description="Evento inserido com sucesso",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="event_id", type="integer", example=1),
     *            @OA\Property(property="event_name", type="string", example="love bar"),
     *            @OA\Property(property="type", type="string", example="festa dos guri"),
     *            @OA\Property(property="tenant_id", type="integer", example=1),
     *            @OA\Property(property="location", type="string", example="Porto Alegre"),
     *            @OA\Property(property="event_date", type="string", format="date", example="2024-10-23"),
     *            @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *            @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *        ),
     *    ),
     * )
     */
    public function store(Request $request)
    {
        $event = $this->eventService->createEvent($request->all());
        return response()->json($event, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/event/{id}",
     *     summary="Retorna os dados do evento",
     *     description="Retorna todos os evento",
     *     tags={"Eventos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id evento",
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
     *             @OA\Property(property="event_id", type="integer", example=1),
     *             @OA\Property(property="event_name", type="string", example="love bar"),
     *             @OA\Property(property="type", type="string", example="festa dos guri"),
     *             @OA\Property(property="tenant_id", type="integer", example=1),
     *             @OA\Property(property="location", type="string", example="Porto Alegre"),
     *             @OA\Property(property="event_date", type="string", format="date", example="2024-10-23"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *         ),
     *     ),
     * )
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
     *     path="/api/event/{id}",
     *     summary="Atualiza os dados de um event",
     *     description="Atualiza as informações de um event existente pelo ID",
     *     tags={"Eventos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do evento a ser atualizado",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Objeto contendo os dados a serem atualizados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="event_name", type="string", example="love bar"),
     *             @OA\Property(property="type", type="string", example="festa dos guri"),
     *             @OA\Property(property="tenant_id", type="integer", example=1),
     *             @OA\Property(property="location", type="string", example="Porto Alegre"),
     *             @OA\Property(property="event_date", type="string", format="date", example="2024-10-23"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evento atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="event_id", type="integer", example=1),
     *             @OA\Property(property="event_name", type="string", example="love bar"),
     *             @OA\Property(property="type", type="string", example="festa dos guri"),
     *             @OA\Property(property="tenant_id", type="integer", example=1),
     *             @OA\Property(property="location", type="string", example="Porto Alegre"),
     *             @OA\Property(property="event_date", type="string", format="date", example="2024-10-23"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *         ),
     *        
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Evento não encontrado.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Evento não encontrado")
     *          )
     *     ),
     * )
     */ 

    public function update(Request $request, $id)
    {
        $event = $this->eventService->updateEvent($id, $request->all());

        if (!$event) {
            return response()->json(['message' => 'Evento não encontrado.'], 404);
        }

        return response()->json($event, 200);
    }

  
     /**
     * @OA\Delete(
     *     path="/api/event/{id}",
     *     summary="Deleta um evento",
     *     description="Remove um evento existente pelo ID",
     *     tags={"Eventos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do evento a ser removido",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evento deletado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Evento removido com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Evento não encontrado.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Evento não encontrado")
     *          )
     *     ),
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
