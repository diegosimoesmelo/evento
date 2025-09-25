@extends('layout')


@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1>Editar Item</h1>
       
        <form action="{{ route('itens.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
           
            <div class="mb-3">
                <label for="nome" class="form-label">Nome *</label>
                <input type="text" class="form-control" id="nome" name="nome"
                       value="{{ old('nome', $item->nome) }}" required>
            </div>


            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao"
                          rows="3">{{ old('descricao', $item->descricao) }}</textarea>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço *</label>
                        <input type="number" class="form-control" id="preco" name="preco"
                               step="0.01" min="0" value="{{ old('preco', $item->preco) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade *</label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade"
                               min="0" value="{{ old('quantidade', $item->quantidade) }}" required>
                    </div>
                </div>
            </div>


            <div class="mb-3">
                <button type="submit" class="btn btn-success">Atualizar</button>
                <a href="{{ route('itens.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
