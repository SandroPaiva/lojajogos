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

CREATE TABLE jogos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT NULL, -- Como a sinopse de um jogo pode ser longa e não sabemos o limite exato, aqui o uso do TEXT é justificado e recomendado.
    preco DECIMAL(10,2) NOT NULL, -- Define um número decimal com 10 dígitos no total, sendo 2 após a vírgula (centavos).
    estoque INT NOT NULL DEFAULT 0, -- Se não informarmos o estoque na hora de cadastrar, ele começa zerado automaticamente.
    categoria_id INT NOT NULL,
    fabricante_id INT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT, -- Conecta o categoria_id da nossa tabela com o id da tabela categorias.
    FOREIGN KEY (fabricante_id) REFERENCES fabricantes(id) ON DELETE RESTRICT -- Conecta o fabricante_id da nossa tabela com o id da tabela fabricantes.
    -- ON DELETE RESTRICT é uma regra de proteção. Impede que uma categoria seja deletada se houver jogos vinculados a ela.
);

CREATE TABLE jogos_plataforma (
	jogo_id INT NOT NULL,
    plataforma_id INT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (jogo_id, plataforma_id), -- define os campos jogo_id e plataforma_id como chaves primárias compostas
    FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON DELETE RESTRICT,
    FOREIGN KEY (plataforma_id) REFERENCES plataformas(id) ON DELETE RESTRICT
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL, -- 255 é o tamanho recomendado para hashes Bcrypt/Argon2
    papel ENUM('cliente', 'admin') DEFAULT 'cliente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    jogo_id INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    adicionado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (jogo_id) REFERENCES jogos(id) ON DELETE CASCADE,
    UNIQUE(usuario_id, jogo_id) -- Garante que o mesmo jogo não ocupe duas linhas
);

INSERT INTO fabricantes (nome, site_url) VALUES
('Blizzard Entertainment', 'https://www.blizzard.com'),
('Electronic Arts', 'https://www.ea.com'),
('Xbox Game Studios', 'https://www.xbox.com'),
('Sony Interactive Entertainment', 'https://www.playstation.com'),
('Nintendo', 'https://www.nintendo.com'),
('Ubisoft', 'https://www.ubisoft.com'),
('Square Enix', 'https://square-enix-games.com'),
('Valve Corporation', 'https://www.valvesoftware.com'),
('Rockstar Games', 'https://www.rockstargames.com'),
('Epic Games', 'https://www.epicgames.com');

INSERT INTO fabricantes (nome, site_url) VALUES
('Bandai Namco Entertainment', 'https://www.bandainamcoent.com'),
('FromSoftware', 'https://www.fromsoftware.jp');

INSERT INTO categorias (nome) VALUES
('Aventura'),
('Estratégia'),
('Esportes'),
('Simulação'),
('Corrida'),
('Luta'),
('Terror'),
('Plataforma'),
('Mundo Aberto');

INSERT INTO jogos (titulo, preco, categoria_id, fabricante_id) VALUES ('Elden Ring', 250.00, 1, 1);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT
);