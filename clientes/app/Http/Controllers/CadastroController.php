<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CadastroController extends Controller
{
    public function index()
    {
        return view('festa');
    }

    public function listarClientes(Request $request)
    {
        // Verificar se está logado
        if (!session('admin_user_id')) {
            return redirect()->route('admin.login.form');
        }

        $q = $request->get('q');
        
        if ($q) {
            // Buscar com filtro na tabela cadastros
            $clientes = DB::select("
                SELECT id, nome, email, telefone, idade, estilos, newsletter, created_at, updated_at 
                FROM cadastros 
                WHERE nome LIKE ? OR email LIKE ? 
                ORDER BY created_at DESC
            ", [
                '%' . $q . '%',
                '%' . $q . '%'
            ]);
        } else {
            // Buscar todos os registros da tabela cadastros
            $clientes = DB::select("
                SELECT id, nome, email, telefone, idade, estilos, newsletter, created_at, updated_at 
                FROM cadastros 
                ORDER BY created_at DESC
            ");
        }

        // Converter objetos para array para facilitar manipulação na view
        $clientes = array_map(function($cliente) {
            return (object) [
                'id' => $cliente->id,
                'nome' => $cliente->nome,
                'email' => $cliente->email,
                'telefone' => $cliente->telefone,
                'idade' => $cliente->idade,
                'estilos' => $cliente->estilos,
                'newsletter' => (bool) $cliente->newsletter,
                'created_at' => $cliente->created_at,
                'updated_at' => $cliente->updated_at
            ];
        }, $clientes);
    
        // Retornar para a view
        return view('admin.clientes', compact('clientes', 'q'));
    }

    public function store(Request $request)
    {
        // Pega os estilos musicais (checkbox)
        $estilos = $request->input('estilos') ? implode(',', $request->input('estilos')) : null;


        // SQL puro
        DB::insert(
            "INSERT INTO cadastros (nome, email, telefone, idade, estilos, newsletter, created_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())",
            [
                $request->input('nome'),
                $request->input('email'),
                $request->input('telefone'),
                $request->input('idade'),
                $estilos,
                $request->has('newsletter') ? 1 : 0,
            ]
        );


        return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
    }

      // Ver detalhes do cliente
    public function show($id)
    {
        // Verificar se está logado
        if (!session('admin_user_id')) {
            return redirect()->route('admin.login.form');
        }

        // Buscar cliente por ID
        $cliente = DB::select("SELECT * FROM cadastros WHERE id = ? LIMIT 1", [$id]);
        
        if (count($cliente) === 0) {
            return redirect()->route('admin.clientes')->with('error', 'Cliente não encontrado!');
        }

        $cliente = (object) [
            'id' => $cliente[0]->id,
            'nome' => $cliente[0]->nome,
            'email' => $cliente[0]->email,
            'telefone' => $cliente[0]->telefone,
            'idade' => $cliente[0]->idade,
            'estilos' => $cliente[0]->estilos,
            'newsletter' => (bool) $cliente[0]->newsletter,
            'created_at' => $cliente[0]->created_at,
            'updated_at' => $cliente[0]->updated_at
        ];

        return view('admin.cliente-detalhes', compact('cliente'));
    }

    // Mostrar formulário de edição
    public function edit($id)
    {
        // Verificar se está logado
        if (!session('admin_user_id')) {
            return redirect()->route('admin.login.form');
        }

        // Buscar cliente por ID
        $cliente = DB::select("SELECT * FROM cadastros WHERE id = ? LIMIT 1", [$id]);
        
        if (count($cliente) === 0) {
            return redirect()->route('admin.clientes')->with('error', 'Cliente não encontrado!');
        }

        $cliente = (object) [
            'id' => $cliente[0]->id,
            'nome' => $cliente[0]->nome,
            'email' => $cliente[0]->email,
            'telefone' => $cliente[0]->telefone,
            'idade' => $cliente[0]->idade,
            'estilos' => $cliente[0]->estilos,
            'newsletter' => (bool) $cliente[0]->newsletter,
            'created_at' => $cliente[0]->created_at,
            'updated_at' => $cliente[0]->updated_at
        ];

        return view('admin.cliente-editar', compact('cliente'));
    }

    // Atualizar cliente
    public function update(Request $request, $id)
    {
        // Verificar se está logado
        if (!session('admin_user_id')) {
            return redirect()->route('admin.login.form');
        }

        // Validação
        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telefone' => ['required', 'string', 'max:20'],
            'idade' => ['required','string', 'min:1', 'max:120'],
        ]);

        // Verificar se cliente existe
        $existing = DB::select("SELECT id FROM cadastros WHERE id = ? LIMIT 1", [$id]);
        if (count($existing) === 0) {
            return redirect()->route('admin.clientes')->with('error', 'Cliente não encontrado!');
        }

        // Verificar se email já existe em outro cliente
        $emailExists = DB::select("SELECT id FROM cadastros WHERE email = ? AND id != ? LIMIT 1", [$request->input('email'), $id]);
        if (count($emailExists) > 0) {
            return back()->withErrors(['email' => 'Este e-mail já está sendo usado por outro cliente'])->withInput();
        }

        $estilos = $request->input('estilos') ? implode(',', $request->input('estilos')) : null;

        // Atualizar cliente
        DB::update("UPDATE cadastros SET nome = ?, email = ?, telefone = ?, idade = ?, estilos = ?, newsletter = ?, updated_at = NOW() WHERE id = ?", [
            $request->input('nome'),
            $request->input('email'),
            $request->input('telefone'),
            $request->input('idade'),
            $estilos,
            $request->has('newsletter') ? 1 : 0,
            $id
        ]);

        return redirect()->route('admin.clientes')->with('success', 'Cliente atualizado com sucesso!');
    }

    // Excluir cliente
    public function destroy($id)
    {
        // Verificar se está logado
        if (!session('admin_user_id')) {
            return redirect()->route('admin.login.form');
        }

        // Verificar se cliente existe
        $existing = DB::select("SELECT id, nome FROM cadastros WHERE id = ? LIMIT 1", [$id]);
        if (count($existing) === 0) {
            return redirect()->route('admin.clientes')->with('error', 'Cliente não encontrado!');
        }

        $nomeCliente = $existing[0]->nome;

        // Excluir cliente
        DB::delete("DELETE FROM cadastros WHERE id = ?", [$id]);

        return redirect()->route('admin.clientes')->with('success', "Cliente '{$nomeCliente}' foi excluído com sucesso!");
    }

}