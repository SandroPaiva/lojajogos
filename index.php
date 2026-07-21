<?php 

//Arquivo necessário para conectar a página ao banco de dados.
require_once 'config/Database.php';
require_once 'classes/Categoria.php';
require_once 'classes/Usuario.php';
require_once 'classes/Carrinho.php';
require_once 'classes/Pedido.php';

//Inicializa a conexão
$database = new Database();
$db = $database->getConnection();

//Prepara a classe Categoria
$usuario = new Usuario($db);
$usuario->nome = "Admin"; //Nome do usuario
$usuario->email = "admin@lojajogos.local"; //Emai do usuario
$usuario->senha = "SenhaSegura123"; //Senha do usuario
$usuario->papel = "admin"; //papel do usuário

//Tenta criar
if($usuario->login($usuario->email, $usuario->senha)) {
    echo "Login efetuado com sucesso! Bem-vindo, {$usuario->nome}. Nível: {$usuario->papel}";
} else {
    echo "Email ou senha incorretos.";
}

//$carrinho = new Carrinho($db);
//$carrinho->usuario_id = 1; // Coloque o ID real do seu usuário Admin
//$carrinho->jogo_id = 1;    // Coloque o ID do jogo que você cadastrou na fase anterior

//if($carrinho->adicionar()) {
    //echo "Jogo adicionado ao carrinho!";
//}else{
//    echo "Algo deu errado com o carrinho!";
//}

//$pedido = new Pedido($db);
// Tenta comprar 1 unidade do jogo ID 1 para o usuário ID 1
//if($pedido->finalizarCompraSimples(1, 1, 1)) {
//    echo "Compra realizada com sucesso! Estoque deduzido.";
//} else {
//    echo "Falha ao processar a compra. Verifique os logs.";
//}

$pedido = new Pedido($db);
// Busca as compras do Admin (id 1). Garante que $historico será um array para evitar warnings ao usar count().
$historico = $pedido->listaHistorico(1);
if (!is_array($historico)) {
    $historico = [];
}

echo "<h2>Histórico de Compras</h2>";

if(count($historico) > 0){
    foreach($historico as $linha){
        echo "Pedido #" . $linha['pedido_id'] . " | Cliente: " . $linha['cliente_nome'] . " | Total: R$ " . $linha['total'] . " | Data: " . $linha['criado_em'] . "<br>";
    }
}else{
    echo "Nenhum pedido encontrado para este usuário.";
}

?>
