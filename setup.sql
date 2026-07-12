-- 1. Cria o banco de dados com suporte completo a caracteres especiais e emojis
CREATE DATABASE lojajogos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Cria um usuário dedicado apenas para acesso local
CREATE USER 'loja_user'@'localhost' IDENTIFIED BY 'SenhaForte123!';

-- 3. Concede permissões TOTAIS apenas para o banco do projeto lojajogos
GRANT ALL PRIVILEGES ON lojajogos.* TO 'loja_user'@'localhost';

-- 4. Aplica as mudanças de privilégios imediatamente
FLUSH PRIVILEGES;