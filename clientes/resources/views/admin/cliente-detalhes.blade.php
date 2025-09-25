@extends('layout')

@section('title', 'Detalhes do Cliente')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="mb-0">
            <i class="fa-solid fa-user me-2"></i>Detalhes do Cliente
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.cliente.edit', $cliente->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-edit me-1"></i>Editar
            </a>
            <a href="{{ route('admin.clientes') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-info-circle me-2"></i>Informações Pessoais
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">ID</label>
                            <p class="h6"><span class="badge bg-primary">#{{ $cliente->id }}</span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nome Completo</label>
                            <p class="h5 text-dark">{{ $cliente->nome }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">E-mail</label>
                            <p class="h6">
                                <a href="mailto:{{ $cliente->email }}" class="text-decoration-none">
                                    <i class="fa-solid fa-envelope me-1"></i>{{ $cliente->email }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Telefone</label>
                            <p class="h6">
                                <a href="tel:{{ $cliente->telefone }}" class="text-decoration-none">
                                    <i class="fa-solid fa-phone me-1"></i>{{ $cliente->telefone }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Idade</label>
                            <p class="h6">
                                <i class="fa-solid fa-birthday-cake me-1"></i>{{ $cliente->idade }} anos
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Newsletter</label>
                            <p class="h6">
                                @if($cliente->newsletter)
                                    <span class="badge bg-success">
                                        <i class="fa-solid fa-check me-1"></i>Inscrito
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fa-solid fa-times me-1"></i>Não inscrito
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Estilos Musicais</label>
                        <p>
                            @if($cliente->estilos)
                                @php
                                    $estilosArray = explode(',', $cliente->estilos);
                                @endphp
                                @foreach($estilosArray as $estilo)
                                    <span class="badge bg-secondary me-1 mb-1">
                                        <i class="fa-solid fa-music me-1"></i>{{ trim($estilo) }}
                                    </span>
                                @endforeach
                            @else
                                <em class="text-muted">Nenhum estilo informado</em>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fa-solid fa-clock me-2"></i>Informações do Sistema
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Cadastrado em</label>
                        <p class="h6">
                            <i class="fa-solid fa-calendar-plus me-1"></i>
                            {{ date('d/m/Y', strtotime($cliente->created_at)) }}
                        </p>
                        <small class="text-muted">
                            às {{ date('H:i', strtotime($cliente->created_at)) }}
                        </small>
                    </div>

                    @if($cliente->created_at != $cliente->updated_at)
                    <div class="mb-3">
                        <label class="text-muted small">Última atualização</label>
                        <p class="h6">
                            <i class="fa-solid fa-calendar-check me-1"></i>
                            {{ date('d/m/Y', strtotime($cliente->updated_at)) }}
                        </p>
                        <small class="text-muted">
                            às {{ date('H:i', strtotime($cliente->updated_at)) }}
                        </small>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fa-solid fa-cogs me-2"></i>Ações
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.cliente.edit', $cliente->id) }}" 
                           class="btn btn-warning">
                            <i class="fa-solid fa-edit me-1"></i>Editar Cliente
                        </a>
                        <button type="button" 
                                class="btn btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="fa-solid fa-trash me-1"></i>Excluir Cliente
                        </button>
                        <!-- <a href="mailto:{{ $cliente->email }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-envelope me-1"></i>Enviar E-mail
                        </a>
                        <a href="tel:{{ $cliente->telefone }}" class="btn btn-outline-success">
                            <i class="fa-solid fa-phone me-1"></i>Ligar
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fa-solid fa-exclamation-triangle me-2"></i>
                    <strong>Atenção!</strong> Esta ação não pode ser desfeita.
                </div>
                <p>Tem certeza que deseja excluir o cliente:</p>
                <div class="card bg-light">
                    <div class="card-body">
                        <strong>{{ $cliente->nome }}</strong><br>
                        <small class="text-muted">{{ $cliente->email }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-times me-1"></i>Cancelar
                </button>
                <form method="POST" action="{{ route('admin.cliente.destroy', $cliente->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-1"></i>Confirmar Exclusão
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection