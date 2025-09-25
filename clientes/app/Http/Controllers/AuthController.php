<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        // busca usuário admin por email
        $rows = DB::select("SELECT id, name, email, password, is_superadmin FROM admin_users WHERE email = ? LIMIT 1", [
            $data['email']
        ]);

        if (count($rows) === 0) {
            return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
        }

        $user = $rows[0];

        if (!Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
        }

        session([
            'admin_user_id' => $user->id,
            'admin_user_name' => $user->name,
            'is_superadmin' => (bool)$user->is_superadmin,
        ]);

        return redirect()->route('admin.clientes');
    }

    public function logout()
    {
        session()->forget(['admin_user_id','admin_user_name','is_superadmin']);
        return redirect()->route('admin.login.form')->with('success', 'Você saiu da área administrativa.');
    }

    // Mostrar formulário de cadastro
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    // Processar cadastro de novo usuário admin
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Verificar se email já existe
        $existing = DB::select("SELECT id FROM admin_users WHERE email = ? LIMIT 1", [$data['email']]);
        
        if (count($existing) > 0) {
            return back()->withErrors(['email' => 'Este e-mail já está cadastrado'])->withInput();
        }

        // Inserir novo usuário
        DB::insert("INSERT INTO admin_users (name, email, password, is_superadmin, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())", [
            $data['name'],
            $data['email'],
            Hash::make($data['password']),
            $request->has('is_superadmin') ? 1 : 0
        ]);

        return redirect()->route('admin.login.form')->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
    }

    // Para criar usuários quando já logado (rota existente)
    public function showCreateUserForm()
    {
        // Verificar se está logado
        if (!session('admin_user_id')) {
            return redirect()->route('admin.login.form');
        }
        
        // Apenas superadmins podem criar usuários
        if (!session('is_superadmin')) {
            return redirect()->route('admin.clientes')->with('error', 'Acesso negado.');
        }

        return view('admin.users');
    }

    public function storeUser(Request $request)
    {
        // Verificar se está logado e é superadmin
        if (!session('admin_user_id') || !session('is_superadmin')) {
            return redirect()->route('admin.login.form');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Verificar se email já existe
        $existing = DB::select("SELECT id FROM admin_users WHERE email = ? LIMIT 1", [$data['email']]);
        
        if (count($existing) > 0) {
            return back()->withErrors(['email' => 'Este e-mail já está cadastrado'])->withInput();
        }

        // Inserir novo usuário
        DB::insert("INSERT INTO admin_users (name, email, password, is_superadmin, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())", [
            $data['name'],
            $data['email'],
            Hash::make($data['password']),
            $request->has('is_superadmin') ? 1 : 0
        ]);

        return redirect()->route('admin.clientes')->with('success', 'Usuário criado com sucesso!');
    }
}