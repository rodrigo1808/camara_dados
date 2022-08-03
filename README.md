# Projeto Câmara de Dados
Olá Visitante!
Seja bem-vindo, aqui se encontra o repositório do projeto final de **Banco de Dados I 2022.01** da UFRJ. Membros:

- Joao Vitor Amancio Barroso
- Rodrigo Araújo
- Ramon Oliveira de Azevedo
- Diego Vasconcelos Schardosim de Matos

## Links
- Relatório: [https://www.overleaf.com/2588134892rchfpzgchdyy]()
- Apresentação: []

## A Aplicação Web
Nossa aplicação foi desenvolvida usando PhP com o framework Laravel 9. O projeto já vem estruturado seguindo um template pronto do Laravel que segue o padrão MVC (Model, View e Controller). 

Os Models podem ser encontrado no diretório App/Models/ e os controllers no diretório App/Http/Controllers/, já as Views se encontram no diretório Resources/Views/. Todos as informações relacionado ao banco de dados, como o **brmodelo**, **modelo conceitual**, **relacional** e **físico**, podem ser encontados no diretório Database/

Entretando, devido ao escopo de nosso projeto, não usamos nenhum Model, vale ressaltar também que as rotas de nossa aplicação são definidas no diretório Routes/.

### Instalando Dependências
Para subir o projeto localmente é necessário ter as seguintes ferramentas instaladas: node >= 16, npm >= 8, php >= 8, composer >= 2 e mysql. Certifique-se que estão instalados em sua máquina usando os comandos:

    ```bash
        node -v
        npm -v
        php -v
        composer -v
        mysql
    
    ```

Feito isso, clone o repositório e abra o terminal na raiz do projeto e execute os comandos:

    ```bash
    composer install
    npm install
    npm run build
    ```

### Configurando projeto
Com as dependências instaladas, é preciso realizar uma rápida configuração ao projeto. Crie uma cópia do arquivo .env.example e renomeie para .env. É obrigatório que os campos relacionado ao banco estejam preenchidos, após isso, use o comando

    ```bash
    php artisan key:generate
    ```

Para gerar uma chave para o projeto.

### Subindo o Banco de Dados
Agora, falta subirmos o banco e popularmos ele, para isso basta subir o arquivo camara_dados_dump.sql encontrado no diretório Database/ usando alguma ferramenta como o phpmyadmin.

**Atenção**: Devido ao tamanho do banco, você deve precisar alterar os valores padrões do php relacionado ao tamanho de arquivo, tempo de execução, etc.

### Executando aplicação
Com todas as dependencias instaladas e o projeto configurado, use o comando no terminal

    ```bash
    php artisan serve
    ```

para subir o servidor e acesse usando o link exibido no terminal (por padrão: http://127.0.0.1:8000).

**Atenção**: O diretório public/ do projeto precisa ser o web root do servidor, então se você estiver usando alguma ferramenta como o xampp, adicione o sufixo public/ para acessar as páginas, ex: 

    - http://127.0.0.1:8000/public/ -> Para acessar a home page
    - http://127.0.0.1:8000/public/despesas -> Para acessar a página de despesas
    - http://127.0.0.1:8000/public/partidos -> Para acessar a página de partidos

### Subindo a aplicação em uma hospedagem
É necessário que a hospedagem tenha suporte a versão do php >= 8 como descrita na documentação do Laravel 9, assim como todas as extensões obrigatórias. De uma maneira geral não é necessário se preocupar muito com isso pois as populares hospedagens já vem com suporte a tudo isso.

Uma básica hospedagem compartilhada já é o suficiente, apesar delas não terem suporte ao node basta você executar os comandos na sua máquina antes de subir o projeto, ou se você estiver usando alguma ferramente de Entrega Contínua (CI), como o Github Actions, é só executar os comandos previamente de realizar o deploy. Não se esqueça de configurar o arquivo .env.

**Atenção**: A raiz do projeto deve ficar fora da pasta public_html ( ou equivalente ) de sua hospedagem, e dentro dela deve ficar o conteúdo do diretório public.

### Rotas da Aplicação
Nossa aplicação possui 6 diferentes rotas:

- Uma página que lista todos os deputados, é a homepage, acessada através de '/'
- Ao clicar em um deputado, você poder visualizar informações detalhadas dele, acessada através de '/deputados/\{id\}'
- Uma página que lista as despesas por deputado, acessada através de '/despesas'
- Uma página que mostra as despesas com detalhes, acessada através de '/despesas/\{id\}'
- Uma página que mostra todos os partidos junto com a quantidade de membros e uma despesa total de seus membros, '/partidos'
- Uma página que mostra todas as frentes, junto com a quantidade de membros e a despesa total de seus membros, '/frentes'