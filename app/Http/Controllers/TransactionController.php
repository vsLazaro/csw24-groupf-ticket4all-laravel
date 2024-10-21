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
     * @OA\Get(
     *     path="/api/transactions",
     *     summary="Exibir todas as transações",
     *     tags={"Transactions"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de transações",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Transaction")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $transactions = $this->transactionService->getAllTransactions();
        return response()->json(['transactions' => $transactions], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/transactions/{id}",
     *     summary="Exibir uma transação específica",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da transação",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transação retornada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transação não encontrada"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/transactions",
     *     summary="Criar uma nova transação",
     *     tags={"Transactions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"tenant_id", "buyer_id", "ticket_id", "price", "status"},
     *             @OA\Property(property="tenant_id", type="integer", description="ID do tenant"),
     *             @OA\Property(property="buyer_id", type="integer", description="ID do comprador"),
     *             @OA\Property(property="ticket_id", type="integer", description="ID do ticket"),
     *             @OA\Property(property="price", type="number", format="float", description="Preço da transação"),
     *             @OA\Property(property="status", type="string", description="Status da transação (pendente, concluída, cancelada)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transação criada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="transaction", ref="#/components/schemas/Transaction")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $transaction = $this->transactionService->createTransaction($request->all());
        return response()->json(['message' => 'Transação criada com sucesso!', 'transaction' => $transaction], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/transactions/{id}",
     *     summary="Atualizar uma transação existente",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da transação",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="tenant_id", type="integer", description="ID do tenant"),
     *             @OA\Property(property="buyer_id", type="integer", description="ID do comprador"),
     *             @OA\Property(property="ticket_id", type="integer", description="ID do ticket"),
     *             @OA\Property(property="price", type="number", format="float", description="Preço da transação"),
     *             @OA\Property(property="status", type="string", description="Status da transação (pendente, concluída, cancelada)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transação atualizada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="transaction", ref="#/components/schemas/Transaction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transação não encontrada"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/transactions/{id}",
     *     summary="Remover uma transação",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da transação",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transação removida com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transação não encontrada"
     *     )
     * )
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
