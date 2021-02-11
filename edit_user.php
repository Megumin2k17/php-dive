<?php 

session_start();
include 'functions.php';

$name = $_POST['name'];
$job = $_POST['job'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$user_id = $_GET['id'];
// var_dump($user_id); die;
edit_user_info($user_id, $name, $job, $phone, $address);

set_flash_message('success', 'данные были успешно отредактированы.');
redirect('users.php');
exit;

?>