@extends('layout')

@section('title', 'Novo Usuário Administrativo')

@section('content')
<div class="container mt-5" style="max-width: 640px;">
    <h1 class="mb-4">Novo Usuário Administrativo</h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Confirmar Senha</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="is_superadmin" id="is_superadmin" value="1">
            <label class="form-check-label" for="is_superadmin">Superadmin</label>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.clientes') }}" class="btn btn-outline-secondary">Voltar</a>
            <button class="btn btn-success">Criar Usuário</button>
        </div>
    </form>
</div>
@endsection



