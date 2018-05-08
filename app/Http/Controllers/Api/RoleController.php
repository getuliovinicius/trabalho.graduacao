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
        return Validator::make(
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Adicionar Política

        return RoleResource::collection(Role::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Adicionar Política

        $validator = $this->validateRole($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'description']);

        $role = Role::create($data);

        return response()->json([$role], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Adicionar Política

        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        $role = new RoleResource(Role::find($id));

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
        // Adicionar Política

        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        $validator = $this->validateRole($request, $id);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'description']);

        $role = Role::find($id);

        if ($role) {
            $role->update($data);

            return response()->json([$role], 200);
        } else {
            return response()->json(['message' => 'Papel com ID ' . $id . ' não encontrado.'], 404);
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
        // Adicionar Política

        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        $role = Role::find($id);

        if ($role) {
            $role->delete();

            return response()->json(['message' => 'Papel removido.'], 204);
        } else {
            return response()->json(['message' => 'Papel com ID ' . $id . ' não encontrado.'], 404);
        }
    }
}
