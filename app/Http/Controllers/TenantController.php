<?php

namespace App\Http\Controllers;

use App\Services\TenantService;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Exibir todos os tenants
     */
    public function index()
    {
        $tenants = $this->tenantService->getAllTenants();
        return response()->json(['tenants' => $tenants], 200);
    }

    /**
     * Exibir um tenant específico
     */
    public function show($id)
    {
        $tenant = $this->tenantService->getTenantById($id);

        if (!$tenant) {
            return response()->json(['message' => 'Tenant não encontrado.'], 404);
        }

        return response()->json(['tenant' => $tenant], 200);
    }

    /**
     * Criar um novo tenant
     */
    public function store(Request $request)
    {
        $tenant = $this->tenantService->createTenant($request->all());
        return response()->json(['message' => 'Tenant criado com sucesso!', 'tenant' => $tenant], 201);
    }

    /**
     * Atualizar um tenant existente
     */
    public function update(Request $request, $id)
    {
        $tenant = $this->tenantService->updateTenant($id, $request->all());

        if (!$tenant) {
            return response()->json(['message' => 'Tenant não encontrado.'], 404);
        }

        return response()->json(['message' => 'Tenant atualizado com sucesso!', 'tenant' => $tenant], 200);
    }

    /**
     * Remover um tenant
     */
    public function destroy($id)
    {
        $deleted = $this->tenantService->deleteTenant($id);

        if (!$deleted) {
            return response()->json(['message' => 'Tenant não encontrado.'], 404);
        }

        return response()->json(['message' => 'Tenant removido com sucesso!'], 200);
    }
}
