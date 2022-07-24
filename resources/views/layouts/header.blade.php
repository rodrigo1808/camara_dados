<header>
    <nav class="navbar navbar-expand-md sticky-top bg-success">
        <div class="container">
            <a href="{{ env("APP_URL") }}" class="navbar-brand">Dados da Câmera de deputados</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar-content">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar-content" class="offcanvas offcanvas-end" tabindex="-1">
                <div class="offcanvas-header">
                    <h2 class="offcanvas-title">Mapa de Páginas</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item">
                            <a @class([ "nav-link", "active" => Request::is("/") ]) href="{{ env('APP_URL') }}">Home</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a @class([ "nav-link", "active" => Request::is("/deputados") ]) href="/deputados">Deputados</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a @class([ "nav-link", "active" => Request::is("/despesas") ]) href="/preposicoes">Preposições</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>