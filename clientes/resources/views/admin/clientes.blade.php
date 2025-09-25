@extends('layout')

@section('title', 'Clientes Cadastrados')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="mb-0">Clientes Cadastrados</h1>
        <div class="d-flex gap-2">
            @if(session('is_superadmin'))
                <a class="btn btn-outline-primary" href="{{ route('admin.users.create') }}">
                    <i class="fa-solid fa-user-plus me-1"></i>Novo Usuário
                </a>
            @endif
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-outline-danger">
                    Sair ({{ session('admin_user_name') }})
                </button>
            </form>
        </div>
    </div>

    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') }}</div> 
    @endif
    
    @if(session('error')) 
        <div class="alert alert-danger">{{ session('error') }}</div> 
    @endif

    <form class="mb-3" method="GET" action="{{ route('admin.clientes') }}">
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Buscar por nome ou e-mail" value="{{ $q ?? '' }}">
            <button class="btn btn-secondary" type="submit">Buscar</button>
            @if($q)
                <a href="{{ route('admin.clientes') }}" class="btn btn-outline-secondary">Limpar</a>
            @endif
        </div>
    </form>

    @if(!empty($clientes) && count($clientes) > 0)
        <div class="alert alert-info mb-3">
            <strong>Total:</strong> {{ count($clientes) }} cliente(s) {{ $q ? 'encontrado(s)' : 'cadastrado(s)' }}
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Idade</th>
                        <th>Estilos</th>
                        <th>Newsletter</th>
                        <th>Data de Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $c)
                    <tr>
                        <td><span class="badge bg-primary">#{{ $c->id }}</span></td>
                        <td><strong>{{ $c->nome }}</strong></td>
                        <td>
                            <a href="mailto:{{ $c->email }}" class="text-decoration-none">
                                {{ $c->email }}
                            </a>
                        </td>
                        <td>
                            <a href="tel:{{ $c->telefone }}" class="text-decoration-none">
                                {{ $c->telefone }}
                            </a>
                        </td>
                        <td>{{ $c->idade }} anos</td>
                        <td>
                            @if($c->estilos)
                                @php
                                    $estilosArray = explode(',', $c->estilos);
                                @endphp
                                @foreach($estilosArray as $estilo)
                                    <span class="badge bg-secondary me-1">{{ trim($estilo) }}</span>
                                @endforeach
                            @else
                                <em class="text-muted">Não informado</em>
                            @endif
                        </td>
                        <td>
                            @if($c->newsletter)
                                <span class="badge bg-success">✓ Sim</span>
                            @else
                                <span class="badge bg-secondary">✗ Não</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ date('d/m/Y H:i', strtotime($c->created_at)) }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.cliente.show', $c->id) }}" 
                                   class="btn btn-info btn-sm" 
                                   title="Ver detalhes">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.cliente.edit', $c->id) }}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Editar">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        title="Excluir"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $c->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de confirmação de exclusão -->
                            <div class="modal fade" id="deleteModal{{ $c->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmar Exclusão</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza que deseja excluir o cliente:</p>
                                            <strong>{{ $c->nome }} ({{ $c->email }})</strong>
                                            <p class="text-muted mt-2">Esta ação não pode ser desfeita!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form method="POST" action="{{ route('admin.cliente.destroy', $c->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="fa-solid fa-users fa-3x mb-3 text-muted"></i>
            <h4>{{ $q ? 'Nenhum cliente encontrado' : 'Nenhum cliente cadastrado ainda' }}</h4>
            <p class="text-muted mb-0">
                {{ $q ? 'Tente buscar com outros termos.' : 'Os clientes aparecerão aqui quando se cadastrarem no sistema.' }}
            </p>
            @if($q)
                <a href="{{ route('admin.clientes') }}" class="btn btn-outline-primary mt-2">
                    Ver todos os clientes
                </a>
            @endif
        </div>
    @endif
</div>
@endsection