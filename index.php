<?php 

//Arquivo necessário para conectar a página ao banco de dados.
require_once 'config/Database.php';
require_once 'classes/Categoria.php';
require_once 'classes/Usuario.php';


//Inicializa a conexão
$database = new Database();
$db = $database->getConnection();

//Prepara a classe Categoria
$usuario = new Usuario($db);
$usuario->nome = "Admin"; //Nome do usuario
$usuario->email = "admin@lojajogos.local"; //Emai do usuario
$usuario->senha = "SenhaSegura1234"; //Senha do usuario
$usuario->papel = "admin"; //papel do usuário

//Tenta criar
if($usuario->login($usuario->email, $usuario->senha)) {
    echo "Login efetuado com sucesso! Bem-vindo, {$usuario->nome}. Nível: {$usuario->papel}";
} else {
    echo "Email ou senha incorretos.";
}

?>
