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
    /**
     * Validate data posted
     */
    protected function validateAccount($type, $request, $id = null)
    {
        switch ($type) {
            case 'store':
                return Validator::make(
                    $request->all(),
                    [
                        'name' => [
                            'required',
                            'string',
                            'max:191',
                            Rule::unique('accounts')->where(function ($query) {
                                $query->where('user_id', auth()->user()->id);
                            })
                        ],
                        'type' => [
                            'required',
                            Rule::in(['Ativo', 'Passivo', 'Patimônio Líquido', 'Receita', 'Despesa']),
                        ],
                        'category_id' => [
                            'required',
                            'integer',
                            Rule::exists('categories', 'id')->where(function ($query) {
                                $query->where('user_id', auth()->user()->id);
                            }),
                        ]
                    ]
                );
                break;
            case 'update':
                return Validator::make(
                    $request->all(),
                    [
                        'name' => [
                            'required',
                            'string',
                            'max:191',
                            Rule::unique('accounts')->where(function ($query) {
                                $query->where('user_id', auth()->user()->id);
                            })->ignore($id)
                        ],
                        'category_id' => [
                            'required',
                            'integer',
                            Rule::exists('categories', 'id')->where(function ($query) {
                                $query->where('user_id', auth()->user()->id);
                            }),
                        ]
                    ]
                );
                break;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AccountResource::collection(Account::where('user_id', auth()->user()->id)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateAccount('store', $request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'type', 'category_id']);
        $data['user_id'] = auth()->user()->id;
        $account = Account::create($data);

        return response()->json([$account], 201);
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

        $account = new AccountResource(
            Account::where(
                [
                    ['id', '=', $id],
                    ['user_id', '=', auth()->user()->id],
                ]
            )->first()
        );

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

        $validator = $this->validateAccount('update', $request, $id);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'category_id']);
        $account = Account::where(
            [
                ['id', '=', $id],
                ['user_id', '=', auth()->user()->id],
            ]
        )->first();

        if ($account) {
            $account->update($data);

            return response()->json([$account], 200);
        } else {
            return response()->json(['message' => 'Conta com ID ' . $id . ' não encontrada.'], 404);
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

        $account = Account::where(
            [
                ['id', '=', $id],
                ['user_id', '=', auth()->user()->id],
            ]
        )->first();

        if ($account) {
            if (($account->trasactionAccountSource->count()) || ($account->trasactionAccountDestination->count())) {
                return response()->json(['message' => 'Existem movimentações relacionadas a conta.'], 400);
            }

            $account->delete();

            return response()->json(['message' => 'Conta removida.'], 204);
        } else {
            return response()->json(['message' => 'Categoria com ID ' . $id . ' não encontrada.'], 404);
        }
    }
}
