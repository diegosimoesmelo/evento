<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('clientes.index') }}">
                <i class="fas fa-users"></i> Sistema de Clientes
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
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-users"></i> Lista de Clientes</h4>
                        <a href="{{ route('clientes.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Novo Cliente
                        </a>
                    </div>
                    <div class="card-body">
                        @if(count($clientes) > 0)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-info-circle"></i> 
                                        Total de {{ count($clientes) }} cliente(s) cadastrado(s)
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="25%">Nome</th>
                                            <th width="20%">Email</th>
                                            <th width="15%">Telefone</th>
                                            <th width="12%">CPF</th>
                                            <th width="18%">Cidade/Estado</th>
                                            <th width="10%" class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clientes as $cliente)
                                        <tr>
                                            <td>
                                                <strong>{{ $cliente->nome }}</strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $cliente->email }}</small>
                                            </td>
                                            <td>{{ $cliente->telefone }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $cliente->cpf }}</span>
                                            </td>
                                            <td>
                                                @if($cliente->cidade && $cliente->estado)
                                                    {{ $cliente->cidade }}/{{ $cliente->estado }}
                                                @elseif($cliente->cidade)
                                                    {{ $cliente->cidade }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-info" title="Visualizar" onclick="verDetalhes({{ json_encode($cliente) }})">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-warning" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="confirmarExclusao('{{ $cliente->nome }}')">
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
                                <h5 class="text-muted mb-3">Nenhum cliente cadastrado</h5>
                                <p class="text-muted mb-4">
                                    Clique no botão abaixo para cadastrar o primeiro cliente do sistema.
                                </p>
                                <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus"></i> Cadastrar Primeiro Cliente
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para exibir detalhes -->
    <div class="modal fade" id="modalDetalhes" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user"></i> Detalhes do Cliente
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalDetalhesBody">
                    <!-- Conteúdo será inserido via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Função para exibir detalhes do cliente
        function verDetalhes(cliente) {
            const modalBody = document.getElementById('modalDetalhesBody');
            modalBody.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary"><i class="fas fa-user"></i> Dados Pessoais</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Nome:</strong></td><td>${cliente.nome}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${cliente.email}</td></tr>
                            <tr><td><strong>Telefone:</strong></td><td>${cliente.telefone}</td></tr>
                            <tr><td><strong>CPF:</strong></td><td>${cliente.cpf}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary"><i class="fas fa-map-marker-alt"></i> Endereço</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Endereço:</strong></td><td>${cliente.endereco || 'Não informado'}</td></tr>
                            <tr><td><strong>Cidade:</strong></td><td>${cliente.cidade || 'Não informado'}</td></tr>
                            <tr><td><strong>Estado:</strong></td><td>${cliente.estado || 'Não informado'}</td></tr>
                            <tr><td><strong>CEP:</strong></td><td>${cliente.cep || 'Não informado'}</td></tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-primary"><i class="fas fa-clock"></i> Informações do Sistema</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Cadastrado em:</strong></td><td>${formatarData(cliente.created_at)}</td></tr>
                            <tr><td><strong>Última atualização:</strong></td><td>${formatarData(cliente.updated_at)}</td></tr>
                        </table>
                    </div>
                </div>
            `;
            
            const modal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
            modal.show();
        }

        // Função para formatar data
        function formatarData(dataString) {
            if (!dataString) return 'Não informado';
            const data = new Date(dataString);
            return data.toLocaleString('pt-BR');
        }

        // Função para confirmar exclusão
        function confirmarExclusao(nomeCliente) {
            if (confirm(`Tem certeza que deseja excluir o cliente "${nomeCliente}"?\n\nEsta ação não pode ser desfeita.`)) {
                alert('Funcionalidade de exclusão ainda não implementada!');
                // Aqui você implementará a exclusão quando fizer a parte DELETE do CRUD
            }
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