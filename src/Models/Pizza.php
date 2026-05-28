<?php
 
 namespace JulianaNsantos38\PhpApiJucapizzaRefatorado\Models;
 use PDO;

class Pizza {

    
    private $conn;
 
    private $tabela = "pizzas";
 
    public $idPizza;
 
    public $nome;
 
    public $ingredientes;
 
    public $valor;
 
    public function __construct($db) {
        $this->conn = $db;
    }
 
    public function getall() {
        $query = "SELECT idPizza, nome, ingredientes, valor FROM " . $this->tabela;
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->execute();
 
        return $stmt;
    }
 
    public function get() {
        $query = 'SELECT idPizza, nome, ingredientes, valor FROM '
            . $this->tabela . ' WHERE idPizza = ? LIMIT 1';
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->bindParam(1, $this->idPizza);
 
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        if ($row) {
            $this->nome = $row['nome'];
            $this->ingredientes = $row['ingredientes'];
            $this->valor = $row['valor'];
        }
    }
 
    public function add() {
        $query = 'INSERT INTO ' . $this->tabela
            . ' SET nome=:nome, ingredientes=:ingredientes, valor=:valor';
 
        $stmt = $this->conn->prepare($query);
 
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
 
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':valor', $this->valor);
 
        if ($stmt->execute()) {
            return true;
        }
 
        return false;
    }
 
    public function update() {
        $query = 'UPDATE ' . $this->tabela
            . ' SET nome=:nome, ingredientes=:ingredientes, valor=:valor WHERE idPizza=:id';
 
        $stmt = $this->conn->prepare($query);
 
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->idPizza = htmlspecialchars(strip_tags($this->idPizza));
 
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':id', $this->idPizza);
 
        if ($stmt->execute()) {
            return true;
        }
 
        return false;
    }
    public function delete() {

 // Query de exclusão
 $query = 'DELETE FROM ' . $this->tabela . ' WHERE idPizza=:id';
 
 // Preparar a query
 $stmt = $this->conn->prepare($query);

 // Vincular o ID
 $stmt->bindParam(':id', $this->idPizza);

 // Executar a query
 if($stmt->execute()) {
     return true;
 }
 return false;
}
   
}
 
 
 
 
 