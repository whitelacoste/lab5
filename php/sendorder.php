<?php
	$data = $_POST;
	if( isset($data['send']))
	{
		mysqli_set_charset($mysql, 'utf8');
		$username=NULL;
		$disnumber=NULL;
		$number=NULL;
		if(filter_var($data['name'], FILTER_VALIDATE_REGEXP,
					array('options'=>array('regexp'=>'/[А-Яа-я]/'))))
					{
					$username = $data['name'];}
		if(filter_var($data['number'],FILTER_VALIDATE_INT, array('options'=>array('min_length'=>'6', 'max_length' =>'6'))))
		{	$disnumber = $data['number'];}
		if(filter_var($data['num'],FILTER_VALIDATE_INT, array('options'=>array('min_length'=>'10', 'max_length' =>'10'))))
		{	$number = $data['num'];}
		
		
		
		$mysql = mysqli_connect('127.0.0.1', 'root','', 'baza1');
		if ($mysql == false){
		echo 'Не удалось подключиться к бд<br>';
		echo mysqli_connect_error();
		exit();
		}
		if($username!=NULL & $disnumber!=NULL & $number!=NULL){
		$result = mysqli_query($mysql, "INSERT INTO orders (name, card, number) VALUES(N'$username','$disnumber','$number')");
		mysqli_close($mysql);
		header('Location: /orders.php');
		}
	}
?>