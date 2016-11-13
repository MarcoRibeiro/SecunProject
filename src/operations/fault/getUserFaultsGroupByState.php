<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/FaultDAO.php');

$FaultDAO = new FaultDAO();

if(isset($_POST['id'])){
	$array = $FaultDAO->selectClientFaultsGroupByStatus($_POST['id']);
}else{
	$array = $FaultDAO->selectClientFaultsGroupByStatus(null);
}

header('Content-type: application/json');

echo json_encode($array);

?>
