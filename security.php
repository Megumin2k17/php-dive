<?php 

session_start();
include 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$user_id = $_GET['id'];

if($password !== $confirm_password) {
	set_flash_message('danger', 'Пароли не совпадают.');
	redirect("page_security.php?id=$user_id");
	exit;
} 

$user = get_user_by_email($email); 

if($user && $user!==$active_user) {
	set_flash_message('danger', 'Этот эмейл уже занят.');
	redirect("page_security.php?id=$user_id");
	exit;
}

edit_creadentials($user_id, $email, $password);

set_flash_message('success', 'Данные были успешно обновлены.');
redirect('users.php');
exit;

?>