@extends('layout')

@section('title', 'Login Administrativo')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 420px; width: 100%; border-radius: 12px;">
        <h2 class="text-center mb-4">Login Administrativo</h2>

        @if(session('error')) 
            <div class="alert alert-danger">{{ session('error') }}</div> 
        @endif
        @if(session('success')) 
            <div class="alert alert-success">{{ session('success') }}</div> 
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
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
            <button class="btn btn-primary w-100 mb-3">Entrar</button>
            
            <div class="text-center">
                <a href="{{ route('admin.register.form') }}" class="btn btn-outline-success">
                    Criar nova conta
                </a>
            </div>
        </form>
    </div>
</div>
@endsection