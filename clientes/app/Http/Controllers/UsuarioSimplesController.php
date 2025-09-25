<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UsuarioSimplesController extends Controller
{

    //  paises do banco 
    public function create()
{
    // SQL direto na base world (tabela Country)
    $rows = DB::select("SELECT Code, Name FROM Country ORDER BY Name");

    // Transformamos em array associativo [Code => Name]
    $paises = [];
    foreach ($rows as $row) {
        $paises[$row->Code] = $row->Name;
    }

    return view('cadastro', compact('paises'));
}

    public function store(Request $request)
    {
        // 1) Validação
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'senha' => ['required', 'string', 'min:8', 'confirmed'], // usa senha_confirmation
            //'pais' => ['required', 'in:Brasil,Portugal,Outro'],
          'pais' => ['required', function ($attribute, $value, $fail) {
    $exists = DB::table('Country')->where('Code', $value)->exists();
    if (! $exists) {
        $fail('O país selecionado é inválido.');
    }
}],
            'interesses' => ['array'],
            'interesses.*' => ['in:Tecnologia,Design'],
            'foto' => ['nullable', 'image', 'max:2048'], // até ~2MB
            'comentarios' => ['nullable', 'string'],
        ]);

        // 2) Tratar campos
        $senhaHash = Hash::make($dados['senha']);

        // interesses como JSON (ou null)
        $interessesJson = isset($dados['interesses']) ? json_encode(array_values($dados['interesses'])) : null;

        // upload da foto (salva em storage/app/public/fotos)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // cria link simbólico se não existir: php artisan storage:link
            $fotoPath = $request->file('foto')->store('fotos', 'public');
        }

        // 3) INSERT com SQL puro e bind de parâmetros (seguro contra SQL injection)
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, pais, interesses, foto_path, comentarios, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        try {
            DB::insert($sql, [
                $dados['nome'],
                $dados['email'],
                $senhaHash,
                $dados['pais'],
                $interessesJson,
                $fotoPath,
                $dados['comentarios'] ?? null,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Exemplo: email duplicado (constraint UNIQUE)
            return back()
                ->withErrors(['email' => 'Este e-mail já está cadastrado.'])
                ->withInput();
        }

        return redirect()->route('usuarios.create')->with('ok', 'Usuário cadastrado com sucesso!');
    }
}
