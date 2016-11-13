<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/FaultDAO.php');
include('../../DAO/EquipmentDAO.php');
include('../../DAO/ClienteDAO.php');
include ('../../classes/Fault.php');
include ('../../classes/Equipment.php');
include ('../../classes/Client.php');

$FaultDAO = new FaultDAO();
$ClientDAO = new ClientDAO();
$EquipmentDAO = new EquipmentDAO();

$fault = new Fault($_POST['id'], $_POST['equipmentID'], $_POST['statusID'], $_POST['userID'], $_POST['dateIn'], $_POST['dateOut'], $_POST['values'],$_POST['obj'],$_POST['clientID'],$_POST['predictionDate']);

if($FaultDAO->updateFault($fault)){
	$eq = $EquipmentDAO->selectEquipment($_POST['equipmentID']);
    $client = $ClientDAO->selectClient($_POST['clientID']);

    $resultado['modeloEqui'] = $eq->getModel();
    $resultado['estado'] = $fault->getStatusID();
    $resultado['clientName'] = $client->getName();
    $resultado['clientContact'] = $client->getContact();
    $resultado['dateIn'] = $fault->getDateIn();
    $resultado['dateOut'] = $fault->getDateOut();
    $resultado['predictionDate'] = $fault->getPrediction();
    $resultado['orcamento'] = $fault->getValues();
    $resultado['obj'] = $fault->getObj();
    $resultado['numDoc'] = $fault->getId();
    $resultado['status'] = true;

}else{
	$resultado['status'] = false;
}

header('Content-type: application/json');

echo json_encode($resultado);

?>