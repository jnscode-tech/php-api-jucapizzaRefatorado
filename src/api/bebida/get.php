<?php
//CRIAÇÃO ROTA GET.PHP
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Bebida.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$bebida = new Bebida($db);
 
$bebida->idBebida = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($bebida->idBebida) {
        // Busca a bebida
        $bebida->get();

        if ($bebida->nome) { // Verifica se a bebida foi encontrada 
 
        // Cria o array de resposta
        $bebida_arr = array(
            "idBebida" => $bebida->idBebida,
            "nome" => $bebida->nome,
            "tamanho" => $bebida->tamanho,
            "valor" => $bebida->valor,
            "categoria" => $bebida->categoria
        );
 
        // Converte para JSON e envia a resposta
        // `JSON_PRETTY_PRINT` é opcional, mas deixa o JSON mais legível
        echo json_encode($bebida_arr,128);
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
    





 

