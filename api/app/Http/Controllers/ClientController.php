<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }


    /**
     * @OA\Get(
     *     path="/api/clients",
     *     summary="Retorna os dados do cliente",
     *     description="Retorna todos os clientes/usuarios",
     *     tags={"Clientes/Usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="Array contendo os dados dos clientes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="client_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *                 @OA\Property(property="email", type="string", example="example@email.com"),
     *                 @OA\Property(property="tenant_id", type="integer", example=1),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *             ),
     *         ),
     *     ),
     * )
     */

    public function index()
    {
        // Lista todos os clientes
        $clients = $this->clientService->getAllClients();
        return response()->json($clients);
    }

    /**
     * @OA\Post(
     *    path="/api/client",
     *    summary="Registra um novo cliente",
     *    description="Registra um novo cliente",
     *    tags={"Clientes/Usuarios"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *                type="object",
     *                @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *                @OA\Property(property="email", type="string", example="example@email.com"),
     *                @OA\Property(property="tenant_id", type="integer", example=1),
     *            )
     *        ),
     *    @OA\Response(
     *        response=201,
     *        description="Cliente inserido com sucesso",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="client_id", type="integer", example=1),
     *            @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *            @OA\Property(property="email", type="string", example="example@email.com"),
     *            @OA\Property(property="tenant_id", type="integer", example=1),
     *            @OA\Property(property="updated_at", type="string", format="date-time"),
     *            @OA\Property(property="created_at", type="string", format="date-time"),
     *        ),
     *    ),
     * )
     */

    public function store(Request $request)
    {
        // Valida os dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'tenant_id' => 'required|int',
        ]);

        // Cria um novo cliente
        $client = $this->clientService->createClient($validated);

        return response()->json($client, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/client/{id}",
     *     summary="Retorna os dados do cliente",
     *     description="Retorna todos os clientes/usuarios",
     *     tags={"Clientes/Usuarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id cliente",
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
     *                @OA\Property(property="client_id", type="integer", example=1),
     *                @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *                @OA\Property(property="email", type="string", example="example@email.com"),
     *                @OA\Property(property="tenant_id", type="integer", example=1),
     *                @OA\Property(property="updated_at", type="string", format="date-time"),
     *                @OA\Property(property="created_at", type="string", format="date-time"),
     *         ),
     *     ),
     * )
     */
    public function show($id)
    {
        // Mostra um cliente específico
        $client = $this->clientService->getClientById($id);
        return response()->json($client);
    }


    /**
     * @OA\Put(
     *     path="/api/client/{id}",
     *     summary="Atualiza os dados de um cliente",
     *     description="Atualiza as informações de um cliente existente pelo ID",
     *     tags={"Clientes/Usuarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do cliente a ser atualizado",
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
     *             @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *             @OA\Property(property="email", type="string", example="updated@email.com"),
     *             @OA\Property(property="tenant_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="client_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *             @OA\Property(property="email", type="string", example="updated@email.com"),
     *             @OA\Property(property="tenant_id", type="integer", example=1),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time")
     *             
     *         )
     *     ),
     * )
     */ 
    public function update(Request $request, $id)
    {
        // Valida os dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'tenant_id' => 'required|int',
        ]);

        // Atualiza o cliente
        $client = $this->clientService->updateClient($id, $validated);
        $client->update($validated);

        return response()->json($client);
    }

    /**
     * @OA\Delete(
     *     path="/api/client/{id}",
     *     summary="Deleta um cliente",
     *     description="Remove um cliente existente pelo ID",
     *     tags={"Clientes/Usuarios"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do cliente a ser removido",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente deletado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cliente deletado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Cliente não encontrado.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Cliente não encontrado")
     *          )
     *     ),
     * )
     */
    public function destroy($id)
    {
        $deleted = $this->clientService->deleteClient($id);

        if (!$deleted) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        return response()->json(['message' => 'Cliente deletado com sucesso!']);
    }
}
