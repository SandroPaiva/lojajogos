<?php 

//Arquivo necessário para conectar a página ao banco de dados.
require_once 'config/Database.php';
require_once 'classes/Categoria.php';

//Inicializa a conexão
$database = new Database();
$db = $database->getConnection();

//Prepara a classe Categoria
$categoria = new Categoria($db);
$categoria->nome = "RPG"; //nome da categoria que queremos salvar

//Tenta criar
if($categoria->criar()){
    echo "Categoria criada com sucesso!";
}else{
    echo "Erro ao criar categroria.";
}

?>
