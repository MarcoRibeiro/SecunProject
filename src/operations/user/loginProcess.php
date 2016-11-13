<?php
session_start();
include ('../../DAO/connectDAO.php');
include('../../DAO/UserDAO.php');
include('../../classes/User.php');

if(isset($_POST['btn-login'])){
	$user = trim($_POST['Username']);
  	$user_password = trim($_POST['Password']);

  	$userDao = new UserDAO();
	$user = $userDao->verifyUser($user,$user_password);

	if ( $user ) {
		$_SESSION['name'] = $user->getName();
		$_SESSION['id'] = $user->getId();
		$_SESSION['userName'] = $user->getUserName();
		echo 'ok';
	} else {
		echo "Nome do utilizador e/ou password errada!";
	}

}else{
	echo 'Erro';
}

?>