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

    public function index()
    {
        // Lista todos os clientes
        $clients = $this->clientService->getAllClients();
        return response()->json($clients);
    }

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

    public function show($id)
    {
        // Mostra um cliente específico
        $client = $this->clientService->getClientById($id);
        return response()->json($client);
    }


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

    public function destroy($id)
    {
        $deleted = $this->clientService->deleteClient($id);

        if (!$deleted) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        return response()->json(['message' => 'Cliente deletado com sucesso!']);
    }
}
