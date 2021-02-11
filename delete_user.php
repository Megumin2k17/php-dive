<?php 
session_start();
include 'functions.php';
$user_id = $_GET['id'];

$user = get_user_by_id($user_id);
$username = $user['name'];

delete_user_avatar($user_id);
delete_user($user_id);


if(is_author($active_user['id'], $user_id)) {

	logout();

	set_flash_message('warning', 'Ваш аккаунт был удалён.');
	redirect('page_register.php');
	exit;

}

set_flash_message('warning', "Пользователь $username был удалён.");
redirect('users.php');
exit;


?>