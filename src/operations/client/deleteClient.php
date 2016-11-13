<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/ClienteDAO.php');


$clientDao = new ClientDAO();
$resultado['status'] = $clientDao->deleteClient($_POST['id']);

header('Content-type: application/json');

echo json_encode($resultado);

?>