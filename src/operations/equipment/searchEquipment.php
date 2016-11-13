<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/EquipmentDAO.php');
include ('../../classes/Equipment.php');

$search = strip_tags(trim($_GET['q']));

$equipmentDao = new EquipmentDAO();
$array=$equipmentDao->selectAllEquipment('Emei', $search);

$MyObjects = array();

header('Content-type: application/json');

foreach($array as $x => $equipment) {
	$MyObjects[] = $equipment;
}

echo json_encode($MyObjects);

?>