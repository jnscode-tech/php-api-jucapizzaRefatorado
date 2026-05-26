<?php
//CRIAÇÃO ROTA GET.PHP
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
$pizza->idPizza = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($pizza->idPizza) {
        // Busca a pizza
        $pizza->get();

        if ($pizza->nome) {
 
        // Cria o array de resposta
        $pizza_arr = array(
            "id" => $pizza->idPizza,
            "nome" => $pizza->nome,
            "ingredientes" => $pizza->ingredientes,
            "valor" => $pizza->valor
        );
 
        echo json_encode($pizza_arr,128);
      } else {
        //http_response_code(400);
        header("http/1.1 404 Not Found");
        echo json_encode(array("Mensagem" => "Bebida não encontrada."));
          }
        } else {
   // http_response_code(405);
   header("http/1.1 400 Bad Request");
    echo json_encode(
            array("Erro" => "ID não informado.")
        );}
  
  }else {
   // http_response_code(404);
   header("http/1.1 405 Method Not Allowed");
    echo json_encode(
            array("Mensagem" => "Método não permitido.")
        );
  }
 



    //try colocar para demonstrar erro com coluna errada mas lá no método read em pizza
    //Chamar o método read() para buscar as pizzas
   //$smt = $pizza->read();
   //$num = $smt->rowCount();
   //array("message" => "Nenhuma pizza encontrada.");

//}



//Instanciar o objeto Pizza
//$pizza = new Pizza($db);

//IF ternário
//$pizza->idPizza = isset($_GET['id']) ? $_GET['id'] : null;

//IF comum
//if isset($_GET['id']) {
  //  $pizza->idPizza = $_GET['id'];
//} else {
  //  $pizza->idPizza = null;
//}