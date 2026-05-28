<?php
namespace JulianaNsantos38\PhpApiJucapizzaRefatorado\Config;

use PDO;
use PDOException;
use Throwable;

class Database {
    private $host = "localhost";
     private $db_name = "jucapizzasdb";
     private $username = "root";
    private $password = "usbw";
    private $port ="3310";

    ///EM CASA
    //private $host = "127.0.0.1"; // <-- Mudei aqui para testar o TCP/IP
   // private $db_name = "Pizzaria";
   // private $username = "root";
  //  private $password = ""; // <-- Confirme se é exatamente a mesma do phpMyAdmin
   // private $port = "3306";


    public $conn;

    public function getConnection() {

    $this -> conn = null;

    try {
     // tenta executar um código potencialmente periogoso
     //DNS (Data Source Name) - String de conexão
     $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ';charset=utf8mb4';

        // Instancia o objeto PDO (PHP Data Objects) para estabelecer a conexão com o banco de dados - Usuario e Senha
        $this->conn = new PDO($dsn, $this->username, $this->password);
        
        //Define o modo de erro do PDO para exceção
        //Isso faz com que o PDO lance exceções em caso de erros, facilitando o tratamento
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


         } catch(PDOException $e) {

        //Php Data Obj= PDO
        // código a ser executado se ocorrer um erro
        //Em caso de erro na conxeão, a mensagem de erro é exibida
        echo "Connection error: " . $e->getMessage();
    }catch(PDOException $e) {
        echo "Erro Conexao: " . $e->getMessage();
    }
    catch(Throwable $e) {
        echo "Erro genérico: " . $e->getMessage();
    }
    
    
      return $this->conn;
}
}