@extends("layouts.template")

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("deputados.despesas") }}">Despesas</a></li>
            <li class="breadcrumb-item active">{{ $deputado->nome }}</li>
        </ol>
    </nav>
@endsection

@section("content")
    <section>
        <header>
            <h1><strong>Despesas do(a) Deputado {{ $deputado->nome }}</strong></h1>
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
                            <td scope="row">{{ $despesa->numero_documento }}</td>
                            <td scope="row">{{ $despesa->descricao }}</td>
                            <td scope="row">{{ (new \DateTime($despesa->data))->format("d/m/Y") }}</td>
                            <td scope="row">{{ $despesa->valor_liquido }}</td>
                            <td scope="row">
                                @if (isset($despesa->url_documento) && empty($despesa->url_documento) == false)
                                    <a href="{{ $despesa->url_documento }}" target="_blank" rel="noopener noreferrer">Ver documento</a>
                                @else
                                    Não disponível
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                @foreach ($links as $link)
                    <li @class(['page-item', 'active' => $link->rel == 'atual'])>
                        <a href="{{ route('deputado.despesas', ['id' => $deputado->id, 'pagina' => $link->pagina]) }}"
                            class="page-link">{{ $link->label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </section>
@endsection