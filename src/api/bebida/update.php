 
<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../config/Database.php';
include_once '../../models/bebida.php';
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Bebida
$bebida = new Bebida($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Aceitar id ou idBebida no JSON
        $idBebida = null;
        if (is_object($data)) {
            if (!empty($data->idBebida)) {
                $idBebida = $data->idBebida;
            } elseif (!empty($data->id)) {
                $idBebida = $data->id;
            }
        }
 
        // Verificar se os dados não estão vazios e se o ID foi fornecido
        if (
            is_object($data) &&
            !empty($idBebida) &&
            !empty($data->nome) &&
            !empty($data->tamanho) &&
            !empty($data->valor) &&
            !empty($data->categoria)
        ) {
            // Atribuir o ID para atualização
            $bebida->idBebida = $idBebida;
 
            // Atribuir os demais valores
            $bebida->nome = $data->nome;
            $bebida->tamanho = $data->tamanho;
            $bebida->valor = $data->valor;
            $bebida->categoria = $data->categoria;
 
            // Tentar atualizar a bebida
            if ($bebida->update()) {
               // http_response_code(200);
                header("http/1.1 200 OK");

                echo json_encode(
                    array('Mensagem' => 'Bebida Atualizada com Sucesso')
                );
            } else {
                header("http/1.1 500 Bad Request");
               // http_response_code(500);
                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel atualizar a Bebida')
                );
            }
        } else {
            header("http/1.1 400 Bad Request");
           // http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel atualizar a Bebida.')
            );
        }
    } catch (Exception $e) {
        header("http/1.1 500 Bad Request");
       // http_response_code(500);
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    header("http/1.1 405 Method Not Allowed");
   // http_response_code(405);
    echo json_encode(array("erro" => "Método não suportado!"));
}