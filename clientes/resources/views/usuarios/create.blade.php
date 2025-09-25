<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Usuário</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h1 class="h4 mb-0"><i class="fas fa-user-plus"></i> Cadastro de Usuário</h1>
        </div>
        <div class="card-body">
          
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

          <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
            @csrf
            
            <div class="mb-3">
              <label for="nome" class="form-label fw-bold">Nome completo <span class="text-danger">*</span></label>
              <input type="text" 
                     id="nome" 
                     name="nome"
                     class="form-control @error('nome') is-invalid @enderror" 
                     value="{{ old('nome') }}"
                     placeholder="Digite seu nome completo"
                     required>
              @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-bold">E-mail <span class="text-danger">*</span></label>
              <input type="email" 
                     id="email" 
                     name="email"
                     class="form-control @error('email') is-invalid @enderror" 
                     value="{{ old('email') }}"
                     placeholder="Digite seu e-mail"
                     required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="senha" class="form-label fw-bold">Senha <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" 
                       id="senha" 
                       name="senha"
                       class="form-control @error('senha') is-invalid @enderror" 
                       minlength="8" 
                       placeholder="Mínimo 8 caracteres"
                       required>
                <button class="btn btn-outline-secondary" type="button" id="toggleSenha">
                  <i class="fas fa-eye" id="iconSenha"></i>
                </button>
                @error('senha')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-text">A senha deve conter pelo menos 8 caracteres</div>
            </div>

            <div class="mb-3">
              <label for="senha_confirmation" class="form-label fw-bold">Confirmar Senha <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" 
                       id="senha_confirmation" 
                       name="senha_confirmation"
                       class="form-control @error('senha_confirmation') is-invalid @enderror" 
                       placeholder="Confirme sua senha"
                       required>
                <button class="btn btn-outline-secondary" type="button" id="toggleConfirma">
                  <i class="fas fa-eye" id="iconConfirma"></i>
                </button>
                @error('senha_confirmation')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label for="pais" class="form-label fw-bold">País <span class="text-danger">*</span></label>
              <select id="pais" 
                      name="pais" 
                      class="form-select @error('pais') is-invalid @enderror" 
                      required>
                <option value="">Selecione um país</option>
                <option value="Brasil" {{ old('pais') == 'Brasil' ? 'selected' : '' }}>Brasil</option>
                <option value="Portugal" {{ old('pais') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                <option value="Outro" {{ old('pais') == 'Outro' ? 'selected' : '' }}>Outro</option>
              </select>
              @error('pais')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold">Interesses</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input @error('interesses') is-invalid @enderror" 
                       type="checkbox" 
                       id="interesse1"
                       name="interesses[]" 
                       value="Tecnologia"
                       {{ is_array(old('interesses')) && in_array('Tecnologia', old('interesses')) ? 'checked' : '' }}>
                <label class="form-check-label" for="interesse1">Tecnologia</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input @error('interesses') is-invalid @enderror" 
                       type="checkbox" 
                       id="interesse2"
                       name="interesses[]" 
                       value="Design"
                       {{ is_array(old('interesses')) && in_array('Design', old('interesses')) ? 'checked' : '' }}>
                <label class="form-check-label" for="interesse2">Design</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input @error('interesses') is-invalid @enderror" 
                       type="checkbox" 
                       id="interesse3"
                       name="interesses[]" 
                       value="Marketing"
                       {{ is_array(old('interesses')) && in_array('Marketing', old('interesses')) ? 'checked' : '' }}>
                <label class="form-check-label" for="interesse3">Marketing</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input @error('interesses') is-invalid @enderror" 
                       type="checkbox" 
                       id="interesse4"
                       name="interesses[]" 
                       value="Negócios"
                       {{ is_array(old('interesses')) && in_array('Negócios', old('interesses')) ? 'checked' : '' }}>
                <label class="form-check-label" for="interesse4">Negócios</label>
              </div>
              @error('interesses')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="foto" class="form-label fw-bold">Foto de Perfil</label>
              <input type="file" 
                     id="foto" 
                     name="foto"
                     class="form-control @error('foto') is-invalid @enderror" 
                     accept="image/*">
              <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</div>
              @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              
              <!-- Preview da imagem -->
              <div id="imagePreview" class="mt-2" style="display: none;">
                <img id="previewImg" src="" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                <div class="mt-1">
                  <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                    <i class="fas fa-trash"></i> Remover
                  </button>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label for="comentarios" class="form-label fw-bold">Comentários</label>
              <textarea id="comentarios" 
                        name="comentarios"
                        class="form-control @error('comentarios') is-invalid @enderror" 
                        rows="3" 
                        placeholder="Conte um pouco sobre você...">{{ old('comentarios') }}</textarea>
              @error('comentarios')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="reset" class="btn btn-secondary me-md-2">
                <i class="fas fa-broom"></i> Limpar
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Cadastrar
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
  // Toggle senha
  document.getElementById('toggleSenha').addEventListener('click', function() {
    const senhaInput = document.getElementById('senha');
    const icon = document.getElementById('iconSenha');
    
    if (senhaInput.type === 'password') {
      senhaInput.type = 'text';
      icon.className = 'fas fa-eye-slash';
    } else {
      senhaInput.type = 'password';
      icon.className = 'fas fa-eye';
    }
  });

  // Toggle confirmar senha
  document.getElementById('toggleConfirma').addEventListener('click', function() {
    const confirmaInput = document.getElementById('senha_confirmation');
    const icon = document.getElementById('iconConfirma');
    
    if (confirmaInput.type === 'password') {
      confirmaInput.type = 'text';
      icon.className = 'fas fa-eye-slash';
    } else {
      confirmaInput.type = 'password';
      icon.className = 'fas fa-eye';
    }
  });

  // Preview da imagem
  document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('imagePreview').style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });

  // Remover imagem
  function removeImage() {
    document.getElementById('foto').value = '';
    document.getElementById('imagePreview').style.display = 'none';
  }

  // Validação de senhas iguais
  document.getElementById('userForm').addEventListener('submit', function(e) {
    const senha = document.getElementById('senha').value;
    const confirma = document.getElementById('senha_confirmation').value;
    
    if (senha !== confirma) {
      e.preventDefault();
      alert('As senhas não conferem!');
      document.getElementById('senha_confirmation').focus();
      return false;
    }
  });

  // Validação de confirmação de senha em tempo real
  document.getElementById('senha_confirmation').addEventListener('input', function() {
    const senha = document.getElementById('senha').value;
    const confirma = this.value;
    
    if (confirma && senha !== confirma) {
      this.setCustomValidity('As senhas não conferem');
      this.classList.add('is-invalid');
    } else {
      this.setCustomValidity('');
      this.classList.remove('is-invalid');
    }
  });
</script>
</body>
</html>