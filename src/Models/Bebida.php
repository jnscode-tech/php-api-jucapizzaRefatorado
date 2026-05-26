<?php
 
class Bebida
{
    private $conn;
    private $tabela = "bebidas";
 
    public $idBebida;
    public $nome;
    public $tamanho;
    public $valor;
    public $categoria;
 
    public function __construct($db) {
        $this->conn = $db;
    }
 
    public function getall() {
        $query = "SELECT idBebida, nome, tamanho, valor, categoria FROM " . $this->tabela;
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->execute();
 
        return $stmt;
    }
 
    public function get() {
        $query = 'SELECT idBebida, nome, tamanho, valor, categoria FROM '
            . $this->tabela . ' WHERE idBebida = ? LIMIT 1';
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->bindParam(1, $this->idBebida);
 
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        if ($row) {
            $this->nome = $row['nome'];
            $this->tamanho = $row['tamanho'];
            $this->valor = $row['valor'];
            $this->categoria = $row['categoria'];
        }
    }
 
    public function add() {
        $query = 'INSERT INTO ' . $this->tabela
            . ' SET nome=:nome, tamanho=:tamanho, valor=:valor, categoria=:categoria';
 
        $stmt = $this->conn->prepare($query);
 
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
 
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':tamanho', $this->tamanho);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':categoria', $this->categoria);
 
        if ($stmt->execute()) {
            return true;
        }
 
        return false;
    }
 
    public function update() {
        $query = 'UPDATE ' . $this->tabela
            . ' SET nome=:nome, tamanho=:tamanho, valor=:valor, categoria=:categoria '
            . 'WHERE idBebida=:id';
 
        $stmt = $this->conn->prepare($query);
 
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->idBebida = htmlspecialchars(strip_tags($this->idBebida));
 
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':tamanho', $this->tamanho);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':id', $this->idBebida);
 
        if ($stmt->execute()) {
            return true;
        }
 
        return false;
    }
 
    public function delete() {
        if ($this->idBebida === null || trim((string) $this->idBebida) === '') {
            return false;
        }
 
        $query = 'DELETE FROM ' . $this->tabela . ' WHERE idBebida = ?';
 
        $stmt = $this->conn->prepare($query);
 
        $this->idBebida = htmlspecialchars(strip_tags($this->idBebida));
 
        $stmt->bindParam(1, $this->idBebida);
 
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return true;
        }
 
        return false;
    }
}
 