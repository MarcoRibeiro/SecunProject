<?php
$FaultDAO = new FaultDAO();
$EstadoDAO = new EstadoDAO();
$EquipmentDAO = new EquipmentDAO();


if(isset($_POST['pesquisar']) && $_POST['pesquisar'] === 'PesquisarAvaria'){
    $array=$FaultDAO->selectAllFaults($_POST['tipoPesquisa'],$_POST['pesquisa']);

}else if(isset($_GET['id'])){
    $array=$FaultDAO->selectAllFaults('ClientId',$_GET['id']);
} else {
    $array=$FaultDAO->selectAllFaults('','');
}

foreach($array as $x => $FaultDAO) {       ?>

         <tr>
            <td><?php echo $FaultDAO->getId()?></td>
         	<td><a href='faults.php?id=<?php echo $FaultDAO->getId() ?>'><?php echo $EquipmentDAO->selectEquipment($FaultDAO->getEquipmentID())->getModel()?></a></td>
            <td><?php echo $FaultDAO->getDateIn()?></td>
            <td><?php echo $FaultDAO->getDateOut()?></td>
            <td>€ <?php echo $FaultDAO->getValues()?></td>

            <td class="alert <?php echo $EstadoDAO->selectEstado($FaultDAO->getStatusID())->getClass()?>" >
            	<strong>
            		<?php echo $EstadoDAO->selectEstado($FaultDAO->getStatusID())->getDescricao()?>
            	</strong>
            </td>
        </tr>

<?php
}
?>

