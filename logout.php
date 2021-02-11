<?php 
session_start();
include 'functions.php';
$user_id = $_GET['id'];

logout();

set_flash_message('warning', 'Вы были разлогинены.');
redirect('page_login.php');
exit;

?>