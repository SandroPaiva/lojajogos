<?php
class Carrinho {
    private $conn;
    private $tabela = "carrinho";

    public $usuario_id;
    public $jogo_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para adicionar ao carrinho com lógica de "Upsert"
    public function adicionar() {
        // INSERT ... ON DUPLICATE KEY UPDATE: Se tentar inserir o mesmo jogo para o mesmo usuário,
        // em vez de dar erro, ele apenas soma 1 na quantidade existente.
        $query = "INSERT INTO " . $this->tabela . " (usuario_id, jogo_id, quantidade) 
                  VALUES (:usuario_id, :jogo_id, 1) 
                  ON DUPLICATE KEY UPDATE quantidade = quantidade + 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":jogo_id", $this->jogo_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>