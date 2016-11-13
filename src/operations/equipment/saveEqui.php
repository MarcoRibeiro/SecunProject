<?php

include ('../DAO/connectDAO.php');
include('../DAO/EquipmentDAO.php');
include ('../classes/Equipment.php');

$EquipmentDAO = new EquipmentDAO();

$modelo = $_POST['modelo'];
$emei = $_POST['imei'];
$objEquip = $_POST['obj'];
$eqp = new Equipment(null, $modelo, $emei, $objEquip, $_POST['id']);
$idEquip = $EquipmentDAO->insertEquipment($eqp);


header('Content-type: application/json');

echo json_encode($eqp);


?>