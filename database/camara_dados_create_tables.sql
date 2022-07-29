/* trabalhodebdLogico: */

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
    uf_nascimento VARCHAR(255)
);

CREATE TABLE Despesas (
    data DATE,
    descricao VARCHAR(255),
    numero_documento VARCHAR(255) PRIMARY KEY,
    valor_liquido NUMERIC,
    deputado_id INTEGER
);

CREATE TABLE Proposicoes (
    data_votacao DATE,
    situacao VARCHAR(255),
    titulo VARCHAR(255),
    ementa VARCHAR(255),
    tipo VARCHAR(255),
    ano_proposto VARCHAR(255),
    id INTEGER PRIMARY KEY,
    propositor_id INTEGER
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
    ocupacao VARCHAR(255),
    PRIMARY KEY (deputado_id, ocupacao)
);

CREATE TABLE Votacoes (
    deputado_id INTEGER,
    proposicoes_id INTEGER,
    voto VARCHAR(255)
);
 
ALTER TABLE Despesas ADD CONSTRAINT FK_Despesa_Deputado
    FOREIGN KEY (deputado_id)
    REFERENCES Deputados (id)
    ON DELETE CASCADE;
 
ALTER TABLE Proposicoes ADD CONSTRAINT FK_Proposicao_Deputado
    FOREIGN KEY (propositor_id)
    REFERENCES Deputados (id)
    ON DELETE SET NULL;
 
ALTER TABLE Partidos ADD CONSTRAINT FK_Partido_Deputado
    FOREIGN KEY (lider_id)
    REFERENCES Deputados (id);
 
ALTER TABLE Ocupacoes ADD CONSTRAINT FK_Ocupacao_Deputado
    FOREIGN KEY (deputado_id)
    REFERENCES Deputados (id);
 
ALTER TABLE Votacoes ADD CONSTRAINT FK_Votacao_Deputado
    FOREIGN KEY (deputado_id)
    REFERENCES Deputados (id)
    ON DELETE SET NULL;
 
ALTER TABLE Votacoes ADD CONSTRAINT FK_Votacao_Proposicao
    FOREIGN KEY (proposicoes_id)
    REFERENCES Proposicoes (id)
    ON DELETE SET NULL;