<?php
class Jogo {
    private $conn;
    private $tabela = "jogos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para ler os jogos e trazer o nome da categoria
    public function listar() {
        $query = "SELECT 
                    j.id, 
                    j.titulo, 
                    j.preco, 
                    c.nome as categoria_nome 
                  FROM " . $this->tabela . " j
                  INNER JOIN categorias c ON j.categoria_id = c.id
                  ORDER BY j.titulo ASC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
}
?>