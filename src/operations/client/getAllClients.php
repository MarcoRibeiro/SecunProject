<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/ClienteDAO.php');
include ('../../classes/Client.php');


$clientDao = new ClientDAO();
$array=$clientDao->selectAllClients('','');

header('Content-type: application/json');

echo json_encode($array);

?>