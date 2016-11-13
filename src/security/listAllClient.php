<?php


$clientDao = new ClientDAO();



$array=$clientDao->selectAllClients('','');

foreach($array as $x => $client) {
?>



    <h3 class="lista"><?php echo $client->getName()?></h3>
    <div>
        <p>Contacto:<?php echo $client->getContact()?></p>
        <p>Morada:<?php echo $client->getLocal()?></p>
        <p>Email:<?php echo $client->getEmail()?></p>

    </div>

<?php }?>

