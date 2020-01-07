<!doctype html>
<?php	
session_start();
$mysqli = mysqli_connect("localhost", "root", "","baza1");

// Поиск
if (isset($_POST['Search'])){
   $_SESSION['searchLine']=$_POST['searchLine'];
	header("Location: Search.php"); exit();
}
$searchLine=  $_SESSION['searchLine'];

  ?>
<meta http-equiv="Cache-Control" content="no-cache"> 
<html lang="en">
  <head>
    <?php
	require_once('php/header.php');
	?>	
  </head>
  <body>
    <header>
	
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
    
	  <form class="form-inline " method="POST">
	  <div class="input-group ">
        <input class="form-control " type="text" <?php echo 'value="'.$searchLine .'"'; ?> name="searchLine">
		<div class="input-group-append">
        <button class="btn btn-outline-light " type="submit" name="Search" >Search</button>
		</div>
	</div>
      </form>
	 
    </div>
	
  </nav>
  
  
	
</header>

<main role="main">


  <section class="jumbotron text-center">
    
     <div class=" py-1 mb-2">
    
	  <h3 class="p-2 "  >Search result for: <?php  echo '<font class="text-primary" >'.$searchLine.'</font>'; ?></h3>
    
  </div>
  
  </section>
 
<div class="container">
     <div class="row">
<?php	


 // Показать заказчиков
 if (isset($_POST['ViewOrders'])){
	 $_SESSION['ID']=$_POST['id'];
	 header("Location: View_orders.php"); exit();
 }

 // Перейти к карточке товара
 if (isset($_POST['Сard_cake'])){
	 $_SESSION['IDClients']=-1;
	 $_SESSION['IDCakes']=$_POST['id'];
	 header("Location: Card.php"); exit();
 }
 
 // Перейти к карточке товара
 if (isset($_POST['Сard_orders'])){
	 $_SESSION['IDClients']=$_POST['idClients'];
	 $_SESSION['IDCakes']=-1;
	 header("Location: Card.php"); exit();
 }
 
$words = explode(" ", $searchLine);
$numbWords=0;

// Вывод заказчиков

$sql = "SELECT id FROM clients WHERE  MATCH(`name`, `lastname`, `city`) AGAINST('*";
foreach ( $words as $searchWord ) {if($searchWord){$sql.=$searchWord; $sql.="*"; $numbWords++;}}
$sql.="' IN BOOLEAN MODE)";
$i=1;

if ($numbWords!=0){
$res = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_array($res)){
	$sql = "SELECT 	name,lastname,city FROM clients WHERE id=".$row['id']."";
    $res2 = mysqli_query($mysqli,$sql);
    $Row = mysqli_fetch_array($res2);
	
	$sql = "SELECT id FROM orders WHERE idClients=".$row['id']."";
	$result = mysqli_query($mysqli,$sql);
	$j=0;
	while($оrders = mysqli_fetch_array($result)){$j++;}
	
	echo '
	<div class="col-md-12 ">
		    <form  method="POST" >
		     <input type="hidden" name="idClients" value="'.$row['id'].'">
		       <div class="card mb-4 shadow-sm border-primary">
			    <div class="card-body">
			      <div class="row align-items-center">
		           <div class="col-md-1 mb-3 "> '.$i.' </div>
				
				  <div class="col-md-3 mb-3 " style="font-size: 20px;"> Заказчик '.$Row['name'].' '.$Row['lastname'].' </div>
		        
				<div class="col-md-2 mb-3 "> 
				 Город: '.$Row['City'].'
				 </div>
				<div class="col-md-2 mb-3 "> Заказов: '.$j.'</div>
				
                   </div>
			   </div>
			  </div>
		    </form>
		 </div>
		 ';
	$i++;
}
}

$numbWords=0;
$sql = "SELECT id FROM cakes WHERE  MATCH(`name`, `price`, `code`, `quantity`) AGAINST('*";
foreach ( $words as $searchWord ) { if($searchWord){$sql.=$searchWord; $sql.="*";$numbWords++;}}
$sql.="' IN BOOLEAN MODE)";

if ($numbWords!=0){
$res = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_array($res)){
   $sql = "SELECT id,Date,name,price,code,quantity,addressImg FROM cakes WHERE id=".$row['id']."";
   $res2 = mysqli_query($mysqli,$sql);
   $Row = mysqli_fetch_array($res2);
   
	$sql = "SELECT id FROM orders WHERE idCakes=".$row['id']."";
	$result = mysqli_query($mysqli,$sql);
	$j=0;
	while($оrders = mysqli_fetch_array($result)){$j++;}
	
	echo '
	   
	       <div class="col-md-12 ">
		    <form  method="POST" >
		  <input type="hidden" name="id" value="'.$row['id'].'"> 
		    <div class="card mb-4 shadow-sm border-primary">
			<div class="card-body">
			 <div class="row align-items-center">
	        <div class="col-md-1 mb-3 "> '.$i.'  </div>
			 <div class="col-md-3 mb-2" style="font-size: 20px;">Cake <button class="btn btn-link"   style="font-size: 20px" type="submit" name="Сard_cake">'.$Row['name'].'</button></div> 
			 <div class="col-md-2 mb-3  ">   <img src="'.$Row['addressImg'].'?t='.rand(0, 1000).'"  alt="" width="100" height="75"> </div>
			 <div class="col-md-2 mb-2" style="font-size: 20px;"> '.$Row['price'].' rub. </div> 
				<div class="col-md-2 mb-2">
				 Date: '.$Row['Date'].'
				 Сode: '.$Row['code'].'
				 Quantity: '.$Row['quantity'].'
				  </div>
				<div class="col-md-2 mb-2"><button class="btn btn-link"    type="submit" name="ViewOrders">		Orders: '.$j.'</button>   </div>

			     </div>
			   </div></div>
			   </form>
		 </div>
		 
			  
		 ';
	$i++;
}
}
if($i==1){echo '
 <section class="jumbotron text-center">
<h3>Nothing found for your request</h3>
  </section>'; }
	

mysqli_close($mysqli);

?> 
 </div>
 </div>
</main>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
	  <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js" ></script>
</body>


</html>
 