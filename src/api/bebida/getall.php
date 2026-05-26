<?php
// CRIAR ROTA GETALL BEBIDA
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
 
// try{ colocar para demonstrar erro com coluna errada mas lá no método read em pizza
    // Chamar o método read() para buscar as pizzas
if($_SERVER['REQUEST_METHOD']=='GET'){
    
    $stmt = $bebida->getall();
    $num = $stmt->rowCount();
 
    // Verificar se mais de 0 registros foram encontrados
    if ($num > 0) {
        // Array de pizzas
        $bebidas_arr = array();
 
        // Percorrer o resultado da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // A função extract transforma $row['nome'] em apenas $nome
            extract($row);

            // Um array que representará um assoc com um elemento (cada bebida)
            $bebida_item = array(
                "id" => $idBebida,
                "nome" => $nome,
                "tamanho" => $tamanho,
                "valor" => $valor,
                "categoria" => $categoria
            );
 
            array_push($bebidas_arr, $bebida_item); //formato assoc
        }
 
        // Definir o código de resposta como 200 OK
       // http_response_code(200);
       header("http/1.1 200 OK");
 
        // Mostrar os dados das bebidas em formato JSON
        echo json_encode($bebidas_arr);
    } else {
        // Se nenhuma bebida for encontrada, definir o código de resposta como 404 Not Found
        http_response_code(404);
 
        // Informar ao usuário que nenhuma bebida foi encontrada
        echo json_encode(
            array("message" => "Nenhuma pizza encontrada.")
        );
    }
}else{
    //http_response_code(405); // Método não permitido
    header("http/1.1 200 OK");
    echo json_encode(
        array("Mensagem" => "Método não permitido.")
    );
}
// }
// catch (Exception $e) {
//  echo json_encode(array("erro" => $e->getMessage()));
// }
 