@extends('layout')


@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 container my-5">
    <h1>Lista de Itens</h1>
    <a href="{{ route('itens.create') }}" class="btn btn-primary">Novo Item</a>
</div>


<div class="table-responsive container my-5">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itens as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nome }}</td>
                <td>{{ $item->descricao ?? 'Sem descrição' }}</td>
                <td>R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>
                    <a href="{{ route('itens.show', $item->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('itens.edit', $item->id) }}" class="btn btn-sm btn-warning">Editar</a>
                   
                    <form action="{{ route('itens.destroy', $item->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir?')">
                            Excluir
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
