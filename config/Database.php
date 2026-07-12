<?php

class Database{
    //Criação das variáveis de conexão com o banco de dados lojajogos como privados para somente seja acessado de forma local e não global
    private $host = "localhost";
    private $db_name = "lojajogos";
    private $username = "loja_user";
    private $password = "SenhaForte123!";

    public $conn;

    public function getConnection () {
        $this->conn = null;

        try{
            // DSN (Data Source Name) com charset utf8mb4 forçado na conexão para que o PHP e o MySQL conversem na mesma lingua, e armazenando o host e o nome do banco na variável $dsn
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);

            //Configurações de segurança e comportamento do PDO

            //Permite que o PDO lance uma exceção do tipo PDOException sempre que um comando SQL falhar e impede o fluxo contínuo de um script que falhou, o que evita que o código execute ações perigosas com dados corrompidos.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Faz o PHP trazer as informçoes da tabela apenas como uma matriz associativa usando os nomes das colunas, impedindo que o PHP traga ps dados duplicados por padrão economizando memória e erros logicos principalmente em APIs publicas.
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            //fará o uso nativo do Prepared Statements do banco e evita o SQL Injection. o parâmetro 'false' faz com que o banco trate os dados enviados pelo usuário como simples textos ignorando códigos maliciosos
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch(PDOException $exception){
            //Em caso de erro exibe uma mensagem genérica ao usuário 'echo' e registra o erro literal no log do servidor 'error_log'.
            error_log("Erro de conexão PDO: " . $exception->getMessage());
            echo "Erro interno: Não foi possivel conectar ao banco de dados.Tente novamente mais tarde";
            exit;
        }

        return $this->conn;

    }


    }

?>