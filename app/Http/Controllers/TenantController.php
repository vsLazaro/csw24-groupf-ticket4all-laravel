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
     *     summary="Retorna os dados do tenant",
     *     description="Retorna todos os tenants",
     *     tags={"Tenants"},
     *     @OA\Response(
     *         response=200,
     *         description="Array contendo os dados dos tenants",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="tenant_id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *                 @OA\Property(property="contact_information", type="string", example="algo"),
     *                 @OA\Property(property="specific_information", type="string", example="algo"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *             )
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        $tenants = $this->tenantService->getAllTenants();
        return response()->json($tenants, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/tenant/{id}",
     *     summary="Retorna os dados do tenant",
     *     description="Retorna os dados de um tenant",
     *     tags={"Tenants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do tenant",
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
     *             @OA\Property(property="tenant_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *             @OA\Property(property="contact_information", type="string", example="algo"),
     *             @OA\Property(property="specific_information", type="string", example="algo"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *         ),
     *     ),
     * )
     */
    public function show($id)
    {
        $tenant = $this->tenantService->getTenantById($id);

        if (!$tenant) {
            return response()->json(['message' => 'Tenant não encontrado.'], 404);
        }

        return response()->json($tenant, 200);
    }

    /**
     * @OA\Post(
     *    path="/api/tenant",
     *    summary="Registra um novo tenant",
     *    description="Registra um novo tenant",
     *    tags={"Tenants"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *                type="object",
     *                 @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *                 @OA\Property(property="contact_information", type="string", example="algo"),
     *                 @OA\Property(property="specific_information", type="string", example="algo")
     *            )
     *        ),
     *    @OA\Response(
     *        response=201,
     *        description="Tenant registrado com sucesso",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="tenant_id", type="integer", example=1),
     *            @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *            @OA\Property(property="contact_information", type="string", example="algo"),
     *            @OA\Property(property="specific_information", type="string", example="algo"),
     *            @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *            @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *        ),
     *    ),
     * )
     */
    public function store(Request $request)
    {
        $tenant = $this->tenantService->createTenant($request->all());
        return response()->json($tenant, 201);
    }

     /**
     * @OA\Put(
     *     path="/api/tenant/{id}",
     *     summary="Atualiza os dados do tenant",
     *     description="Atualiza os dados do tenant",
     *     tags={"Tenants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do tenant",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *             @OA\Property(property="contact_information", type="string", example="algo"),
     *             @OA\Property(property="specific_information", type="string", example="algo"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objeto contendo os dados do domínio e mapeamentos vinculados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="tenant_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Bruno Bolzan"),
     *             @OA\Property(property="contact_information", type="string", example="algo"),
     *             @OA\Property(property="specific_information", type="string", example="algo"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-22T15:37:29.000000Z"),
     *         ),
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Tenant não encontrado",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="message", type="string", example="Tenant não encontrado")
     *     )
     *   ),
     * )
     */
    public function update(Request $request, $id)
    {
        $tenant = $this->tenantService->updateTenant($id, $request->all());

        if (!$tenant) {
            return response()->json(['message' => 'Tenant não encontrado.'], 404);
        }

        return response()->json($tenant, 200);
    }

     /**
     * @OA\Delete(
     *     path="/api/tenant/{id}",
     *     summary="Remove um tenant",
     *     description="Remove um tenant",
     *     tags={"Tenants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do tenant",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tenant removido com sucesso",
     *     ),
     *    @OA\Response(
     *         response=404,
     *        description="Tenant não encontrado",
     *       @OA\JsonContent(
     *          type="object",
     *         @OA\Property(property="message", type="string", example="Tenant não encontrado")
     *     )
     *   ),
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
