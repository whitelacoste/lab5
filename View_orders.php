<!doctype html>
<meta http-equiv="Cache-Control" content="no-cache"> 
<html lang="en">
  <head>
    <?php
	require_once('php/header.php');
	?>	
  </head>
  <body>


<main role="main">


  
  <section class="jumbotron text-center">
    
     <div class=" py-1 mb-2">
    <?php
	session_start();
    $mysqli = mysqli_connect("localhost", "root", "","baza1");
    mysqli_set_charset($mysqli, 'utf8');
	// Поиск
     if (isset($_POST['Search'])){
   $_SESSION['searchLine']=$_POST['searchLine'];
	header("Location: Search.php"); exit();
    }

	$id = $_SESSION['ID'];
	$sql= "SELECT name FROM dishes WHERE id=".$id."";
	$res = mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_array($res);
	echo '<h3 class="p-2 ">Заказы "'.$row['name'].'" </h3>';
	?>
	  
    
  </div>
  
  </section>
 
 
 
  <table class="table table-striped">
  <thead>
    <tr >
	 <th scope="col">#</th>
	 <th scope="col">Клиент</th>
      <th scope="col">Город</th>
	  <th scope="col">Количество</th> 
	  <th scope="col"></th> 
      <th scope="col"></th> 
    </tr>
  </thead>
  <tbody>

<?php	




// Удаление данных из таблицы
if (isset($_POST['Delete'])){
    $sql = 'DELETE FROM orders  WHERE idClients='. $_POST['idClients'].' AND idDishes='. $_POST['idDishes'].'';
	$result = mysqli_query($mysqli,$sql);
		
}

// Изменение данных в таблице
 if (isset($_POST['Edit'])){
	 $_SESSION['IDClients']=$_POST['idClients'];
	 $_SESSION['IDDishes']=$_POST['idDishes'];
	 header("Location: Edit_order.php"); exit();
 }

// Добавление заказчика
 if (isset($_POST['Add'])){
	
	 header("Location: Add_order.php"); exit();
 }


// Вывод таблицы

$sql = "SELECT 	idClients,Quantity FROM orders WHERE idDishes=".$id."";
$res1 = mysqli_query($mysqli,$sql);
$i=1;
while($row1 = mysqli_fetch_array($res1)){
$sql = "SELECT 	name, lastname,city FROM clients WHERE id=".$row1['idClients']."";
$res2 = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_array($res2);

	echo '<tr>
	<form  method="POST" >
			 <input type="hidden" name="idClients" value="'.$row1['idClients'].'">
			 <input type="hidden" name="idDishes" value="'.$id.'">
		        <th scope="row">'.$i.'</th>
				  <td>'.$row['name'].' '.$row['lastname'].'</td>
				  <td>'.$row['city'].'</td>
				  <td>'.$row1['Quantity'].'</td>
				  <td><button class="btn btn-warning" type="submit" name="Edit" >Редактировать</button></th>
				  <td><button class="btn btn-warning" type="submit" name="Delete" >Удалить</button></th>
  </form>
		 </tr>';
	$i++;
}

if($i==1){echo '<tr>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td></td>
				   <th scope="row" class="text-center">There were no orders</th>
				   <td></td>
				   <td></td>
				   <td></td>
				   <td></td>
                </tr>'; }
mysqli_free_result($res);
mysqli_close($mysqli);

?> 
</tbody>
</table>

  <div  style="margin-top: 30px; margin-bottom: 30px;" class="text-center">
  <form  method="POST" >
			 <input type="hidden" name="id" <?php echo 'value="'.$id.'"'?> >
			<a href="Dishes.php" class="btn btn-primary active" role="button" aria-pressed="true">Вернуться</a>
	           <button class="btn btn-warning" type="submit" name="Add" >Добавить</button>
  </form>
  </div>
 
 
</main>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
	  <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js" ></script>
</body>


</html>
 