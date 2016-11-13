<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/ClienteDAO.php');
include ('../../classes/Client.php');

$clientDao = new ClientDAO();

$client = new Client(null, $_POST['nome'],$_POST['contacto'],$_POST['email'],$_POST['morada']);

if($clientDao->insertClient($client)){
    $resultado['status'] = true;
}else{
	$resultado['status'] = false;
	$resultado['msg'] = 'Preencha todos os campos';
}

header('Content-type: application/json');

echo json_encode($resultado);

?>