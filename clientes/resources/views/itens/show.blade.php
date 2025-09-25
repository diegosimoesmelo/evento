@extends('layout')


@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Detalhes do Item</h3>
                <div>
                    <a href="{{ route('itens.edit', $item->id) }}" class="btn btn-warning">Editar</a>
                    <a href="{{ route('itens.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $item->id }}</p>
                        <p><strong>Nome:</strong> {{ $item->nome }}</p>
                        <p><strong>Preço:</strong> R$ {{ number_format($item->preco, 2, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Quantidade:</strong> {{ $item->quantidade }}</p>
                        <p><strong>Criado em:</strong> {{ date('d/m/Y H:i', strtotime($item->created_at)) }}</p>
                    </div>
                </div>
                @if($item->descricao)
                <div class="mt-3">
                    <strong>Descrição:</strong>
                    <p>{{ $item->descricao }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
