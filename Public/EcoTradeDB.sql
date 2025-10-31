create database ubiquabd;

USE ubiquabd;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'empresa', 'produtor') NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produtores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cpf VARCHAR(14) UNIQUE,
    nome_fazenda VARCHAR(100),
    localizacao VARCHAR(150),
    ativo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    razao_social VARCHAR(150),
    setor_atuacao VARCHAR(100),
    ativo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cargo VARCHAR(100),
    ativo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);


CREATE TABLE creditos_carbono (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produtor_id INT NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    origem VARCHAR(255),
    data_geracao DATE,
    status ENUM('pendente', 'aprovado', 'vendido') DEFAULT 'pendente',
    ativo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (produtor_id) REFERENCES produtores(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE validacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    credito_id INT NOT NULL,
    admin_id INT NOT NULL,
    data_validacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('aprovado', 'rejeitado') NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (credito_id) REFERENCES creditos_carbono(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES administradores(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE negociacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produtor_id INT NOT NULL,
    empresa_id INT NOT NULL,
    credito_id INT NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    data_negociacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produtor_id) REFERENCES produtores(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY (credito_id) REFERENCES creditos_carbono(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- =========================================================
-- TABELA: historico_publico
-- =========================================================
CREATE TABLE historico_publico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    negociacao_id INT NOT NULL,
    data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (negociacao_id) REFERENCES negociacoes(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);
