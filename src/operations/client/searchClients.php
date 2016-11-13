<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/ClienteDAO.php');
include ('../../classes/Client.php');

$clientDao = new ClientDAO();


$MyObjects = array();

if(isset($_GET['id'])){
	$search = strip_tags(trim($_GET['id']));
	$array=$clientDao->selectClient($search);
	$MyObjects[] = $array;
}else{
	$search = strip_tags(trim($_GET['q']));
	$array=$clientDao->selectAllClients('Contacto', $search);
	foreach($array as $x => $client) {
		$MyObjects[] = $client;
	}
}

header('Content-type: application/json');

echo json_encode($MyObjects);

?>