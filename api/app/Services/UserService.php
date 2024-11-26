<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function createUser($data)
    {
        $data['password'] = bcrypt($data['password']); // Fazendo o hash da senha
        return $this->userRepository->create($data);
    }

    public function updateUser($id, $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']); // Fazendo o hash da senha, se for atualizada
        }

        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}
