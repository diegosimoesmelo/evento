@extends('layout')

@section('title', 'Cadastro Administrativo')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%; border-radius: 12px;">
        <h2 class="text-center mb-4">Cadastro Administrativo</h2>

        @if(session('error')) 
            <div class="alert alert-danger">{{ session('error') }}</div> 
        @endif
        @if(session('success')) 
            <div class="alert alert-success">{{ session('success') }}</div> 
        @endif

        <form method="POST" action="{{ route('admin.register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') 
                    <small class="text-danger">{{ $message }}</small> 
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') 
                    <small class="text-danger">{{ $message }}</small> 
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') 
                    <small class="text-danger">{{ $message }}</small> 
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Confirmar Senha</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="is_superadmin" id="is_superadmin" value="1" {{ old('is_superadmin') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_superadmin">
                    Superadmin
                </label>
            </div>
            
            <button class="btn btn-success w-100 mb-3">Cadastrar</button>
            
            <div class="text-center">
                <a href="{{ route('admin.login.form') }}" class="btn btn-outline-primary">
                    Já tem conta? Faça login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection