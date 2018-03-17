<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\Veiculo;

class VeiculoController extends Controller
{
	/**
	 * Validate data posted
	 */
	protected function validateVeiculo($request) {
		$validator = Validator::make($request->all(),
			[
				'marca' => 'required',
				'modelo' => 'required',
				'ano' => 'required|numeric|min:0',
				'preco' => 'required|numeric|min:0'
			]
		);

		return $validator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		try {
			$qtd = $request['qtd'];
			$page = $request['page'];

			Paginator::currentPageResolver(
				function () use ($page) {
					return $page;
				}
			);

			$veiculos = Veiculo::paginate($qtd);

			$veiculos = $veiculos->appends(Request::capture()->except('page'));

			return response()->json(['veiculos' => $veiculos], 200);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Erro no servidor.'], 500);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// public function create()
	// {
	//     //
	// }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		try {
			$validator = $this->validateVeiculo($request);

			if ($validator->fails()) {
				return response()->json(['message' => 'Erro', 'errors' => $validator->errors()], 400);
			}

			$data = $request->only(['marca', 'modelo', 'ano', 'preco']);

			if ($data) {
				$veiculo = Veiculo::create($data);

				if ($veiculo) {
					return response()->json(['data' => $veiculo], 201);
				} else {
					return response()->json(['message' => 'Erro ao criar veículo.'], 400);
				}
			} else {
				return response()->json(['message' => 'Dados inválidos.'], 400);
			}
		} catch (\Exception $e) {
			return response()->json(['message' => 'Erro no servidor.'], 500);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		try {
			if ($id < 0) {
				return response()->json(['message' => 'Erro: ID menor que zero.'], 400);
			}

			$veiculo = Veiculo::find($id);

			if ($veiculo) {
				return response()->json([$veiculo], 200);
			} else {
				return response()->json(['message' => 'Veículo com ID ' . $id . ' não encontrado.'], 404);
			}
		} catch (\Exception $e) {
			return response()->json(['message' => 'Erro no servidor.'], 500);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	// public function edit($id)
	// {
	//     //
	// }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		try {
			$validator = $this->validateVeiculo($request);

			if ($validator->fails()) {
				return response()->json(['message' => 'Erro.', 'errors' => $validator->errors()], 400);
			}

			$data = $request->only(['marca', 'modelo', 'ano', 'preco']);

			if ($data) {
				$veiculo = Veiculo::find($id);

				if ($veiculo) {
					$veiculo->update($data); // e se não funcionar? Erro 500?

					return response()->json(['data' => $veiculo], 200);
				} else {
					return response()->json(['message' => 'Veículo com ID ' . $id . ' não encontrado.'], 404);
				}
			} else {
				return response()->json(['message' => 'Dados inválidos.'], 400);
			}
		} catch (\Exception $e) {
			return response()->json(['message' => 'Erro no servidor.'], 500);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			if ($id < 0) {
				return response()->json(['message' => 'Erro: ID menor que zero.'], 400);
			}

			$veiculo = Veiculo::find($id);

			if ($veiculo) {
				$veiculo->delete();

				return response()->json([], 204);
			} else {
				return response()->json(['message' => 'Veículo com ID ' . $id . ' não encontrado.'], 404);
			}
		} catch (\Exception $e) {
			return response()->json(['message' => 'Erro no servidor.'], 500);
		}
	}
}
