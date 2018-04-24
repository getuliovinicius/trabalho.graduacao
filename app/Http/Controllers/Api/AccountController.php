<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Models\Account;

class AccountController extends Controller
{
    protected $user_id;

    /**
     * Validate data posted
     */
    protected function validateAccount($request, $id = null)
    {
        // user_id nunca pode ser passado.
        $this->user_id = $request->user_id;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:191',
                    Rule::unique('accounts')->where(function ($query) {
                        $query->where('user_id', $this->user_id);
                    })->ignore($id)
                ],
                'type' => [
                    'required',
                    Rule::in(['Ativo', 'Passivo', 'Patimônio Líquido', 'Receita', 'Despesa']),
                ],
                'balance' => 'numeric',
                // user_id nunca pode ser passado.
                'user_id' => 'required|integer|exists:users,id',
                'category_id' => [
                    'required',
                    'integer',
                    Rule::exists('categories', 'id')->where(function ($query) {
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
        {
            try {
                // Adicionar where com user_id autenticado
                $list = AccountResource::collection(Account::paginate());
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erro no servidor.'], 500);
            }

            return $list;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateAccount($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        // Não pode passar o user_id
        $data = $request->only(['name', 'type', 'user_id', 'category_id']);
        $data['balance'] = ($request->input('balance')) ? $request->input('balance') : 0;

        try {
            $account = Account::create($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        return response()->json(['data' => $account], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        try {
            // Adicionar where com user_id autenticado
            $account = new AccountResource(Account::find($id));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        if ($account->resource) {
            return response()->json([$account], 200);
        } else {
            return response()->json(['message' => 'Conta com ID ' . $id . ' não encontrada.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        $validator = $this->validateAccount($request, $id);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        // Não pode passar o user_id
        $data = $request->only(['name', 'type', 'user_id', 'category_id']);
        $data['balance'] = ($request->input('balance')) ? $request->input('balance') : 0;

        try {
            // Adicionar where com user_id autenticado
            $account = Account::find($id);

            if ($account) {
                $account->update($data);

                return response()->json(['data' => $account], 200);
            } else {
                return response()->json(['message' => 'Conta com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
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

        try {
            // Adicionar where com user_id autenticado
            $account = Account::find($id);

            if ($account) {
                if (($account->trasactionAccountSource->count()) || ($account->trasactionAccountDestination->count())) {
                    return response()->json(['message' => 'Existem movimentações relacionadas a conta.'], 400);
                }

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
