<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Novo Produto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <h1 class="mb-4">Cadastro de Produto</h1>

  @if (session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('produtos.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="nome" class="form-label">Nome do Produto</label>
      <input type="text" id="nome" name="nome" class="form-control" required value="{{ old('nome') }}">
    </div>

    <div class="mb-3">
      <label class="form-label">Tipo</label>
      <select class="form-select" name="tipo_id" required>
        <option value="">-- Selecione --</option>
        @foreach($tipos as $id => $nome)
          <option value="{{ $id }}" {{ old('tipo_id') == $id ? 'selected' : '' }}>
            {{ $nome }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
</div>
</body>
</html>
