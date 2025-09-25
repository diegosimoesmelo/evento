<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    // Exibir formulário de criação
    public function create()
    {
        return view('usuarios.create');
    }

    // Processar criação do usuário
    public function store(Request $request)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'senha' => 'required|string|min:8|confirmed',
            'senha_confirmation' => 'required|string|min:8',
            'pais' => 'required|string|in:Brasil,Portugal,Outro',
            'interesses' => 'nullable|array',
            'interesses.*' => 'string|in:Tecnologia,Design,Marketing,Negócios',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048', // 2MB
            'comentarios' => 'nullable|string|max:1000'
        ], [
            // Mensagens personalizadas em português
            'nome.required' => 'O campo nome é obrigatório',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres',
            
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Digite um email válido',
            'email.unique' => 'Este email já está cadastrado no sistema',
            
            'senha.required' => 'O campo senha é obrigatório',
            'senha.min' => 'A senha deve ter pelo menos 8 caracteres',
            'senha.confirmed' => 'A confirmação de senha não confere',
            
            'senha_confirmation.required' => 'A confirmação de senha é obrigatória',
            'senha_confirmation.min' => 'A confirmação de senha deve ter pelo menos 8 caracteres',
            
            'pais.required' => 'Selecione um país',
            'pais.in' => 'País inválido selecionado',
            
            'interesses.array' => 'Interesses devem ser um array',
            'interesses.*.in' => 'Interesse inválido selecionado',
            
            'foto.image' => 'O arquivo deve ser uma imagem',
            'foto.mimes' => 'A foto deve ser nos formatos: JPEG, JPG, PNG ou GIF',
            'foto.max' => 'A foto deve ter no máximo 2MB',
            
            'comentarios.max' => 'Os comentários devem ter no máximo 1000 caracteres'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Processar upload da foto
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                
                // Gerar nome único para o arquivo
                $nomeArquivo = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                
                // Salvar na pasta public/uploads/usuarios
                $fotoPath = $foto->storeAs('uploads/usuarios', $nomeArquivo, 'public');
            }

            // Preparar array de interesses
            $interessesJson = null;
            if ($request->has('interesses') && is_array($request->interesses)) {
                $interessesJson = json_encode($request->interesses);
            }

            // Inserir usuário na tabela
            $userId = DB::table('usuarios')->insertGetId([
                'nome' => trim($request->nome),
                'email' => strtolower(trim($request->email)),
                'senha' => Hash::make($request->senha), // Hash da senha
                'pais' => $request->pais,
                'interesses' => $interessesJson,
                'foto' => $fotoPath,
                'comentarios' => $request->comentarios ? trim($request->comentarios) : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Log de sucesso
            \Log::info("Usuário cadastrado com sucesso", [
                'user_id' => $userId,
                'email' => $request->email,
                'nome' => $request->nome
            ]);

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuário cadastrado com sucesso! ID: ' . $userId);

        } catch (\Exception $e) {
            // Se houver erro, remover foto que foi enviada
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            // Log do erro
            \Log::error("Erro ao cadastrar usuário", [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'N/A'
            ]);

            return redirect()->back()
                ->with('error', 'Erro ao cadastrar usuário: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Listar usuários
    public function index()
    {
        $usuarios = DB::table('usuarios')
            ->select(['id', 'nome', 'email', 'pais', 'interesses', 'foto', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Decodificar interesses JSON para exibição
        foreach ($usuarios as $usuario) {
            if ($usuario->interesses) {
                $usuario->interesses_array = json_decode($usuario->interesses, true);
            } else {
                $usuario->interesses_array = [];
            }
        }

        return view('usuarios.index', compact('usuarios'));
    }

    // Exibir usuário específico
    public function show($id)
    {
        $usuario = DB::table('usuarios')->where('id', $id)->first();

        if (!$usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Usuário não encontrado');
        }

        // Decodificar interesses
        if ($usuario->interesses) {
            $usuario->interesses_array = json_decode($usuario->interesses, true);
        } else {
            $usuario->interesses_array = [];
        }

        return view('usuarios.show', compact('usuario'));
    }

    // Excluir usuário
    public function destroy($id)
    {
        try {
            $usuario = DB::table('usuarios')->where('id', $id)->first();

            if (!$usuario) {
                return redirect()->route('usuarios.index')
                    ->with('error', 'Usuário não encontrado');
            }

            // Remover foto se existir
            if ($usuario->foto && Storage::disk('public')->exists($usuario->foto)) {
                Storage::disk('public')->delete($usuario->foto);
            }

            // Excluir usuário
            DB::table('usuarios')->where('id', $id)->delete();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuário excluído com sucesso');

        } catch (\Exception $e) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Erro ao excluir usuário: ' . $e->getMessage());
        }
    }
}