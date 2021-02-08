<?php 

session_start();
include 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$password = hash("md5", $_POST['password']);
$rememberme = $_POST['rememberme'];

// var_dump( $_POST); die;

$user = get_user_by_email($email);

if(empty($user)) {
	set_flash_message('danger', 'Такого пользователя не существует.');
	redirect('page_login.php');
	exit;
}

$auth = auth($email, $password);

if(!$auth) {
	set_flash_message('danger', 'Введен неверный эмэйл или пароль.');
	redirect('page_login.php');
	exit;
}

if($rememberme) {
	setcookie('email', $email);
}else{
	setcookie('email', '', -1);
}


set_flash_message('success', 'Вы были успешно авторизованы!');
redirect('users.php');
exit;

?>