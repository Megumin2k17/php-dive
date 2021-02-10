<?php 

session_start();
include 'functions.php';

$status = $_POST['status'];

$user_id = $_GET['id'];

set_status($user_id, $status);

set_flash_message('success', 'Статус был успешно обновлены.');
redirect('users.php');
exit;

?>