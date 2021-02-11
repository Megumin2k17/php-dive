<?php 

const IS_ADMIN = "2";
const IS_CASUAL = "0";
$active_user = $_SESSION['user'];

function show_avatar($user_id) {

	$avatar = get_user_avatar($user_id);

	if(!isset($avatar) || !file_exists($avatar)) {
		echo "img/demo/avatars/avatar-m.png";
	} else {
		echo $avatar;
	}
}

function get_user_avatar($user_id) {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "SELECT avatar FROM users WHERE id=:id";
	$statement = $db->prepare($query);
	$statement->execute(['id'=> $user_id]);
	return $result = $statement->fetchColumn();
}

function show_status($status) {
	if($status==="Онлайн") {
		echo "status status-success mr-3";
	} elseif($status === "Отошел") {
		echo "status status-warning mr-3";
	} elseif ($status === "Не беспокоить") {
		echo "status status-danger mr-3";
	} else {
		echo "status status-danger mr-3";
	}
}

function edit_creadentials($user_id, $email, $password) {
	
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "UPDATE users SET email=:email, password=:password, WHERE id=:id";

	$statement = $db->prepare($query);
	$statement->execute(['email' => $email, 'password' => $password, 'id'=>$user_id]);
}

function is_admin($active_user) {
	return $active_user['role'] === IS_ADMIN;
}
function is_author($active_user_id, $edit_user_id) {
	return $active_user_id === $edit_user_id;
}


function add_user($email, $password) {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "INSERT INTO users (email, password) VALUES (:email, :password)";

	$statement = $db->prepare($query);
	$statement->execute(['email' => $email, 'password' => $password]);
	return $db->lastInsertId();
}

function edit_user_info($user_id, $name, $job, $phone, $address) {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "UPDATE users SET name=:name, job=:job, phone=:phone, address=:address WHERE id=:id";

	$statement = $db->prepare($query);
	$statement->execute(['name' => $name, 'job' => $job, 'phone' => $phone, 'address' => $address, 'id'=>$user_id]);
}

function set_status($user_id, $status) {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "UPDATE users SET status=:status WHERE id=:id";

	$statement = $db->prepare($query);
	$statement->execute(['status' => $status, 'id'=>$user_id]);
}

function str_random() {
	return md5(uniqid());
}

function create_uniq_file_name($filename) {

	$demo = explode('.', $filename);
	return $uniq_file_name = str_random() . '.' . array_pop($demo);
}


function delete_user_avatar($user_id) {
	
	$avatar = get_user_avatar($user_id);
	
	if (isset($avatar) && file_exists($avatar)) {		
		unlink($avatar);
	}

	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");
	$query = "UPDATE users SET avatar=NULL WHERE id=:id";
	$statement = $db->prepare($query);
	$statement->execute(['id'=> $user_id]);
}

function is_image($target_file) {
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	return $imageFileType === 'jpg' || $imageFileType ==='png';
}


function upload_image($image, $path) {
	
	move_uploaded_file($image["tmp_name"], $path);
	
}

function add_avatar($user_id, $avatar_path) {

	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "UPDATE users SET avatar=:avatar WHERE id=:id";
	
	$statement = $db->prepare($query);
	$statement->execute(['avatar' => $avatar_path, 'id'=> $user_id]);
}

function add_social_links($user_id, $vk, $telagram, $instagram) {

	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "UPDATE users SET vk=:vk, telegram=:telegram, instagram=:instagram WHERE id=:id";

	$statement = $db->prepare($query);
	$statement->execute(['vk' => $vk, 'telegram' => $telegram, 'instagram' => $instagram, 'id'=> $user_id]);
}

function get_user_by_email($email) {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "SELECT * FROM users WHERE email=:email";

	$statement = $db->prepare($query);
	$statement->execute(['email'=> $email]);
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	return $user;
} 

function get_user_by_id($id) {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "SELECT * FROM users WHERE id=:id";

	$statement = $db->prepare($query);
	$statement->execute(['id'=> $id]);
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	return $user;
}

function set_flash_message($name, $message) {
	if(!isset($_SESSION['messages'])) {
		$_SESSION['messages']=[];
	}

	$_SESSION['messages'] += [$name => $message];
}

// function display_flash_message($name) {	
// 	echo "<div class='alert alert-" . $name . " text-dark' role='alert'>" . $_SESSION['message'][$name] . "</div>";
// 	unset($_SESSION['message'][$name]);
// }

function display_flash_messages() {	
	foreach ($_SESSION['messages'] as $name => $message) {
		echo "<div class='alert alert-" . $name . " text-dark' role='alert'>" . $_SESSION['messages'][$name] . "</div>";		
	}
	unset($_SESSION['messages']);
}


function redirect($path) {
	header("location: $path");
}

function auth($email, $password) {
	$user = get_user_by_email($email);
	if($user['password'] === $password) {

		$_SESSION['user'] = $user;
		return true;
	}		
	return false;
}

function get_all_users() {
	$db = new PDO("mysql:host=localhost; dbname=dive_project", "mad", "");

	$query = "SELECT * FROM users";

	$statement = $db->prepare($query);
	$statement->execute();
	$users = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $users;
}

?>