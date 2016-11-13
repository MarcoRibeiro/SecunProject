<?php
$equipamentDao = new EquipmentDAO();

if(isset($_GET['id'])){
    $array=$equipamentDao->selectAllEquipment('ClientId',$_GET['id']);
}else{
    $array=$equipamentDao->selectAllEquipment('','');
}

foreach($array as $x => $equipament) {       ?>
    <tr>
    	 <td><?php echo $equipament->getEmei()?></td>
        <td><a href='equipment.php?id=<?php echo $equipament->getId() ?>'><?php echo $equipament->getModel()?></a></td>
        <td><?php echo $equipament->getObj()?></td>

    </tr>

<?php
}
?>

