/* camara_dados_logico: */

CREATE TABLE Deputados (
    cpf VARCHAR(255),
    nome VARCHAR(255),
    url_foto VARCHAR(255),
    sexo CHAR,
    escolariedade VARCHAR(255),
    uf VARCHAR(255),
    id INTEGER PRIMARY KEY,
    partido_id INTEGER,
    data_nascimento DATE,
    municipio_nascimento VARCHAR(255),
    uf_nascimento VARCHAR(255),
    situacao VARCHAR(255),
    condicao_eleitoral VARCHAR(255),
    email VARCHAR(255),
    nome_civil VARCHAR(255),
    nome_eleitoral VARCHAR(255)
);

CREATE TABLE Despesas (
    data DATE,
    descricao VARCHAR(255),
    numero_documento VARCHAR(255) PRIMARY KEY,
    valor_liquido NUMERIC(10,2),
    deputado_id INTEGER
);

CREATE TABLE Frentes (
    telefone VARCHAR(255),
    titulo VARCHAR(255),
    id INTEGER PRIMARY KEY,
    coordenador_id INTEGER
);

CREATE TABLE Partidos (
    id INTEGER PRIMARY KEY,
    sigla VARCHAR(255),
    url_foto VARCHAR(255),
    nome VARCHAR(255),
    lider_id INTEGER
);

CREATE TABLE Ocupacoes (
    deputado_id INT NOT NULL,
    ocupacao VARCHAR(511),
    PRIMARY KEY (deputado_id, ocupacao)
);

CREATE TABLE Deputados_Frentes (
    deputado_id INTEGER,
    frente_id INTEGER
);
 
ALTER TABLE Despesas ADD CONSTRAINT FK_Despesa_Deputado
    FOREIGN KEY (deputado_id)
    REFERENCES Deputados (id)
    ON DELETE CASCADE;
 
ALTER TABLE Frentes ADD CONSTRAINT FK_Frente_Deputado
    FOREIGN KEY (coordenador_id)
    REFERENCES Deputados (id)
    ON DELETE SET NULL;
 
ALTER TABLE Partidos ADD CONSTRAINT FK_Partido_Deputado
    FOREIGN KEY (lider_id)
    REFERENCES Deputados (id);
 
ALTER TABLE Ocupacoes ADD CONSTRAINT FK_Ocupacao_Deputado
    FOREIGN KEY (deputado_id)
    REFERENCES Deputados (id);
 
ALTER TABLE Deputados_Frentes ADD CONSTRAINT FK_Deputados_Frentes_Deputado
    FOREIGN KEY (deputado_id)
    REFERENCES Deputados (id)
    ON DELETE SET NULL;
 
ALTER TABLE Deputados_Frentes ADD CONSTRAINT FK_Deputados_Frentes_Frente
    FOREIGN KEY (frente_id)
    REFERENCES Frentes (id)
    ON DELETE SET NULL;