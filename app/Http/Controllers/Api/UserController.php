<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Validate data posted
     */
    protected function validateUser($request, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:191',
                'email' => [
                    'required',
                    'email',
                    'max:191',
                    Rule::unique('users')->ignore($id)
                ],
                'password' => 'required|string|min:6|confirmed',
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
        // Adicionar política
        return UserResource::collection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Adicionar política

        // Recuperar o papel do usuário
        $validator = $this->validateUser($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        try {
            $user = User::create($data);

            // Adicionar relacionamento Role-User

            DB::commit();

            return response()->json([$user], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Internal server error.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Adicionar politica

        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        $user = new UserResource(User::find($id));

        if ($user->resource) {
            return response()->json([$user], 200);
        } else {
            return response()->json(['message' => 'Usuário com ID ' . $id . ' não encontrado.'], 404);
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
        // Adicionar politica

        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        // Recuperar o papel do usuário
        $validator = $this->validateUser($request, $id);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        DB::beginTransaction();

        try {
            $user = User::find($id);

            if ($user) {
                $user->update($data);

                // Adicionar relacionamento Role-User

                DB::commit();

                return response()->json([$user], 200);
            } else {
                DB::rollBack();

                return response()->json(['message' => 'Usuário com ID ' . $id . ' não encontrado.'], 404);
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
        // Adicionar politica

        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        try {
            $user = User::find($id);

            if ($user) {
                $user->delete();

                return response()->json(['message' => 'Usuário removido.'], 204);
            } else {
                return response()->json(['message' => 'Usuário com ID ' . $id . ' não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error.'], 500);
        }
    }
}
