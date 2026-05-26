<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, DELETE, POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/bebida.php';

// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Bebida
$bebida = new Bebida($db);

$method = $_SERVER['REQUEST_METHOD'];

if (in_array($method, array('GET', 'DELETE', 'POST'), true)) {
    try {
        $id = null;
        $camposId = array('id', 'idBebida');

        foreach (array($_GET, $_POST) as $params) {
            foreach ($camposId as $campo) {
                if (isset($params[$campo]) && trim((string) $params[$campo]) !== '') {
                    $id = trim((string) $params[$campo]);
                    break 2;
                }
            }
        }

        if ($id === null) {
            $raw = file_get_contents('php://input');
            if (!empty($raw)) {
                $data = json_decode($raw);
                if (is_object($data)) {
                    foreach ($camposId as $campo) {
                        if (isset($data->$campo) && trim((string) $data->$campo) !== '') {
                            $id = trim((string) $data->$campo);
                            break;
                        }
                    }
                }
                if ($id === null) {
                    parse_str($raw, $parsed);
                    foreach ($camposId as $campo) {
                        if (isset($parsed[$campo]) && trim((string) $parsed[$campo]) !== '') {
                            $id = trim((string) $parsed[$campo]);
                            break;
                        }
                    }
                }
            }
        }

        if ($id !== null) {
            $bebida->idBebida = $id;

            if ($bebida->delete()) {
                header('HTTP/1.1 200 OK');
                echo json_encode(
                    array('Mensagem' => 'Bebida Excluida com Sucesso')
                );
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel excluir a Bebida')
                );
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(
                array(
                    'erro' => 'Falta parametro',
                    'Mensagem' => 'Informe a bebida (parametro id necessário)'
                )
            );
        }
    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('erro' => $e->getMessage()));
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(array('erro' => 'Metodo nao suportado!'));
}
