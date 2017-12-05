<?php

class Banco {

    private $pdo;
    private $numeroLinhas;
    private $array; //resultado da query

    //Conexão com o BD

    public function __construct($host, $dbname, $dbuser, $dbpass) {
        try {
            $this->pdo = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $dbuser, $dbpass);
        } catch (PDOException $erro) {
            echo "Falhou: " . $erro->getMessage();
        }
    }

    public function result() {
        return $this->array;
    }

    public function numeroLinha() { // como é privado, preciso de uma função publica para pegar o valor
        return $this->numeroLinhas;
    }

    // Consulta no BD
    public function query($sql) {
        $query = $this->pdo->query($sql);
        $this->numeroLinhas = $query->rowCount(); //faz contagem de linhas que retornará a query
        $this->array = $query->fetchAll();
    }

    /*  public function insert($tabela, $data){
      if(!empty($tabela) && (is_array($data) && count($data) > 0)){ // tabela não está vazia? ou não possui dados?

      $dados = array();
      foreach ($data as $chave =>$valor){
      $dados[] = $chave. " = '".addslashes($valor)."'"; //monta a query   INSERT INTO biblioteca SET nome = 'wagner' , nome2 = 'kl' , nome3 = 'hj'
      }

      $sql = "INSERT INTO " .$tabela. " SET ";
      $sql = $sql.implode(" , ",$dados);  // concatena dados na array separando por virgulas, com a linha de cima  (...) SET nome = 'wagner' , nome2 = 'kl' , nome3 = 'hj'

      echo $sql;
      $this->pdo->query($sql) ;

      }
      } */

    public function update($tabela, $data, $where = array(), $where_cond = "and") {
        if (!empty($tabela) && (is_array($data) && count($data) > 0 ) && is_array($data)) {
            $sql = "UPDATE " . $tabela . "SET ";
            $dados = array();
            foreach ($data as $chave => $valor) {
                $dados[] = $chave . " = '" . addslashes($valor) . "'";
            }
            $sql = $sql . implode(" , ", $dados);


            if (count($where) > 0) {
                $dados = array();
                
                foreach ($where as $chave => $valor) {
                    $dados[] = $chave . " = '" . addslashes($valor) . "'";
                }
                $sql = $sql . " WHERE " . implode(" ".$where_cond." ", $dados);
            }
            echo $sql;
        }
    }

}
