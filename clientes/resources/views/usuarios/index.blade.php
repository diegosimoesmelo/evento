<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Lista de Usuários</title>
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
  <!-- Alerts -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h4 class="mb-0"><i class="fas fa-users"></i> Lista de Usuários</h4>
          <a href="{{ route('usuarios.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Novo Usuário
          </a>
        </div>
        <div class="card-body">
          @if(count($usuarios) > 0)
            <div class="row mb-3">
              <div class="col-md-6">
                <p class="text-muted mb-0">
                  <i class="fas fa-info-circle"></i> 
                  Total: {{ count($usuarios) }} usuário(s) cadastrado(s)
                </p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="table-dark">
                  <tr>
                    <th width="80">Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>País</th>
                    <th>Interesses</th>
                    <th>Cadastro</th>
                    <th width="120">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($usuarios as $usuario)
                  <tr>
                    <td>
                      @if($usuario->foto)
                        <img src="{{ asset('storage/' . $usuario->foto) }}" 
                             class="rounded-circle" 
                             width="50" 
                             height="50" 
                             style="object-fit: cover;"
                             alt="Foto de {{ $usuario->nome }}">
                      @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px;">
                          <i class="fas fa-user text-white"></i>
                        </div>
                      @endif
                    </td>
                    <td>
                      <strong>{{ $usuario->nome }}</strong>
                    </td>
                    <td>
                      <small class="text-muted">{{ $usuario->email }}</small>
                    </td>
                    <td>
                      <span class="badge bg-info">{{ $usuario->pais }}</span>
                    </td>
                    <td>
                      @if(!empty($usuario->interesses_array))
                        @foreach($usuario->interesses_array as $interesse)
                          <span class="badge bg-secondary me-1">{{ $interesse }}</span>
                        @endforeach
                      @else
                        <span class="text-muted">Nenhum</span>
                      @endif
                    </td>
                    <td>
                      <small class="text-muted">
                        {{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y H:i') }}
                      </small>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('usuarios.show', $usuario->id) }}" 
                           class="btn btn-sm btn-outline-info" 
                           title="Visualizar">
                          <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger" 
                                title="Excluir"
                                onclick="confirmarExclusao({{ $usuario->id }}, '{{ $usuario->nome }}')">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-5">
              <div class="mb-4">
                <i class="fas fa-users fa-4x text-muted"></i>
              </div>
              <h5 class="text-muted mb-3">Nenhum usuário cadastrado</h5>
              <p class="text-muted mb-4">
                Clique no botão abaixo para cadastrar o primeiro usuário do sistema.
              </p>
              <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus"></i> Cadastrar Primeiro Usuário
              </a>
            </div>
          @endif
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
        <p>Tem certeza que deseja excluir o usuário <strong id="nomeUsuario"></strong>?</p>
        <p class="text-danger"><small><i class="fas fa-warning"></i> Esta ação não pode ser desfeita!</small></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cancelar
        </button>
        <form id="formExcluir" method="POST" style="display: inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> Excluir
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function confirmarExclusao(id, nome) {
    document.getElementById('nomeUsuario').textContent = nome;
    document.getElementById('formExcluir').action = `/usuarios/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('modalExcluir'));
    modal.show();
  }

  // Auto-hide alerts após 5 segundos
  setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    });
  }, 5000);
</script>
</body>
</html>