@extends("layouts.template")

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("deputados.despesas") }}">Despesas</a></li>
            <li class="breadcrumb-item active">{{ $deputado->ultimoStatus->nome }}</li>
        </ol>
    </nav>
@endsection

@section("content")
    <section>
        <header>
            <h1><strong>Despesas do(a) Deputado {{ $deputado->ultimoStatus->nome }}</strong></h1>
        </header>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Número do Documento</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Data do Documento</th>
                        <th scope="col">Valor Líquido</th>
                        <th scope="col">Documento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($despesas as $despesa)
                        <tr>
                            <td scope="row">{{ $despesa->codDocumento }}</td>
                            <td scope="row">{{ $despesa->tipoDespesa }}</td>
                            <td scope="row">{{ (new \DateTime($despesa->dataDocumento))->format("d/m/Y") }}</td>
                            <td scope="row">{{ $despesa->valorLiquido }}</td>
                            <td scope="row">{{ $despesa->urlDocumento || "Não disponível" }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection