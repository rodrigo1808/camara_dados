@extends('layouts.template')

@section('content')
    <section id="greetings" class="pt-3 mb-4">
        <header>
            <h2><strong>Olá Visitante!</strong></h2>
        </header>
        <hr />
        <div>
            <p>Esta aplicação foi desenvolvida por estudantes da UFRJ como trabalho final da disciplina <strong>Banco de Dados I</strong>. O código fonte é público e pode ser acessado <a href="https://github.com/rodrigo1808/camara_dados" target="_blank" rel="noopener noreferrer">Clicando aqui!</a> Os dados foram retirados de <a href="https://dadosabertos.camara.leg.br/" target="_blank" rel="noopener noreferrer">Dados Abertos da Câmera dos Deputados</a></p>
        </div>
    </section>
    <section id="deputados">
        <header>
            <h1><strong>Deputados</strong></h1>
        </header>
        <hr />
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4 mb-3">
            @foreach ($dados as $deputado)
                <div class="col">
                    <div class="card">
                        <img src="{{ $deputado->urlFoto }}" alt="Foto de perfil do deputado {{ $deputado->nome }}" class="card-img-top img-fluid">
                        <div class="card-body">
                            <h3 class="card-title fs-4">{{ $deputado->nome }}</h3>
                            <h4 class="card-subtitle mb-2 text-muted fs-6">{{ $deputado->siglaPartido }}</h4>
                            <a href="{{ route("deputado.detalhes", ["id" => $deputado->id]) }}" class="btn fundo-verde">Mais informações</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                @foreach ($links as $link)
                    <li @class(['page-item', 'active' => $link->rel == "atual"])>
                        <a href="{{ route("deputados", ["pagina" => $link->pagina]) }}" class="page-link">{{ $link->label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </section>
@endsection