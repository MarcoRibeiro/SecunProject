<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/StockDAO.php');


$stockDao = new StockDAO();
$resultado['status'] = $stockDao->deleteStock($_POST['id']);

header('Content-type: application/json');

echo json_encode($resultado);

?>