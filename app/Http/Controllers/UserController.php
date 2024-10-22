<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Listar todos os usuários",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Exibir um usuário específico",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário retornado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Criar um novo usuário",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", description="Nome do usuário"),
     *             @OA\Property(property="email", type="string", description="Email do usuário"),
     *             @OA\Property(property="password", type="string", description="Senha do usuário")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = $this->userService->createUser($data);

        return response()->json(['message' => 'Usuário criado com sucesso!', 'user' => $user], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Atualizar um usuário existente",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Nome do usuário"),
     *             @OA\Property(property="email", type="string", description="Email do usuário"),
     *             @OA\Property(property="password", type="string", description="Senha do usuário")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,'.$id,
            'password' => 'sometimes|string|min:8',
        ]);

        $user = $this->userService->updateUser($id, $data);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado ou não foi possível atualizar.'], 404);
        }

        return response()->json(['message' => 'Usuário atualizado com sucesso!', 'user' => $user], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Excluir um usuário",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário excluído com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado ou não foi possível excluir"
     *     )
     * )
     */
    public function destroy($id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return response()->json(['message' => 'Usuário não encontrado ou não foi possível excluir.'], 404);
        }

        return response()->json(['message' => 'Usuário excluído com sucesso!'], 200);
    }
}
