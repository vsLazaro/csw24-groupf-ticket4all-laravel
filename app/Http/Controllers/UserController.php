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
     * Listar todos os usuários
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users, 200);
    }

    /**
     * Exibir um usuário específico
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
     * Criar um novo usuário
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
     * Atualizar um usuário existente
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
     * Excluir um usuário
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
