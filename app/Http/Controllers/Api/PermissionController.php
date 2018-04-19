<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Validate data posted
     */
    protected function validatePermission($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:191',
                'description' => 'required|max:191',
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
            return PermissionResource::collection(Permission::paginate());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
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
        $validator = $this->validatePermission($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'description']);

        if ($data) {
            try {
                $permission = Permission::create($data);

                if ($permission) {
                    return response()->json(['data' => $permission], 201);
                } else {
                    return response()->json(['message' => 'Erro ao criar permissao.'], 400);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erro no servidor.'], 500);
            }
        } else {
            return response()->json(['message' => 'Dados inválidos.'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $permission = new PermissionResource(Permission::find($id));

            if ($permission->resource) {
                return response()->json([$permission], 200);
            } else {
                return response()->json(['message' => 'Permissão com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro no servidor.'], 500);
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
        $validator = $this->validatePermission($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
        }

        $data = $request->only(['name', 'description']);

        if ($data) {
            $permission = Permission::find($id);

            if ($permission) {
                try {
                    $permission->update($data);

                    return response()->json(['data' => $permission], 200);
                } catch (\Exception $e) {
                    return response()->json(['message' => 'Erro no servidor.'], 500);
                }
            } else {
                return response()->json(['message' => 'Permissão com ID ' . $id . ' não encontrada.'], 404);
            }
        } else {
            return response()->json(['message' => 'Dados inválidos.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
