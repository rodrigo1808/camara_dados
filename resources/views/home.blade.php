@extends('layouts.template')

@section('content')
    <div class="container">
        <section id="greetings" class="pt-3 mb-3">
            <header>
                <h2>Olá Visitante!</h2>
            </header>
            <hr />
            <div>
                <p>Esta aplicação foi desenvolvida por estudantes da UFRJ como trabalho final da disciplina <strong>Banco de Dados I</strong>. O código fonte é público e pode ser acessado <a href="https://github.com/rodrigo1808/camara_dados" target="_blank" rel="noopener noreferrer">Clicando aqui!</a> Os dados foram retirados de <a href="https://dadosabertos.camara.leg.br/" target="_blank" rel="noopener noreferrer">Dados Abertos da Câmera dos Deputados</a></p>
            </div>
        </section>
        <section id="deputados">
            <header>
                <h2>Deputados</h2>
            </header>
            <hr />
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection