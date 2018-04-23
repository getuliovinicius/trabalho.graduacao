<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Validate data posted
     */
    protected function validatePermission($request, $id = null)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:191',
                    Rule::unique('permissions')->ignore($id)
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
            $list = PermissionResource::collection(Permission::paginate());
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
        $validator = $this->validatePermission($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'description']);

        try {
            $permission = Permission::create($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        return response()->json(['data' => $permission], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_numeric($id) || $id < 1) {
            return response()->json(['message' => 'ID inválida.'], 400);
        }

        try {
            $permission = new PermissionResource(Permission::find($id));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }

        if ($permission->resource) {
            return response()->json([$permission], 200);
        } else {
            return response()->json(['message' => 'Permissão com ID ' . $id . ' não encontrada.'], 404);
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

        $validator = $this->validatePermission($request, $id);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'description']);

        try {
            $permission = Permission::find($id);

            if ($permission) {
                $permission->update($data);

                return response()->json(['data' => $permission], 200);
            } else {
                return response()->json(['message' => 'Permissão com ID ' . $id . ' não encontrada.'], 404);
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
            $permission = Permission::find($id);

            if ($permission) {
                $permission->delete();

                return response()->json(['message' => 'Permissão removida.'], 204);
            } else {
                return response()->json(['message' => 'Permissão com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
        }
    }
}
