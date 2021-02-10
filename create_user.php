<?php

session_start();
include 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$password = hash("md5", $password);

$name = $_POST['name'];
$job = $_POST['job'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$avatar = $_FILES["avatar"];
$status = $_FILES["status"];

$vk = $_FILES["vk"];
$telegram = $_FILES["telegram"];
$instagram = $_FILES["instagram"];

if(get_user_by_email($email)) {
	set_flash_message('danger', 'Такой пользователь уже есть в базе.');
	redirect('page_create_user.php');
	exit;
}

$user_id = add_user($email, $password);

edit_user_info($user_id, $name, $job, $phone, $address);

set_status($user_id, $status);

upload_avatar($user_id, $avatar);

add_social_links($user_id, $vk, $telagram, $instagram);

set_flash_message('success', 'пользователь успешно добавлен.');
redirect('users.php');
exit;


?>