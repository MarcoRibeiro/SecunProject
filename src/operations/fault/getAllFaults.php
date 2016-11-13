<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/FaultDAO.php');
include('../../DAO/EstadoDAO.php');
include('../../DAO/EquipmentDAO.php');
include ('../../classes/Fault.php');
include ('../../classes/Equipment.php');
include ('../../classes/Estado.php');

$FaultDAO = new FaultDAO();
$EstadoDAO = new EstadoDAO();
$EquipmentDAO = new EquipmentDAO();

class myObject {
    public $id;
    public $model;
    public $dateIn;
    public $dateOut;
    public $values;
    public $state;
    public $stateClass;
}

$array = $FaultDAO->selectAllFaults('','');
$MyObjects = array();

foreach($array as $x => $Fault) {
    $MyObject = new myObject;
    $MyObject->id = $Fault->getId();
 	$MyObject->model = $EquipmentDAO->selectEquipment($Fault->getEquipmentID())->getModel();
    $MyObject->dateIn = $Fault->getDateIn();
    $MyObject->dateOut = $Fault->getDateOut();
    $MyObject->values = $Fault->getValues();

    switch ($Fault->getStatusID()) {
        case 2:
            $MyObject->state = 'Em Reparação';
            $MyObject->stateClass = 'alert-warning';
            break;
        case 3:
            $MyObject->state = 'Sem Reparação';
            $MyObject->stateClass = 'alert-danger';
            break;
        case 4:
            $MyObject->state = 'Reparado';
            $MyObject->stateClass = 'alert-success';
            break;
        case 5:
            $MyObject->state = 'Entregue';
            $MyObject->stateClass = 'alert-success';
            break;
        default:
            $MyObject->state = 'Em Analise';
            $MyObject->stateClass = 'alert-info';
            break;
    }

    $MyObjects[] = $MyObject;
}

header('Content-type: application/json');

echo json_encode($MyObjects);

?>
