<?php 

session_start();



include 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$password = hash("md5", $password);


$user = get_user_by_email($email);



if (!empty($user)) {

	set_flash_message('danger', 'Такой пользователь уже есть в базе.');
	redirect('page_register.php');
	exit;
}




add_user($email, $password);


set_flash_message('success', 'Регистрация прошла успешно.');
redirect('page_login.php');
exit;
	
?>