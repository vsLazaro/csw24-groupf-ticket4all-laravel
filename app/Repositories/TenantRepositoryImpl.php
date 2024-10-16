<?php

namespace App\Repositories;

use App\Models\Tenant;

class TenantRepositoryImpl implements TenantRepository
{
    public function getAll()
    {
        return Tenant::all();
    }

    public function findById($id)
    {
        return Tenant::find($id);
    }

    public function create(array $data)
    {
        return Tenant::create($data);
    }

    public function update($id, array $data)
    {
        $tenant = Tenant::find($id);

        if ($tenant) {
            $tenant->update($data);
        }

        return $tenant;
    }

    public function delete($id)
    {
        $tenant = Tenant::find($id);

        if ($tenant) {
            return $tenant->delete();
        }

        return false;
    }
}
