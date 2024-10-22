<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = $this->transactionService->getAllTransactions();
        return response()->json($transactions, 200);
    }

    public function show($id)
    {
        $transaction = $this->transactionService->getTransactionById($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json($transaction, 200);
    }

    public function store(Request $request)
    {
        $transaction = $this->transactionService->createTransaction($request->all());
        return response()->json($transaction, 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = $this->transactionService->updateTransaction($id, $request->all());

        if (!$transaction) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json($transaction, 200);
    }

    public function destroy($id)
    {
        $deleted = $this->transactionService->deleteTransaction($id);

        if (!$deleted) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json(['message' => 'Transação removida com sucesso!'], 200);
    }
}
