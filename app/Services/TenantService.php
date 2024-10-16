<?php

namespace App\Services;

use App\Repositories\TenantRepository;

class TenantService
{
    protected $tenantRepository;

    public function __construct(TenantRepository $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
    }

    public function getAllTenants()
    {
        return $this->tenantRepository->getAll();
    }

    public function getTenantById($id)
    {
        return $this->tenantRepository->findById($id);
    }

    public function createTenant($data)
    {
        return $this->tenantRepository->create($data);
    }

    public function updateTenant($id, $data)
    {
        return $this->tenantRepository->update($id, $data);
    }

    public function deleteTenant($id)
    {
        return $this->tenantRepository->delete($id);
    }
}
