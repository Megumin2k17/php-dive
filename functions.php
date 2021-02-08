<?php 

function add_user($email, $password) {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "INSERT INTO users (email, password) VALUES (:email, :password)";

	$statement = $db->prepare($query);
	$statement->execute(['email' => $email, 'password' => $password]);
}

function get_user_by_email($email) {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "SELECT * FROM users WHERE email=:email";

	$statement = $db->prepare($query);
	$statement->execute(['email'=> $email]);
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	return $user;
} 

function set_flash_message($name, $message) {
	$_SESSION['messages'] = [$name => $message];
}

// function display_flash_message($name) {	
// 	echo "<div class='alert alert-" . $name . " text-dark' role='alert'>" . $_SESSION['message'][$name] . "</div>";
// 	unset($_SESSION['message'][$name]);
// }

function display_flash_messages() {	
	foreach ($_SESSION['messages'] as $name => $message) {
		echo "<div class='alert alert-" . $name . " text-dark' role='alert'>" . $_SESSION['messages'][$name] . "</div>";
		unset($_SESSION['messages'][$name]);
	}
}


function redirect($path) {
	header("location: $path");
}


?>