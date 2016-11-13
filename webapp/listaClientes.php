<?php
$clientDao = new ClientDAO();

if(isset($_POST['pesquisar']) && $_POST['pesquisar'] === 'Pesquisar'){
    $array=$clientDao->selectAllClients($_POST['tipoPesquisa'],$_POST['pesquisa']);

}else{
    $array=$clientDao->selectAllClients('','');
}

foreach($array as $x => $client) {       ?>

         <tr>
            <td><?php echo $client->getId()?></a></td>
            <td><?php echo $client->getName()?></td>
            <td><?php echo $client->getContact()?></td>
            <td><?php echo $client->getLocal()?></td>
            <td><?php echo $client->getEmail()?></td>
        </tr>
<?php
}
?>




