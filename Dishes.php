<!doctype html>
<meta http-equiv="Cache-Control" content="no-cache"> 
<html lang="en">
  <head>
    <?php
	require_once('php/header.php');
	?>
	<?php	
session_start();
$mysqli = mysqli_connect("localhost", "root", "","baza1");

	mysqli_set_charset($mysqli, 'utf8');

// Поиск
if (isset($_POST['Search'])){
   $_SESSION['searchLine']=$_POST['searchLine'];
	header("Location: Search.php"); exit();
}
?>
	
  </head>
  <body>
 

<main role="main">


  
  <section class="jumbotron text-center">
    
     <div class=" py-1 mb-2">
    
	  <h3 class="p-2 "  >Блюда</h3>
    
  </div>
  
  </section>
 
 
 
  <table class="table table-striped">
  <thead>
    <tr >
	 <th scope="col">#</th>
      <th scope="col">Дата</th>
      <th scope="col">Название</th>
      <th scope="col">Цена</th>
      <th scope="col">Код</th>
	  <th scope="col">В наличии</th>
	  <th scope="col">Заказы</th>
	  <th scope="col"></th>
	  <th scope="col"></th>
	  
    </tr>
  </thead>
  <tbody>

<?php	


// Удаление данных из таблицы
if (isset($_POST['Delete'])){
    $id = $_POST['id'];
    $sql = 'UPDATE dishes SET delet=1 WHERE id='.$id.'';
	$result = mysqli_query($mysqli,$sql);
		
}

 // Изменение данных в таблице
 if (isset($_POST['Edit'])){
	 $_SESSION['ID']=$_POST['id'];
	 header("Location: Edit_dishes.php"); exit();
 }
 
 // Показать заказчиков
 if (isset($_POST['ViewOrders'])){
	 $_SESSION['ID']=$_POST['id'];
	 header("Location: View_orders.php"); exit();
 }

 
// Вывод таблицы
$sql = "SELECT id,name,price,code,quantity,date FROM dishes WHERE delet=0";
$res = mysqli_query($mysqli,$sql);
$i=1;
while($row = mysqli_fetch_array($res)){
	$sql = "SELECT id FROM orders WHERE idDishes=".$row['id']."";
	$result = mysqli_query($mysqli,$sql);
	$j=0;
	while($оrders = mysqli_fetch_array($result)){$j++;}
	echo '<tr>
	         <form  method="POST" >
			 <input type="hidden" name="id" value="'.$row['id'].'">
		        <th scope="row">'.$i.'</th>
				  <td>'.$row['date'].'</td>
				  <td><button class="btn btn-link"    type="submit" name="Сard">'.$row['name'].'</button></td>
				  <td>'.$row['price'].' руб </td>
				  <td>'.$row['code'].'</td>
				  <td>'.$row['quantity'].'</td>
				  <td><button class="btn btn-link"    type="submit" name="ViewOrders">'.$j.'</button></td>
				  <td><button class="btn btn-warning" type="submit" name="Edit" >Редактировать</button></th>
				  <td><button class="btn btn-warning" type="submit" name="Delete" >Удалить</button></th>
				   
		     </form>
		 </tr>';
	$i++;
}

mysqli_free_result($res);
mysqli_free_result($result);
mysqli_close($mysqli);

?> 
</tbody>
</table>

 
 



  <div  style="margin-top: 30px; margin-bottom: 30px;" class="text-center">
  
               <a class="btn btn-warning btn-lg" role="button" href="Add_dishes.php"><h3>Добавить</h3></a>
			   
  </div>
 
 
</main>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">Up</a>
    </p>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
	  <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js" ></script>
</body>


</html>
 