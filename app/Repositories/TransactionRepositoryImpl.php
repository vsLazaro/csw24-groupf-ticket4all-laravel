<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepositoryImpl implements TransactionRepository
{
    public function getAll()
    {
        return Transaction::all();
    }

    public function findById($id)
    {
        return Transaction::find($id);
    }

    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function update($id, array $data)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            $transaction->update($data);
        }

        return $transaction;
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            return $transaction->delete();
        }

        return false;
    }
}
