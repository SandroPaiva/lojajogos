<?php

class Pedido{
    private PDO $conn;

    public function __construct(PDO $db){
        $this->conn = $db;
    }

    //Método seguro contra concorrencia para finalizar a compra de 1 item
    public function finalizarCompraSimples(int $usuario_id, int $jogo_id, int $quantidade_comprada): bool{
        try{
            //1. Inicia a Transação (Desliga o Salvamento Automático do MySql)
            $this->conn->beginTransaction();

            //2. Trava a linha deste jogo para leitura de outros processos até o fim da transação
            $query_estoque = "SELECT estoque, preco FROM jogos WHERE id = :jogo_id FOR UPDATE";
            $stmt_estoque = $this->conn->prepare($query_estoque);
            $stmt_estoque->bindParam(':jogo_id', $jogo_id);
            $stmt_estoque->execute();

            //PDO::FETCH_ASSOC retorna um array indexado pelo nome da coluna
            $jogo = $stmt_estoque->fetch(PDO::FETCH_ASSOC);

            //3. Valida o estoque atual
            if($jogo['estoque'] < $quantidade_comprada){
                //Se não tem estoque, "joga" um erro para cair no catch
                throw new Exception("Estoque insuficiente para a compra.");
            }

            //4. Deduz o estoque com segurança
            $query_baixa = "UPDATE jogos SET estoque = estoque - :qtd WHERE id = :jogo_id";
            $stmt_baixa = $this->conn->prepare($query_baixa);
            $stmt_baixa->bindParam(':qtd', $quantidade_comprada);
            $stmt_baixa->bindParam(':jogo_id', $jogo_id);
            $stmt_baixa->execute();

            //5. Registra o Pedido Financeiro
            $total = $jogo['preco'] * $quantidade_comprada;
            $query_pedido = "INSERT INTO pedidos (usuario_id, total) VALUES (:usr, :tot)";
            $stmt_pedido = $this->conn->prepare($query_pedido);
            $stmt_pedido->bindParam(':usr', $usuario_id);
            $stmt_pedido->bindParam(':tot', $total);
            $stmt_pedido->execute();

            //6. Se tudo deu certo até aqui, nós "Comitamos" (salvamos definitivamente)
            $this->conn->commit();
            return true;

        }catch (Exception $e){
            //7. Se algo der errado (falta de estoque, erro de sintaxe, etc), o RollBack desfaz tudo!
            $this->conn->rollBack();
            error_log("Falha na compra: " . $e->getMessage());
            return false;
        }
    }


}


?>