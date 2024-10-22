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
     *     summary="Retorna os dados da transação",
     *     description="Retorna todos as transações",
     *     tags={"Transactions"},
     *     @OA\Response(
     *         response=200,
     *         description="Array contendo os dados das transações",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="transaction_id", type="integer", example=1),
     *                 @OA\Property(property="ticket_id", type="integer", example=1),
     *                 @OA\Property(property="transaction_id", type="integer", example=1),
     *                 @OA\Property(property="buyer_id", type="integer", example=1),
     *                 @OA\Property(property="price", type="number", example=100.00),
     *                 @OA\Property(property="transaction_date", type="string", format="date", example="2024-10-23"),
     *                 @OA\Property(property="status", type="string", example="approved"),
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        $transactions = $this->transactionService->getAllTransactions();
        return response()->json($transactions, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/transaction/{id}",
     *     summary="Retorna os dados da transaction",
     *     description="Retorna os dados de uma transaction",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id da transaction",
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
     *             @OA\Property(property="transaction_id", type="integer", example=1),
     *             @OA\Property(property="ticket_id", type="integer", example=1),
     *             @OA\Property(property="transaction_id", type="integer", example=1),
     *             @OA\Property(property="buyer_id", type="integer", example=1),
     *             @OA\Property(property="price", type="number", example=100.00),
     *             @OA\Property(property="transaction_date", type="string", format="date", example="2024-10-23"),
     *             @OA\Property(property="status", type="string", example="approved"),
     *         ),
     *     ),
     * )
     */
    public function show($id)
    {
        $transaction = $this->transactionService->getTransactionById($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json($transaction, 200);
    }

    /**
     * @OA\Post(
     *    path="/api/transaction",
     *    summary="Registra uma nova transaction",
     *    description="Registra uma nova transaction",
     *    tags={"Transactions"},
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *                type="object",
     *                 @OA\Property(property="ticket_id", type="integer", example=1),
     *                 @OA\Property(property="transaction_id", type="integer", example=1),
     *                 @OA\Property(property="buyer_id", type="integer", example=1),
     *                 @OA\Property(property="price", type="number", example=100.00),
     *                 @OA\Property(property="transaction_date", type="string", format="date", example="2024-10-23"),
     *                 @OA\Property(property="status", type="string", example="approved"),
     *            )
     *        ),
     *    @OA\Response(
     *        response=201,
     *        description="Transaction registrado com sucesso",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="transaction_id", type="integer", example=1),
     *            @OA\Property(property="ticket_id", type="integer", example=1),
     *            @OA\Property(property="transaction_id", type="integer", example=1),
     *            @OA\Property(property="buyer_id", type="integer", example=1),
     *            @OA\Property(property="price", type="number", example=100.00),
     *            @OA\Property(property="transaction_date", type="string", format="date", example="2024-10-23"),
     *            @OA\Property(property="status", type="string", example="approved"),
     *        ),
     *    ),
     * )
     */
    public function store(Request $request)
    {
        $transaction = $this->transactionService->createTransaction($request->all());
        return response()->json($transaction, 201);
    }

     /**
     * @OA\Put(
     *     path="/api/transaction/{id}",
     *     summary="Atualiza os dados do transaction",
     *     description="Atualiza os dados do transaction",",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do transaction",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="transaction_id", type="integer", example=1),
     *             @OA\Property(property="ticket_id", type="integer", example=1),
     *             @OA\Property(property="transaction_id", type="integer", example=1),
     *             @OA\Property(property="buyer_id", type="integer", example=1),
     *             @OA\Property(property="price", type="number", example=100.00),
     *             @OA\Property(property="transaction_date", type="string", format="date", example="2024-10-23"),
     *             @OA\Property(property="status", type="string", example="approved"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objeto contendo os dados do domínio e mapeamentos vinculados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="transaction_id", type="integer", example=1),
     *             @OA\Property(property="ticket_id", type="integer", example=1),
     *             @OA\Property(property="transaction_id", type="integer", example=1),
     *             @OA\Property(property="buyer_id", type="integer", example=1),
     *             @OA\Property(property="price", type="number", example=100.00),
     *             @OA\Property(property="transaction_date", type="string", format="date", example="2024-10-23"),
     *             @OA\Property(property="status", type="string", example="approved"),
     *         ),
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Transaction não encontrado",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="message", type="string", example="Transaction não encontrado")
     *     )
     *   ),
     * )
     */
    public function update(Request $request, $id)
    {
        $transaction = $this->transactionService->updateTransaction($id, $request->all());

        if (!$transaction) {
            return response()->json(['message' => 'Transação não encontrada.'], 404);
        }

        return response()->json($transaction, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/transaction/{id}",
     *     summary="Remove um transaction",
     *     description="Remove um transaction",
     *     tags={"Transactions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do transaction",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction removido com sucesso",
     *     ),
     *    @OA\Response(
     *         response=404,
     *        description="Transaction não encontrado",
     *       @OA\JsonContent(
     *          type="object",
     *         @OA\Property(property="message", type="string", example="Transaction não encontrado")
     *     )
     *   ),
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
