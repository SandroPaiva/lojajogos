<?php
// 1. Requerimentos e Conexão (Setup)
require_once 'config/Database.php';
require_once 'classes/Jogo.php';

$database = new Database();
$db = $database->getConnection();

// 2. Regras de Negócio / Interação com o Model
$jogo = new Jogo($db);
$lista_jogo = $jogo->listarTodos();

if (!is_array($lista_jogo)) {
    $lista_jogo = [];
}

// 3. Chamada da View (A renderização da tela)
// O arquivo abaixo terá acesso à variável $lista_jogo criada acima
require_once 'views/lista_jogos.php';
?>