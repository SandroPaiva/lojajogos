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
    // Método para autenticar o usuário
    public function login($email_digitado, $senha_digitada) {
        // 1. Buscamos o usuário no banco APENAS pelo email
        $query = "SELECT id, nome, senha, papel FROM " . $this->tabela . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $email_digitado = strip_tags($email_digitado);
        $stmt->bindParam(':email', $email_digitado);
        $stmt->execute();

        // 2. Verifica se encontrou algum usuário com esse email
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hash_salvo = $row['senha'];

            // 3. A mágica da segurança: o PHP compara a senha digitada em texto puro com o hash complexo do banco
            if(password_verify($senha_digitada, $hash_salvo)) {
                // Login bem-sucedido! (Preenchemos o objeto com os dados do banco)
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                $this->papel = $row['papel'];
                return true;
            }
        }
        
        // Retorna falso se o email não existir OU se a senha estiver errada
        return false;
    }
}
?>