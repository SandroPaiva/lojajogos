<?php
class Categoria {
    private $conn;
    private $tabela = "categorias";

    // Propriedades da categoria
    public $id;
    public $nome;
    public $criado_em;

    // Construtor recebe a conexão com o banco
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para criar uma nova categoria
    public function criar() {
        // 1. A query SQL com um "placeholder" (:nome) em vez do dado real
        $query = "INSERT INTO " . $this->tabela . " SET nome = :nome";

        // 2. Prepara a declaração (o banco de dados compila a query sem os dados)
        $stmt = $this->conn->prepare($query);

        // 3. Sanitização: limpa tags HTML ou scripts maliciosos (XSS)
        $this->nome = strip_tags($this->nome);

        // 4. Faz o bind (liga) o valor real ao placeholder com segurança
        $stmt->bindParam(":nome", $this->nome);

        // 5. Executa a query
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>