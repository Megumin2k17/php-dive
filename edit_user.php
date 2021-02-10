<?php 

session_start();
include 'functions.php';

$name = $_POST['name'];
$job = $_POST['job'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$user_id = get_user_by_id($_GET['id']);

edit_user_info($user_id, $name, $job, $phone, $address);

set_flash_message('success', 'данные были успешно отредактированы.');
redirect('users.php');
exit;

?>