<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Nova Cidade</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <h1 class="mb-4">Cadastro de Cidade</h1>

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

  <form action="{{ route('cidades.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="nome" class="form-label">Nome da cidade</label>
      <input type="text" id="nome" name="nome" class="form-control" required value="{{ old('nome') }}">
    </div>

    <div class="mb-3">
      <label class="form-label">País</label>
      <select class="form-select" name="country_code" required>
        <option value="">-- Selecione --</option>
        @foreach($paises as $code => $nome)
          <option value="{{ $code }}" @selected(old('country_code') == $code)>{{ $nome }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
</div>
</body>
</html>
