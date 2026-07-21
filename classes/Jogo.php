<?php
class Jogo {
    private $conn;
    private $tabela = "jogos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para ler os jogos e trazer o nome da categoria
    public function listarTodos() {
        $query = "SELECT 
                    j.id, 
                    j.titulo, 
                    j.preco, 
                    c.nome AS categoria, 
                    f.nome AS fabricante 
                FROM jogos j
                INNER JOIN categorias c ON j.categoria_id = c.id
                INNER JOIN fabricantes f ON j.fabricante_id = f.id";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Retorna todos os resultados como um array associativo
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results === false ? [] : $results;
    }
}
?>