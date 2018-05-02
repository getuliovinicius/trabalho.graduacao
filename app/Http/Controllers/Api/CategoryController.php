<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $user_id;

    /**
     * Validate data posted
     */
    protected function validateCategory($request, $id = null)
    {
        // user_id nunca pode ser passado.
        $this->user_id = $request->user_id;

        return Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:191',
                    Rule::unique('categories')->where(function ($query) {
                        $query->where('user_id', $this->user_id);
                    })->ignore($id)
                ],
                // user_id nunca pode ser passado.
                'user_id' => 'required|integer|exists:users,id',
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
        try {
            // Adicionar where com user_id autenticado
            $list = CategoryResource::collection(Category::paginate());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
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
        $validator = $this->validateCategory($request);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        // Não pode passar o user_id
        $data = $request->only(['name', 'user_id']);

        try {
            $category = Category::create($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }

        return response()->json([$category], 201);
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
            $category = new CategoryResource(Category::find($id));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }

        if ($category->resource) {
            return response()->json([$category], 200);
        } else {
            return response()->json(['message' => 'Categoria com ID ' . $id . ' não encontrada.'], 404);
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

        $validator = $this->validateCategory($request, $id);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 400);
        }

        // Não pode passar o user_id
        $data = $request->only(['name', 'user_id']);

        try {
            // Adicionar where com user_id autenticado
            $category = Category::find($id);

            if ($category) {
                $category->update($data);

                return response()->json([$category], 200);
            } else {
                return response()->json(['message' => 'Categoria com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
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

        try {
            // Adicionar where com user_id autenticado
            $category = Category::find($id);

            if ($category) {
                if ($category->accounts->count()) {
                    return response()->json(['message' => 'Existem contas relacionadas a essa categoria.'], 400);
                }

                $category->delete();

                return response()->json(['message' => 'Categoria removida.'], 204);
            } else {
                return response()->json(['message' => 'Categoria com ID ' . $id . ' não encontrada.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
