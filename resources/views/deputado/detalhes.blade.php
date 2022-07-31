@extends("layouts.template")

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("deputados") }}">Deputados</a></li>
            <li class="breadcrumb-item active" aria-current="{{ $deputado->nome }}">{{ $deputado->nome }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="pt-3 pb-3">
        <div class="row">
            <div class="col-md-4 d-flex flex-column justify-content-center mb-4">
                <h1 class="text-center"><strong>Deputado {{ $deputado->nome }}</strong></h1>
                <img src="{{ $deputado->url_foto }}" style="max-width: 300px" width="100%" class=" mx-auto img-thumbnail" alt="Foto de perfil do deputado {{ $deputado->nome }}">
            </div>
            <div class="col-md d-flex flex-column justify-content-center">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nome Civil</strong>: {{ $deputado->nome_civil }}</li>
                    <li class="list-group-item"><strong>Partido</strong>: <abbr title="{{ $deputado->partido_nome }}">{{ $deputado->partido_sigla }}</abbr></li>
                    <li class="list-group-item"><strong>UF</strong>: {{ $deputado->uf }}</li>
                    <li class="list-group-item"><strong>Email</strong>: <a href="mailto:{{ $deputado->email }}">{{ $deputado->email }}</a></li>
                    <li class="list-group-item"><strong>Data de Nascimento</strong>: {{ (new \DateTime($deputado->data_nascimento))->format("d/m/Y") }}</li>
                    <li class="list-group-item"><strong>Situação</strong>: {{ $deputado->situacao }}</li>
                    <li class="list-group-item"><strong>Condição Eleitoral</strong>: {{ $deputado->condicao_eleitoral }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection