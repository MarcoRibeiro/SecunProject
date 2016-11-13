<?php

include ('../../DAO/connectDAO.php');
include('../../DAO/StockDAO.php');
include ('../../classes/Stock.php');


$stockDao = new StockDAO();
$array=$stockDao->selectAllStock('','');

header('Content-type: application/json');

echo json_encode($array);

?>