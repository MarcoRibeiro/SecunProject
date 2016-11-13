<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/StockDAO.php');
include ('../../classes/Stock.php');

$StockDAO = new StockDAO();

$stock = new Stock($_POST['id'],$_POST['equipamento'],$_POST['ocas'],$_POST['arosBrancos'],$_POST['arosPretos'],$_POST['vidrosBrancos'],$_POST['vidrosPretos'],$_POST['peliculaPolarizada'],$_POST['peliculaTemperada']);

if($StockDAO->updateStock($stock)){
    $resultado['status'] = true;
}else{
	$resultado['status'] = false;
	$resultado['msg'] = 'Preencha todos os campos';
}

header('Content-type: application/json');

echo json_encode($resultado);

?>