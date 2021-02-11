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

if (empty($email) || empty($password)) {
	set_flash_message('danger', 'Поля email и пароль должны быть заполнены.');
	redirect('page_create_user.php');
	exit;
}

$user_id = add_user($email, $password);
set_flash_message('success', 'Новый профиль был успешно создан.');

edit_user_info($user_id, $name, $job, $phone, $address);

set_status($user_id, $status);


$avatars_storage = "avatars/";
$avatar_path = $avatars_storage . create_uniq_file_name($avatar["name"]);

if(!is_image($avatar_path)) {
	
	set_flash_message('danger', 'Аватар не был добавлен, т.к. файл должен быть картинкой.');
	
	redirect('users.php');
	exit;
}

upload_image($avatar, $avatar_path);

add_avatar($user_id, $avatar_path);

add_social_links($user_id, $vk, $telagram, $instagram);

set_flash_message('success', 'Данные пользователя были успешно добавлены.');
redirect('users.php');
exit;


?>