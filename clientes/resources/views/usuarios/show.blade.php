<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Detalhes do Usuário</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ route('usuarios.index') }}">
      <i class="fas fa-users"></i> Sistema de Usuários
    </a>
  </div>
</nav>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h4 class="mb-0"><i class="fas fa-user"></i> Detalhes do Usuário</h4>
          <a href="{{ route('usuarios.index') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Voltar
          </a>
        </div>
        <div class="card-body">
          
          <div class="row">
            <!-- Foto de Perfil -->
            <div class="col-md-4 text-center mb-4">
              @if($usuario->foto)
                <img src="{{ asset('storage/' . $usuario->foto) }}" 
                     class="rounded-circle img-fluid shadow" 
                     style="max-width: 200px; max-height: 200px; object-fit: cover;"
                     alt="Foto de {{ $usuario->nome }}">
              @else
                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto shadow" 
                     style="width: 200px; height: 200px;">
                  <i class="fas fa-user fa-5x text-white"></i>
                </div>
              @endif
              
              <h5 class="mt-3 mb-0">{{ $usuario->nome }}</h5>
              <p class="text-muted">{{ $usuario->email }}</p>
            </div>

            <!-- Informações -->
            <div class="col-md-8">
              <div class="row">
                <div class="col-12 mb-4">
                  <h6 class="text-primary border-bottom pb-2">
                    <i class="fas fa-info-circle"></i> Informações Básicas
                  </h6>
                  
                  <table class="table table-borderless">
                    <tr>
                      <td width="120"><strong>Nome:</strong></td>
                      <td>{{ $usuario->nome }}</td>
                    </tr>
                    <tr>
                      <td><strong>Email:</strong></td>
                      <td>{{ $usuario->email }}</td>
                    </tr>
                    <tr>
                      <td><strong>País:</strong></td>
                      <td><span class="badge bg-info">{{ $usuario->pais }}</span></td>
                    </tr>
                    <tr>
                      <td><strong>Cadastrado:</strong></td>
                      <td>{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y \à\s H:i') }}</td>
                    </tr>
                    @if($usuario->updated_at != $usuario->created_at)
                    <tr>
                      <td><strong>Atualizado:</strong></td>
                      <td>{{ \Carbon\Carbon::parse($usuario->updated_at)->format('d/m/Y \à\s H:i') }}</td>
                    </tr>
                    @endif
                  </table>
                </div>

                <!-- Interesses -->
                <div class="col-12 mb-4">
                  <h6 class="text-primary border-bottom pb-2">
                    <i class="fas fa-heart"></i> Interesses
                  </h6>
                  @if(!empty($usuario->interesses_array))
                    <div class="d-flex flex-wrap gap-2">
                      @foreach($usuario->interesses_array as $interesse)
                        <span class="badge bg-success fs-6">
                          <i class="fas fa-tag"></i> {{ $interesse }}
                        </span>
                      @endforeach
                    </div>
                  @else
                    <p class="text-muted mb-0">
                      <i class="fas fa-minus-circle"></i> Nenhum interesse cadastrado
                    </p>
                  @endif
                </div>

                <!-- Comentários -->
                @if($usuario->comentarios)
                <div class="col-12 mb-4">
                  <h6 class="text-primary border-bottom pb-2">
                    <i class="fas fa-comment"></i> Comentários
                  </h6>
                  <div class="bg-light p-3 rounded">
                    <p class="mb-0">{{ $usuario->comentarios }}</p>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Ações -->
          <hr>
          <div class="d-flex justify-content-between">
            <div>
              <small class="text-muted">
                <i class="fas fa-key"></i> ID: {{ $usuario->id }}
              </small>
            </div>
            <div>
              <a href="{{ route('usuarios.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-list"></i> Listar Todos
              </a>
              <button type="button" 
                      class="btn btn-danger"
                      onclick="confirmarExclusao({{ $usuario->id }}, '{{ $usuario->nome }}')">
                <i class="fas fa-trash"></i> Excluir Usuário
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="modalExcluir" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle"></i> Confirmar Exclusão
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="text-center mb-3">
          @if($usuario->foto)
            <img src="{{ asset('storage/' . $usuario->foto) }}" 
                 class="rounded-circle" 
                 width="80" 
                 height="80" 
                 style="object-fit: cover;"
                 alt="Foto de {{ $usuario->nome }}">
          @else
            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto" 
                 style="width: 80px; height: 80px;">
              <i class="fas fa-user fa-2x text-white"></i>
            </div>
          @endif
        </div>
        <p class="text-center">Tem certeza que deseja excluir o usuário <strong>{{ $usuario->nome }}</strong>?</p>
        <div class="alert alert-warning">
          <i class="fas fa-exclamation-triangle"></i> 
          <strong>Atenção:</strong> Esta ação não pode ser desfeita e todos os dados do usuário serão perdidos permanentemente.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> Sim, Excluir
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function confirmarExclusao(id, nome) {
    const modal = new bootstrap.Modal(document.getElementById('modalExcluir'));
    modal.show();
  }
</script>
</body>
</html>