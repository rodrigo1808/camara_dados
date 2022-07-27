@extends("layouts.template")

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("deputados") }}">Deputados</a></li>
            <li class="breadcrumb-item active" aria-current="{{ $deputado->ultimoStatus->nome }}">{{ $deputado->ultimoStatus->nome }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="pt-3 pb-3">
        <div class="row">
            <div class="col-md-4 d-flex flex-column justify-content-center mb-4">
                <h1 class="text-center"><strong>Deputado {{ $deputado->ultimoStatus->nome }}</strong></h1>
                <img src="{{ $deputado->ultimoStatus->urlFoto }}" style="max-width: 300px" width="100%" class=" mx-auto img-thumbnail" alt="Foto de perfil do deputado {{ $deputado->ultimoStatus->nome }}">
            </div>
            <div class="col-md d-flex flex-column justify-content-center">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nome Civil</strong>: {{ $deputado->nomeCivil }}</li>
                    <li class="list-group-item"><strong>Partido</strong>: {{ $deputado->ultimoStatus->siglaPartido }}</li>
                    <li class="list-group-item"><strong>UF</strong>: {{ $deputado->ultimoStatus->siglaUf }}</li>
                    <li class="list-group-item"><strong>Email</strong>: {{ $deputado->ultimoStatus->email }}</li>
                    <li class="list-group-item"><strong>Situação</strong>: {{ $deputado->ultimoStatus->situacao }}</li>
                    <li class="list-group-item"><strong>Condição Eleitoral</strong>: {{ $deputado->ultimoStatus->condicaoEleitoral }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection