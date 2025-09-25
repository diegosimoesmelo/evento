<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    public function create()
    {
        // Busca tipos direto via SQL
        $rows = DB::select("SELECT id, nome FROM tipos_produto ORDER BY nome");
        $tipos = [];
        foreach ($rows as $row) {
            $tipos[$row->id] = $row->nome;
        }

        return view('produtos.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'tipo_id' => ['required', 'integer'],
        ]);

        // Valida se o tipo existe
        $existe = DB::select("SELECT 1 FROM tipos_produto WHERE id = ? LIMIT 1", [$dados['tipo_id']]);
        if (! $existe) {
            return back()->withErrors(['tipo_id' => 'Tipo inválido'])->withInput();
        }

        // INSERT com SQL puro
        DB::insert(
            "INSERT INTO produtos (nome, tipo_id, created_at) VALUES (?, ?, NOW())",
            [$dados['nome'], $dados['tipo_id']]
        );

        return redirect()->route('produtos.create')->with('ok', 'Produto cadastrado com sucesso!');
    }
}
