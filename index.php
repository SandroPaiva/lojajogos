<?php 

//Arquivo necessário para conectar a página ao banco de dados.
require_once 'config/Database.php';

$db = new Database();

$conexao = $db->getsConnection();

if($conexao) {
    echo "<h1>Banco ${db_name} conectado com sucesso usando PDO!</h1>";
}




?>
