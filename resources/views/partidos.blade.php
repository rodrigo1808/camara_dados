@extends('layouts.template')

@section('content')
    <section class="pt-3 pb-4">
        <header>
            <h1><strong>Partidos</strong></h1>
            <p>Consulte as <strong>despesas</strong> equantidade de membros por partido.</p>
        </header>
        <div class="row row-cols-2 row-cols-md-3 row-cols xl-4 g-4">
            @foreach ($partidos as $partido)
                <div class="col">
                    <div class="card">
                        <img src="{{ $partido->url_foto }}" alt="Imagem do partido {{ $partido->sigla }}" title="Imagem do partido {{ $partido->sigla }}" class="card-img-top img-fluid">
                        <div class="card-body">
                            <h3 class="card-title text-center"><abbr title="{{ $partido->nome }}" class="initialism">{{ $partido->sigla }}</abbr></h3>
                            <div class="card-text">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Despesa Total: R$ {{ number_format((double) $partido->despesa_total, 2, ",", ".") }}</li>
                                    <li class="list-group-item">Membros: {{ $partido->quantidade_membros }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection