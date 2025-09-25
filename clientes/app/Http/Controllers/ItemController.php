<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ItemController extends Controller
{
    // Listar todos os itens
    public function index()
    {
        $itens = DB::select('SELECT * FROM itens ORDER BY id DESC');
        return view('itens.index', compact('itens'));
    }


    // Exibir formulário de criação
    public function create()
    {
        return view('itens.create');
    }


    // Salvar novo item
    public function store(Request $request)
    {
        // Validação simples
        $request->validate([
            'nome' => 'required|max:100',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0'
        ]);


        DB::insert('INSERT INTO itens (nome, descricao, preco, quantidade) VALUES (?, ?, ?, ?)', [
            $request->nome,
            $request->descricao,
            $request->preco,
            $request->quantidade
        ]);


        return redirect()->route('itens.index')
                        ->with('success', 'Item criado com sucesso!');
    }


    // Exibir um item específico
    public function show($id)
    {
        $item = DB::select('SELECT * FROM itens WHERE id = ?', [$id]);
       
        if (empty($item)) {
            abort(404);
        }


        return view('itens.show', ['item' => $item[0]]);
    }


    // Exibir formulário de edição
    public function edit($id)
    {
        $item = DB::select('SELECT * FROM itens WHERE id = ?', [$id]);
       
        if (empty($item)) {
            abort(404);
        }


        return view('itens.edit', ['item' => $item[0]]);
    }


    // Atualizar item
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0'
        ]);


        $affected = DB::update('UPDATE itens SET nome = ?, descricao = ?, preco = ?, quantidade = ? WHERE id = ?', [
            $request->nome,
            $request->descricao,
            $request->preco,
            $request->quantidade,
            $id
        ]);


        if ($affected === 0) {
            abort(404);
        }


        return redirect()->route('itens.index')
                        ->with('success', 'Item atualizado com sucesso!');
    }


    // Excluir item
    public function destroy($id)
    {
        $affected = DB::delete('DELETE FROM itens WHERE id = ?', [$id]);


        if ($affected === 0) {
            abort(404);
        }


        return redirect()->route('itens.index')
                        ->with('success', 'Item excluído com sucesso!');
    }
}
