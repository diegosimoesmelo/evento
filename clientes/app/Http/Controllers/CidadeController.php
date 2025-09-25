<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CidadeController extends Controller
{
    public function create()
    {
        // SQL puro na base world.Country
        $rows = DB::select("SELECT Code, Name FROM Country ORDER BY Name");
        $paises = [];
        foreach ($rows as $r) {
            $paises[$r->Code] = $r->Name; // ["BRA"=>"Brazil", ...]
        }

        return view('cidades.create', compact('paises'));
    }

    public function store(Request $request)
    {
        // validação simples
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'country_code' => ['required', 'string', 'size:3'],
        ]);

        // valida país com SQL puro
        $exists = DB::select("SELECT 1 FROM Country WHERE Code = ? LIMIT 1", [$dados['country_code']]);
        if (! $exists) {
            return back()->withErrors(['country_code' => 'País inválido.'])->withInput();
        }

        // INSERT com SQL puro
        DB::insert(
            "INSERT INTO cidades (nome, country_code, created_at) VALUES (?, ?, NOW())",
            [$dados['nome'], $dados['country_code']]
        );

        return redirect()->route('cidades.create')->with('ok', 'Cidade cadastrada com sucesso!');
    }
}
