<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Acess-Control-Allow-Methods: FET, POST, PUT, DELETE, OPTTIONS");
 
echo json_encode(array("Mensagem" =>"Hello, Bem vindos à Juca Pizzas!"));
 
 
 
 