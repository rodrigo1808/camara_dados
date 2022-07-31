@extends('layouts.template')

@section('content')
    <section>
        <header>
            <h1><strong>Despesas</strong></h1>
            <p>Veja as despesas de cada deputado</p>
        </header>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Deputado</th>
                        <th scope="col">Partido</th>
                        <th scope="col">Despesa Total</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($despesasPorDeputado as $deputado)
                        <tr>
                            <th scope="row">{{ $deputado->id }}</th>
                            <td>{{ $deputado->nome }}</td>
                            <td>{{ $deputado->partido_nome }}</td>
                            <td>R$ {{ number_format((double) $deputado->despesa_total, 2, ",", ".") }}</td>
                            <td><a href="{{ route("deputado.despesas", ["id" => $deputado->id]) }}" class="btn btn-primary ">Ver Detalhes</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                @foreach ($links as $link)
                    <li @class(['page-item', 'active' => $link->rel == 'atual'])>
                        <a href="{{ route('deputados.despesas', ['pagina' => $link->pagina]) }}"
                            class="page-link">{{ $link->label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </section>
@endsection
