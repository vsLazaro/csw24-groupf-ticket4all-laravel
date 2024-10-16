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

    /**
     * Exibir todas as transações
     */
    public function index()
    {
        $transactions = $this->transactionService->getAllTransactions();
        return response()->json(['transactions' => $transactions], 200);
    }

    /**
     * Exibir uma transação específica
     */
    public function show($id)
    {
        $transaction = $this->transactionService->getTransactionById($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json(['transaction' => $transaction], 200);
    }

    /**
     * Criar uma nova transação
     */
    public function store(Request $request)
    {
        $transaction = $this->transactionService->createTransaction($request->all());
        return response()->json(['message' => 'Transação criada com sucesso!', 'transaction' => $transaction], 201);
    }

    /**
     * Atualizar uma transação existente
     */
    public function update(Request $request, $id)
    {
        $transaction = $this->transactionService->updateTransaction($id, $request->all());

        if (!$transaction) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json(['message' => 'Transação atualizada com sucesso!', 'transaction' => $transaction], 200);
    }

    /**
     * Remover uma transação
     */
    public function destroy($id)
    {
        $deleted = $this->transactionService->deleteTransaction($id);

        if (!$deleted) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json(['message' => 'Transação removida com sucesso!'], 200);
    }
}
