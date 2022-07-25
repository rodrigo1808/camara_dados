<nav class="navbar navbar-expand-md fixed-top fundo-verde">
    <div class="container">
        <a href="{{ env("APP_URL") }}" class="navbar-brand"><h1 class="fs-4">Dados da Câmera de deputados</h1></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar-content">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbar-content" class="offcanvas offcanvas-end">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title">Mapa de Páginas</h2>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
            </div>
            <div class="offcanvas-body justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a @class([ "nav-link", "active" => Request::is("/") ]) href="{{ env('APP_URL') }}"><strong>Home</strong></a>
                    </li>
                    <li class="nav-item">
                        <a @class([ "nav-link", "active" => Request::is("/deputados") ]) href="/deputados"><strong>Deputados</strong></a>
                    </li>
                    <li class="nav-item">
                        <a @class([ "nav-link", "active" => Request::is("/despesas") ]) href="/preposicoes"><strong>Despesas</strong></a>
                    </li>
                    <li class="nav-item">
                        <a @class([ "nav-link", "active" => Request::is("/preposicoes") ]) href="/preposicoes"><strong>Preposições</strong></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
