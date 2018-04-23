<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\Account;

class TransactionController extends Controller
{
    protected $user_id;

    /**
     * Validate data posted
     */
    protected function validateTransaction($request, $id = null)
    {
        // user_id nunca pode ser passado.
        $this->user_id = $request->user_id;

        $validator = Validator::make(
            $request->all(),
            [
                'date' => 'required|date',
                'description' => 'required|string|max:191',
                'value' => 'required|numeric',
                'source_account_id' => [
                    'required',
                    'integer',
                    Rule::exists('accounts', 'id')->where(function ($query) {
                        $query->where('user_id', $this->user_id);
                    }),
                ],
                'destination_account_id' => [
                    'required',
                    'integer',
                    Rule::exists('accounts', 'id')->where(function ($query) {
                        $query->where('user_id', $this->user_id);
                    }),
                ]
            ]
        );

        return $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Adicionar where com user_id autenticado
            $list = TransactionResource::collection(Transaction::paginate());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        return $list;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateTransaction($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['date', 'description', 'value', 'source_account_id', 'destination_account_id']);

        DB::beginTransaction();

        try {
            $accountSource = Account::find($data['source_account_id']);
            $accountSource->balance -= $data['value'];
            $accountSource->save();
            $accountDestination = Account::find($data['destination_account_id']);
            $accountDestination->balance += $data['value'];
            $accountDestination->save();
            $transaction = Transaction::create($data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        return response()->json(['data' => $transaction], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        try {
            // Adicionar where com user_id autenticado
            $transaction = new TransactionResource(Transaction::find($id));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        if ($transaction->resource) {
            return response()->json([$transaction], 200);
        } else {
            return response()->json(['message' => 'Movimentação com ID ' . $id . ' não encontrada.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        $validator = $this->validateTransaction($request, $id);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['date', 'description', 'value', 'source_account_id', 'destination_account_id']);

        DB::beginTransaction();

        try {
            $transaction = Transaction::find($id);

            //dd($transaction->accountSource->user_id);

            if (($transaction->accountSource->user_id == $this->user_id) && ($transaction->accountDestination->user_id == $this->user_id)) {
                $accountSourceOld = Account::find($transaction->source_account_id);
                $accountSourceOld->balance += $transaction->value;
                $accountSourceOld->save();
                $accountDestinationOld = Account::find($transaction->destination_account_id);
                $accountDestinationOld->balance -= $transaction->value;
                $accountDestinationOld->save();
                $accountSource = Account::find($data['source_account_id']);
                $accountSource->balance -= $data['value'];
                $accountSource->save();
                $accountDestination = Account::find($data['destination_account_id']);
                $accountDestination->balance += $data['value'];
                $accountDestination->save();
                $transaction->update($data);

                DB::commit();
            } else {
                DB::rollBack();

                return response()->json(['message' => 'Movimentação com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        return response()->json(['data' => $transaction], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        DB::beginTransaction();

        try {
            $transaction = Transaction::find($id);
            $accountSourceOld = Account::find($transaction->source_account_id);
            $accountSourceOld->balance += $transaction->value;
            $accountSourceOld->save();
            $accountDestinationOld = Account::find($transaction->destination_account_id);
            $accountDestinationOld->balance -= $transaction->value;
            $accountDestinationOld->save();

            if ($account) {
                $account->delete();

                return response()->json(['message' => 'Conta removida.'], 204);
            } else {
                return response()->json(['message' => 'Categoria com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }
    }
}
