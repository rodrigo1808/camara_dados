@extends('layouts.template')

@section('content')
    <section class="pt-3 pb-4">
        <header>
            <h1><strong>Frentes</strong></h1>
        </header>
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4 mb-4">
            @foreach ($frentes as $frente)
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><strong>{{ $frente->titulo }}</strong></h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Telefone da Frente: <a href="tel:+{{ $frente->telefone }}">{{ $frente->telefone }}</a></li>
                                <li class="list-group-item">Coordenador: {{ $frente->coordenador_nome }}</li>
                                <li class="list-group-item">Membros: {{ number_format((int) $frente->quantidade_membros) }}</li>
                                <li class="list-group-item">Despesa Total: R$ {{ number_format((double) $frente->despesa_total, 2, ",", ".") }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                @foreach ($links as $link)
                    <li @class(['page-item', 'active' => $link->rel == "atual"])>
                        <a href="{{ route("frentes", ["pagina" => $link->pagina]) }}" class="page-link">{{ $link->label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </section>
@endsection