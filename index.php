<?php
require_once 'config/Database.php';
require_once 'classes/Jogo.php';

$database = new Database();
$db = $database->getConnection();

$jogo = new Jogo($db);
$resultado = $jogo->listar();

echo "<h2>Catálogo de Jogos</h2>";

// Verifica se existem jogos cadastrados
if($resultado->rowCount() > 0) {
    // fetch(PDO::FETCH_ASSOC) transforma a linha do banco em um array associativo
    while($linha = $resultado->fetch(PDO::FETCH_ASSOC)) {
        // Formatação do preço para o padrão brasileiro
        $preco_formatado = number_format($linha['preco'], 2, ',', '.');
        
        echo "<p>";
        echo "<strong>{$linha['titulo']}</strong><br>";
        echo "Categoria: {$linha['categoria_nome']} | Preço: R$ {$preco_formatado}";
        echo "</p><hr>";
    }
} else {
    echo "Nenhum jogo encontrado no catálogo.";
}
?>