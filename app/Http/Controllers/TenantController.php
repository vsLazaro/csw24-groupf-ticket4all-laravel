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

    public function index()
    {
        $tenants = $this->tenantService->getAllTenants();
        return response()->json($tenants, 200);
    }

    public function show($id)
    {
        $tenant = $this->tenantService->getTenantById($id);

        if (!$tenant) {
            return response()->json(['message' => 'Tenant não encontrado.'], 404);
        }

        return response()->json($tenant, 200);
    }

    public function store(Request $request)
    {
        $tenant = $this->tenantService->createTenant($request->all());
        return response()->json($tenant, 201);
    }

    public function update(Request $request, $id)
    {
        $tenant = $this->tenantService->updateTenant($id, $request->all());

        if (!$tenant) {
            return response()->json(['message' => 'Tenant não encontrado.'], 404);
        }

        return response()->json($tenant, 200);
    }

    public function destroy($id)
    {
        $deleted = $this->tenantService->deleteTenant($id);

        if (!$deleted) {
            return response()->json(['message' => 'Tenant não encontrado.'], 404);
        }

        return response()->json(['message' => 'Tenant removido com sucesso!'], 200);
    }
}
