<?php
	$data = $_POST;
	print_r($data);
	if( isset($data['auth']))
	{
	///$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
	///$pass = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
	
	$mysql = mysqli_connect('127.0.0.1', 'root','', 'baza1');
		if ($mysql == false){
		echo 'Не удалось подключиться к бд<br>';
		echo mysqli_connect_error();
		exit();
		}
	$userlogin = $_POST['login'];
	/*$userpass = password_hash($data['password1'], PASSWORD_DEFAULT);
	echo $userpass;*/
	$pwd = $_POST['password'];
	$pwd_peppered = hash_hmac("sha256", $pwd, 'enotiki');
	
	$pwd_hashed = mysqli_query($mysql, "SELECT pass FROM users WHERE login = '$userlogin'");
	$row = mysqli_fetch_row($pwd_hashed);
	print_r($row);
	if (password_verify($pwd_peppered, $row[0])) {
    echo "Password matches.";
	mysqli_close($mysql);
	header('Location: /stolovka.html');
	}
	else{
		$_POST['password'] = 'Неправильный логин или пароль';
		print_r($_POST);
		
		header('Location: /regist.php');
	}
	
	
	
	
	/*$result = mysqli_query($mysql, "SELECT * FROM users WHERE login = '$userlogin' AND pass = '$userpass' ");
	$user = mysqli_fetch_assoc($result);
	if($user == 0){
		echo 'Пользователь не найден';
		exit();
	}*/
	setcookie('user', $data[login], time() + 3600, "/");
	///echo "Пользователь вошел";
	//mysqli_close($mysql);
	///header('Location: /stolovka.html');
	
	}
?>