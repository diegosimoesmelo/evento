@extends('layout')

@section('title', 'Editar Cliente')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="mb-0">
            <i class="fa-solid fa-user-edit me-2"></i>Editar Cliente
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.cliente.show', $cliente->id) }}" class="btn btn-info">
                <i class="fa-solid fa-eye me-1"></i>Ver Detalhes
            </a>
            <a href="{{ route('admin.clientes') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </div>

    @if(session('success')) 
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
        </div> 
    @endif
    
    @if(session('error')) 
        <div class="alert alert-danger">
            <i class="fa-solid fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div> 
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-edit me-2"></i>Formulário de Edição
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cliente.update', $cliente->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" 
                                       value="{{ old('nome', $cliente->nome) }}" required>
                                @error('nome') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email', $cliente->email) }}" required>
                                @error('email') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" name="telefone" class="form-control" 
                                       value="{{ old('telefone', $cliente->telefone) }}" required>
                                @error('telefone') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Idade</label>
                                 <select class="form-select" id="idade" name="idade">
                                            <option value="">Selecione...</option>
                                            <option value="18-25" @selected(old('idade')==='18-25')>18-25 anos</option>
                                            <option value="26-35" @selected(old('idade')==='26-35')>26-35 anos</option>
                                            <option value="36-45" @selected(old('idade')==='36-45')>36-45 anos</option>
                                            <option value="46+"   @selected(old('idade')==='46+')>46+ anos</option>
                                        </select>
                                @error('idade') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="newsletter" 
                                           id="newsletter" value="1" 
                                           {{ old('newsletter', $cliente->newsletter) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="newsletter">
                                        <i class="fa-solid fa-envelope me-1"></i>Receber newsletter
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Estilos Musicais Favoritos</label>
                            @php
                                $estilosCliente = $cliente->estilos ? explode(',', $cliente->estilos) : [];
                                $estilosCliente = array_map('trim', $estilosCliente);
                                $todosEstilos = ['Rock', 'Pop', 'Eletrônica', 'MPB'];
                            @endphp
                            <div class="row">
                                @foreach($todosEstilos as $estilo)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="estilos[]" 
                                               value="{{ $estilo }}" id="estilo_{{ $loop->index }}"
                                               {{ in_array($estilo, old('estilos', $estilosCliente)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="estilo_{{ $loop->index }}">
                                            {{ $estilo }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-save me-1"></i>Salvar Alterações
                            </button>
                            <a href="{{ route('admin.cliente.show', $cliente->id) }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-times me-1"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fa-solid fa-info-circle me-2"></i>Informações Atuais
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">ID do Cliente</label>
                        <p><span class="badge bg-primary">#{{ $cliente->id }}</span></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-muted small">Cadastrado em</label>
                        <p class="small">
                            <i class="fa-solid fa-calendar me-1"></i>
                            {{ date('d/m/Y H:i', strtotime($cliente->created_at)) }}
                        </p>
                    </div>

                    @if($cliente->created_at != $cliente->updated_at)
                    <div class="mb-3">
                        <label class="text-muted small">Última atualização</label>
                        <p class="small">
                            <i class="fa-solid fa-calendar-check me-1"></i>
                            {{ date('d/m/Y H:i', strtotime($cliente->updated_at)) }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fa-solid fa-exclamation-triangle me-2"></i>Atenção
                    </h6>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        • Todos os campos são obrigatórios exceto estilos musicais e newsletter<br>
                        • O e-mail deve ser único no sistema<br>
                        • A idade deve estar entre 1 e 120 anos<br>
                        • As alterações serão salvas imediatamente
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection