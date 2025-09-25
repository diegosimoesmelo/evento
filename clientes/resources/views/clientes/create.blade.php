<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
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
                        <h4 class="mb-0"><i class="fas fa-user-plus"></i> Cadastrar Novo Cliente</h4>
                        <a href="{{ route('clientes.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('clientes.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <!-- Nome -->
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label fw-bold">Nome Completo <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nome') is-invalid @enderror" 
                                           id="nome" 
                                           name="nome" 
                                           value="{{ old('nome') }}" 
                                           placeholder="Digite o nome completo"
                                           required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Digite o email"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Telefone -->
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label fw-bold">Telefone <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('telefone') is-invalid @enderror" 
                                           id="telefone" 
                                           name="telefone" 
                                           value="{{ old('telefone') }}" 
                                           placeholder="(11) 99999-9999"
                                           required>
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- CPF -->
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label fw-bold">CPF <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('cpf') is-invalid @enderror" 
                                           id="cpf" 
                                           name="cpf" 
                                           value="{{ old('cpf') }}" 
                                           placeholder="12345678901" 
                                           maxlength="11"
                                           required>
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Endereço -->
                                <div class="col-md-12 mb-3">
                                    <label for="endereco" class="form-label fw-bold">Endereço</label>
                                    <input type="text" 
                                           class="form-control @error('endereco') is-invalid @enderror" 
                                           id="endereco" 
                                           name="endereco" 
                                           value="{{ old('endereco') }}" 
                                           placeholder="Rua, número, bairro">
                                    @error('endereco')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Cidade -->
                                <div class="col-md-4 mb-3">
                                    <label for="cidade" class="form-label fw-bold">Cidade</label>
                                    <input type="text" 
                                           class="form-control @error('cidade') is-invalid @enderror" 
                                           id="cidade" 
                                           name="cidade" 
                                           value="{{ old('cidade') }}" 
                                           placeholder="Digite a cidade">
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Estado -->
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label fw-bold">Estado</label>
                                    <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado">
                                        <option value="">Selecione o estado</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->codigo }}" {{ old('estado') == $estado->codigo ? 'selected' : '' }}>
                                                {{ $estado->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- CEP -->
                                <div class="col-md-4 mb-3">
                                    <label for="cep" class="form-label fw-bold">CEP</label>
                                    <input type="text" 
                                           class="form-control @error('cep') is-invalid @enderror" 
                                           id="cep" 
                                           name="cep" 
                                           value="{{ old('cep') }}" 
                                           placeholder="12345-678">
                                    @error('cep')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('clientes.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Cadastrar Cliente
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Máscara para telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 11) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 7) {
                value = value.replace(/^(\d{2})(\d{4})(\d+)/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/^(\d{2})(\d+)/, '($1) $2');
            }
            e.target.value = value;
        });

        // Máscara para CEP
        document.getElementById('cep').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 5) {
                value = value.replace(/^(\d{5})(\d+)/, '$1-$2');
            }
            e.target.value = value;
        });

        // Máscara para CPF (só números)
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value.substring(0, 11);
        });

        // Validação básica no front-end
        document.querySelector('form').addEventListener('submit', function(e) {
            const nome = document.getElementById('nome').value.trim();
            const email = document.getElementById('email').value.trim();
            const telefone = document.getElementById('telefone').value.trim();
            const cpf = document.getElementById('cpf').value.trim();

            if (!nome || !email || !telefone || !cpf) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios!');
                return false;
            }

            if (cpf.length !== 11) {
                e.preventDefault();
                alert('CPF deve ter 11 dígitos!');
                document.getElementById('cpf').focus();
                return false;
            }
        });
    </script>
</body>
</html>