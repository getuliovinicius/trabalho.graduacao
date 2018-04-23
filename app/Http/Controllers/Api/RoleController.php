<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Validate data posted
     */
    protected function validateRole($request, $id = null)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:191',
                    Rule::unique('roles')->ignore($id)
                ],
                'description' => 'required|string|max:191',
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
            $list = RoleResource::collection(Role::paginate());
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
        $validator = $this->validateRole($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'description']);

        try {
            $role = Role::create($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        return response()->json(['data' => $role], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        try {
            $role = new RoleResource(Role::find($id));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        if ($role->resource) {
            return response()->json([$role], 200);
        } else {
            return response()->json(['message' => 'Papel com ID ' . $id . ' não encontrado.'], 404);
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

        $validator = $this->validateRole($request, $id);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'description']);

        try {
            $role = Role::find($id);

            if ($role) {
                $role->update($data);

                return response()->json(['data' => $role], 200);
            } else {
                return response()->json(['message' => 'Papel com ID ' . $id . ' não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        $role = Role::find($id);

        if ($role) {
            try {
                $role->delete();

                return response()->json(['message' => 'Papel removido.'], 204);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erro no servidor.'], 500);
            }
        } else {
            return response()->json(['message' => 'Papel com ID ' . $id . ' não encontrado.'], 404);
        }
    }
}
