<?php
class Usuario {
    private $conn;
    private $tabela = "usuarios";

    public $nome;
    public $email;
    public $senha;
    public $papel = 'cliente'; // Valor padrão

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->tabela . " SET nome = :nome, email = :email, senha = :senha, papel = :papel";
        $stmt = $this->conn->prepare($query);

        // Sanitização de entradas comuns
        $this->nome = strip_tags($this->nome);
        $this->email = strip_tags($this->email);
        
        // AVISO DE SEGURANÇA: NUNCA usamos strip_tags na senha! 
        // O usuário pode legitimamente usar "<" ou ">" na senha dele.
        
        // Geração do Hash Forte
        $senha_hash = password_hash($this->senha, PASSWORD_DEFAULT);

        // Bind dos valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $senha_hash); // Salvamos o hash, não a senha bruta!
        $stmt->bindParam(":papel", $this->papel);

        try {
            if($stmt->execute()) {
                return true;
            }
        } catch(PDOException $e) {
            error_log("Erro ao registrar usuário: " . $e->getMessage());
        }
        return false;
    }
}
?>