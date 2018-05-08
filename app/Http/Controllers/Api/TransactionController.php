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
    /**
     * Validate data posted
     */
    protected function validateTransaction($request, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'date' => 'required|date',
                'description' => 'required|string|max:191',
                'value' => 'required|numeric',
                'source_account_id' => [
                    'required',
                    'integer',
                    Rule::exists('accounts', 'id')->where(function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    }),
                ],
                'destination_account_id' => [
                    'required',
                    'integer',
                    Rule::exists('accounts', 'id')->where(function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    }),
                ]
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TransactionResource::collection(
            Transaction::join(
                'accounts',
                'transactions.source_account_id',
                '=',
                'accounts.id'
            )->join(
                'users',
                'accounts.user_id',
                '=',
                'users.id'
            )->select(
                'transactions.*'
            )->where(
                'users.id',
                '=',
                auth()->user()->id
            )->paginate()
        );
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
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['date', 'description', 'value', 'source_account_id', 'destination_account_id']);

        DB::beginTransaction();

        try {
            $transaction = Transaction::create($data);
            $transaction->accountSource->balance -= $transaction->value;
            $transaction->accountSource->save();
            $transaction->accountDestination->balance += $transaction->value;
            $transaction->accountDestination->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Internal server error.'], 500);
        }

        return response()->json([$transaction], 201);
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

        $transaction = new TransactionResource(
            Transaction::join(
                'accounts',
                'transactions.source_account_id',
                '=',
                'accounts.id'
            )->join(
                'users',
                'accounts.user_id',
                '=',
                'users.id'
            )->select(
                'transactions.*'
            )->where(
                [
                    ['users.id', '=', auth()->user()->id],
                    ['transactions.id', '=', $id]
                ]
            )->first()
        );

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
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['date', 'description', 'value', 'source_account_id', 'destination_account_id']);

        DB::beginTransaction();

        try {
            $transaction = Transaction::find($id);

            if ($transaction && ($transaction->accountSource->user_id == auth()->user()->id) && ($transaction->accountDestination->user_id == auth()->user()->id)) {
                $transaction->accountSource->balance += $transaction->value;
                $transaction->accountSource->save();
                $transaction->accountDestination->balance -= $transaction->value;
                $transaction->accountDestination->save();
                $transaction->update($data);

                $accountSource = Account::find($data['source_account_id']);
                $accountSource->balance -= $data['value'];
                $accountSource->save();
                $accountDestination = Account::find($data['destination_account_id']);
                $accountDestination->balance += $data['value'];
                $accountDestination->save();

                DB::commit();

                return response()->json([$transaction], 201);
            } else {
                DB::rollBack();

                return response()->json(['message' => 'Movimentação com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Internal server error.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        DB::beginTransaction();

        try {
            $transaction = Transaction::find($id);

            if ($transaction && ($transaction->accountSource->user_id == auth()->user()->id) && ($transaction->accountDestination->user_id == auth()->user()->id)) {
                $transaction->accountSource->balance += $transaction->value;
                $transaction->accountSource->save();
                $transaction->accountDestination->balance -= $transaction->value;
                $transaction->accountDestination->save();
                $transaction->delete();

                DB::commit();

                return response()->json(['message' => 'Movimentação removida.'], 204);
            } else {
                DB::rollBack();

                return response()->json(['message' => 'Movimentação com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Internal server error.'], 500);
        }
    }
}
