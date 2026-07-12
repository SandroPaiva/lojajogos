-- 1. Cria o banco de dados com suporte completo a caracteres especiais e emojis
CREATE DATABASE lojajogos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Cria um usuário dedicado apenas para acesso local
CREATE USER 'loja_user'@'localhost' IDENTIFIED BY 'SenhaForte123!';

-- 3. Concede permissões TOTAIS apenas para o banco do projeto lojajogos
GRANT ALL PRIVILEGES ON lojajogos.* TO 'loja_user'@'localhost';

-- 4. Aplica as mudanças de privilégios imediatamente
FLUSH PRIVILEGES;

use lojajogos;

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE, -- Esse campo impede o cadastro de mais de uma caterogira com o mesmo nome.
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE fabricantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE, -- Esse campo impede o cadastro de mais de uma caterogira com o mesmo nome.
    site_url VARCHAR(250) NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE plataformas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE, -- Esse campo impede o cadastro de mais de uma caterogira com o mesmo nome.
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);