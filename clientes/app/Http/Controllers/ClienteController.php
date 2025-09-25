<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    // Exibir formulário de criação
    public function create()
    {
          $estados = DB::table('estados')
            ->orderBy('nome', 'asc')
            ->get();

        return view('clientes.create', compact('estados'));
    }

    // Processar a criação do cliente
    public function store(Request $request)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes,email',
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|size:11|unique:clientes,cpf',
            'endereco' => 'nullable|string|max:500',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:10'
        ], [
            'nome.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Digite um email válido',
            'email.unique' => 'Este email já está cadastrado',
            'telefone.required' => 'O campo telefone é obrigatório',
            'cpf.required' => 'O campo CPF é obrigatório',
            'cpf.size' => 'O CPF deve ter 11 dígitos',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'estado.max' => 'O estado deve ter no máximo 2 caracteres'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Inserir dados na tabela usando Query Builder
            DB::table('clientes')->insert([
                'nome' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'cpf' => $request->cpf,
                'endereco' => $request->endereco,
                'cidade' => $request->cidade,
                'estado' => strtoupper($request->estado),
                'cep' => $request->cep,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente cadastrado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Listar todos os clientes (para onde redireciona após criar)
    public function index()
    {
        $clientes = DB::table('clientes')
            ->orderBy('nome', 'asc')
            ->get();

        return view('clientes.index', compact('clientes'));
    }
}