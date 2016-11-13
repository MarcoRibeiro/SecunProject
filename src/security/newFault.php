<?php

include ('../DAO/connectDAO.php');
include('../DAO/FaultDAO.php');
include('../DAO/EquipmentDAO.php');
include('../DAO/ClienteDAO.php');
include ('../classes/Fault.php');
include ('../classes/Equipment.php');
include ('../classes/Client.php');


$faultDao = new FaultDAO();
$EquipmentDAO = new EquipmentDAO();
$ClientDAO = new ClientDAO();
$dateOut = "";
$dateIn =  date("Y-m-d") ;
$estado = 0;
$obj = "";
$idClient;
$idEquip = "";
$orcamento = 0;
$userID;
$resultado =  array();


if($_POST['novoCliente'] && $_POST['novoCliente'] == 'yes'){
    $name = $_POST['name'];
    $contact = $_POST['contacto'];
    $local = $_POST['morada'];
    $email = $_POST['email'];
    $client = new Client(null,  $name, $contact, $email, $local);
    $idClient = $ClientDAO->insertClient($client);
}else if($_POST['idClient']){
    $idClient = $_POST['idClient'];
}

if($_POST['novoEquipamento'] && $_POST['novoEquipamento'] == 'yes'){
    $modelo = $_POST['Modelo'];
    $emei = $_POST['EMEI'];
    $objEquip = $_POST['objEquip'];
    $eqp = new Equipment(null, $modelo, $emei, $objEquip,$idClient);
    $idEquip = $EquipmentDAO->insertEquipment($eqp);
}else if($_POST['idEquip']){
    $idEquip = $_POST['idEquip'];
}


if($_POST['predictionDate']){
    $predictionDate = $_POST['predictionDate'];
}
/*if($_POST['dateIn']){
    $dateIn = $_POST['dateIn'];
}*/
if($_POST['estado']){
    $estado = $_POST['estado'];
}
if($_POST['obj']){
    $obj = $_POST['obj'];
}

if($_POST['orcamento']){
    $orcamento = $_POST['orcamento'];
}
if($_POST['userID']){
    $userID = $_POST['userID'];
}


$fault = new Fault(null, $idEquip, $estado, $userID, $dateIn, null, $orcamento, $obj, $idClient, $predictionDate );
$numDoc = $faultDao->insertFault($fault);

if($numDoc != 0){

    $eq = $EquipmentDAO->selectEquipment($idEquip);
    $client = $ClientDAO->selectClient($idClient);

    $resultado['modeloEqui'] = $eq->getModel();
    $resultado['estado'] = $estado;
    $resultado['clientName'] = $client->getName();
    $resultado['clientContact'] = $client->getContact();
    $resultado['dateIn'] = $dateIn;
    $resultado['predictionDate'] = $predictionDate;
    $resultado['orcamento'] = $orcamento;
    $resultado['obj'] = $obj;
    $resultado['numDoc'] = $numDoc;
    $resultado['status'] = true;

}else{
    $resultado['status'] = false;
}

header('Content-type: application/json');

echo json_encode($resultado);

########################################################## pdf gerado ###############################################


?>