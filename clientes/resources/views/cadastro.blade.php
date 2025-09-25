<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
  <h1 class="mb-4">Cadastro de Usuário</h1>

  @if (session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Corrija os erros abaixo:</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="nome" class="form-label">Nome completo</label>
      <input type="text" id="nome" name="nome" class="form-control" required value="{{ old('nome') }}">
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
    </div>

    <div class="mb-3">
      <label for="senha" class="form-label">Senha</label>
      <input type="password" id="senha" name="senha" class="form-control" minlength="8" required>
    </div>

    <div class="mb-3">
      <label for="confirma" class="form-label">Confirmar Senha</label>
      <!-- use o nome senha_confirmation para a regra "confirmed" -->
      <input type="password" id="confirma" name="senha_confirmation" class="form-control" required>
    </div>

    <!-- <div class="mb-3">
      <label class="form-label">País</label>
      <select class="form-select" name="pais" required>
        <option value="Brasil" {{ old('pais')=='Brasil'?'selected':'' }}>Brasil</option>
        <option value="Portugal" {{ old('pais')=='Portugal'?'selected':'' }}>Portugal</option>
        <option value="Outro" {{ old('pais')=='Outro'?'selected':'' }}>Outro</option>
      </select>
    </div> -->


<div class="mb-3">
  <label class="form-label">País</label>
  <select class="form-select" name="pais" required>
    <option value="">-- Selecione --</option>
    @foreach($paises as $code => $nome)
      <option value="{{ $code }}" {{ old('pais') == $code ? 'selected' : '' }}>
        {{ $nome }}
      </option>
    @endforeach
  </select>
</div>


    <div class="mb-3">
      <label class="form-label">Interesses</label><br>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="interesse1" name="interesses[]" value="Tecnologia" {{ in_array('Tecnologia', old('interesses', []))?'checked':'' }}>
        <label class="form-check-label" for="interesse1">Tecnologia</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="interesse2" name="interesses[]" value="Design" {{ in_array('Design', old('interesses', []))?'checked':'' }}>
        <label class="form-check-label" for="interesse2">Design</label>
      </div>
    </div>

    <div class="mb-3">
      <label for="foto" class="form-label">Foto de Perfil</label>
      <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
      <label for="comentarios" class="form-label">Comentários</label>
      <textarea id="comentarios" name="comentarios" class="form-control" rows="3">{{ old('comentarios') }}</textarea>
    </div>

    <button type="reset" class="btn btn-secondary">Limpar</button>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
</div>

</body>
</html>
