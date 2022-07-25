@extends('layouts.template')

@section('content')
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
        <div class="row row-cols-4 g-4">
            <div class="col">
                <div class="card">
                    <img src="https://www.camara.leg.br/internet/deputado/bandep/76874.jpg" alt="Foto de perfil do deputado Marcelo Freixho" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Marcelo Freixo</h3>
                        <h4 class="card-subtitle mb-2 text-muted fs-6">PSB</h4>
                        <a href="http://" class="btn fundo-verde">Mais informações</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="https://www.camara.leg.br/internet/deputado/bandep/76874.jpg" alt="Foto de perfil do deputado Marcelo Freixho" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Marcelo Freixo</h3>
                        <h4 class="card-subtitle mb-2 text-muted fs-6">PSB</h4>
                        <a href="http://" class="btn fundo-verde">Mais informações</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="https://www.camara.leg.br/internet/deputado/bandep/76874.jpg" alt="Foto de perfil do deputado Marcelo Freixho" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Marcelo Freixo</h3>
                        <h4 class="card-subtitle mb-2 text-muted fs-6">PSB</h4>
                        <a href="http://" class="btn fundo-verde">Mais informações</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="https://www.camara.leg.br/internet/deputado/bandep/76874.jpg" alt="Foto de perfil do deputado Marcelo Freixho" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Marcelo Freixo</h3>
                        <h4 class="card-subtitle mb-2 text-muted fs-6">PSB</h4>
                        <a href="http://" class="btn fundo-verde">Mais informações</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="https://www.camara.leg.br/internet/deputado/bandep/76874.jpg" alt="Foto de perfil do deputado Marcelo Freixho" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title fs-4">Marcelo Freixo</h3>
                        <h4 class="card-subtitle mb-2 text-muted fs-6">PSB</h4>
                        <a href="http://" class="btn fundo-verde">Mais informações</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection