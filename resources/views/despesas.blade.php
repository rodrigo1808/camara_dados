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
                    @foreach ($despesas as $despesa)
                        <tr>
                            <th scope="row">{{ $despesa->deputado_id }}</th>
                            <td>{{ $despesa->deputado_nome }}</td>
                            <td>{{ $despesa->deputado_partido }}</td>
                            <td>R$ {{ $despesa->custo_total }}</td>
                            <td><button class="btn btn-primary ">Ver Detalhes</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                @foreach ($links as $link)
                    <li @class(['page-item', 'active' => $link->rel == 'atual'])>
                        <a href="{{ route('despesas', ['pagina' => $link->pagina]) }}"
                            class="page-link">{{ $link->label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </section>
@endsection
