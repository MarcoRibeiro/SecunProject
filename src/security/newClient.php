<?php

if(isset($_POST['submit']) && $_POST['submit'] === 'Registar'){


 $clientDao = new ClientDAO();
if($_POST['name']){
    $name = $_POST['name'];
}




if($_POST['morada']){
    $morada = $_POST['morada'];
}
if($_POST['contact']){
    $contact = $_POST['contact'];
}
if($_POST['email']){
    $email = $_POST['email'];
}

$client = new Client(null,$name,$contact,$email,$morada);

$clientDao->insertClient($client);

}
?>