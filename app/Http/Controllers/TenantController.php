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
     * @OA\Get(
     *     path="/api/tenants",
     *     summary="Exibir todos os tenants",
     *     tags={"Tenants"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tenants",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Tenant")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $tenants = $this->tenantService->getAllTenants();
        return response()->json(['tenants' => $tenants], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tenants/{id}",
     *     summary="Exibir um tenant específico",
     *     tags={"Tenants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do tenant",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tenant retornado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Tenant")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tenant não encontrado"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/tenants",
     *     summary="Criar um novo tenant",
     *     tags={"Tenants"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "contact_info"},
     *             @OA\Property(property="name", type="string", description="Nome do tenant"),
     *             @OA\Property(property="contact_info", type="string", description="Informações de contato do tenant")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tenant criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="tenant", ref="#/components/schemas/Tenant")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $tenant = $this->tenantService->createTenant($request->all());
        return response()->json(['message' => 'Tenant criado com sucesso!', 'tenant' => $tenant], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/tenants/{id}",
     *     summary="Atualizar um tenant existente",
     *     tags={"Tenants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do tenant",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Nome do tenant"),
     *             @OA\Property(property="contact_info", type="string", description="Informações de contato do tenant")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tenant atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="tenant", ref="#/components/schemas/Tenant")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tenant não encontrado"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/tenants/{id}",
     *     summary="Remover um tenant",
     *     tags={"Tenants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do tenant",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tenant removido com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tenant não encontrado"
     *     )
     * )
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
