<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Validate data posted
     */
    protected function validateCategory($request, $id = null)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:191',
                    Rule::unique('categories')->where(function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    })->ignore($id)
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
        return CategoryResource::collection(Category::where('user_id', auth()->user()->id)->paginate());
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

        $data = $request->only(['name']);
        $data['user_id'] = auth()->user()->id;
        $category = Category::create($data);

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

        $category = new CategoryResource(
            Category::where(
                [
                    ['id', '=', $id],
                    ['user_id', '=', auth()->user()->id],
                ]
            )->first()
        );

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

        $data = $request->only(['name']);
        $category = Category::where(
            [
                ['id', '=', $id],
                ['user_id', '=', auth()->user()->id],
            ]
        )->first();

        if ($category) {
            $category->update($data);

            return response()->json([$category], 200);
        } else {
            return response()->json(['message' => 'Categoria com ID ' . $id . ' não encontrada.'], 404);
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

        $category = Category::where(
            [
                ['id', '=', $id],
                ['user_id', '=', auth()->user()->id],
            ]
        )->first();

        if ($category) {
            if ($category->accounts->count()) {
                return response()->json(['message' => 'Existem contas relacionadas a essa categoria.'], 400);
            }

            $category->delete();

            return response()->json(['message' => 'Categoria removida.'], 204);
        } else {
            return response()->json(['message' => 'Categoria com ID ' . $id . ' não encontrada.'], 404);
        }
    }
}
