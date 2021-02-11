<?php 

session_start();
include 'functions.php';

$avatar = $_FILES["avatar"];
$status = $_FILES["status"];

$user_id = $_GET['id'];
$user = get_user_by_id($user_id);


$avatars_storage = "avatars/";
$avatar_path = $avatars_storage . create_uniq_file_name($avatar["name"]);

if(!is_image($avatar_path)) {

	set_flash_message('danger', 'Файл должен быть картинкой.');
	redirect("page_media.php?id=$user_id");
	exit;
}

if(isset($user['avatar'])) {
	delete_user_avatar($user_id);
}

upload_image($avatar, $avatar_path);

add_avatar($user_id, $avatar_path);

set_flash_message('success', 'Данные были успешно обновлены.');
redirect('users.php');
exit;

?>