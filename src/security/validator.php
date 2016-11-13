
<?php
include('../DAO/connectDAO.php');
include('../DAO/UserDAO.php');
include('../classes/User.php');

$userDAO = new UserDAO();
if($_POST['username']){
    $userName = $_POST['username'];
}

if($_POST['password']){
    $passWord = $_POST['password'];
}

if($user = $userDAO->verifyClient($userName,$passWord)){
    if (!isset($_SESSION))
        session_start();

    $_SESSION['User'] = $user;

    header("Location: ../painel.php");
}


?>