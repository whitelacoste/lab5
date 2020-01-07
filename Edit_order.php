
<!doctype html>

<html lang="ru">

 <head>
    <?php
	require_once('php/header.php');
	?>	
  </head>
<?php	
session_start();
 $mysqli = mysqli_connect("localhost", "root", "","baza1");
 mysqli_set_charset($mysqli, 'utf8');
// Вывод данных
 $id = $_SESSION['IDClients'];
 
$sql = "SELECT 	name,lastname,city FROM clients WHERE id=".$id."";
 $res=mysqli_query($mysqli,$sql);
 $row= mysqli_fetch_array($res);
 $sql = "SELECT Quantity FROM orders WHERE idClients=".$id." AND idDishes=".$_SESSION['IDDishes']."";
$res1 = mysqli_query($mysqli,$sql);
$row1= mysqli_fetch_array($res1);

// Изменение данных в таблице
if (isset($_POST['SaveChanges'])){
if (isset($_POST['Name'])&& isset($_POST['Lastname'])&&  isset($_POST['City'])&& isset($_POST['Quantity']) ){

    // Переменные с формы
	$name = $mysqli->real_escape_string($_POST['Name']);
	$lastname = $mysqli->real_escape_string($_POST['Lastname']);
    $city =$_POST['City'];
    $Quantity = $_POST['Quantity'];
	
    $result = mysqli_query($mysqli,'UPDATE clients SET name="'.$name.'", lastname="'.$lastname.'", city="'.$city.'"  WHERE id='.$id.'');  
	$result = mysqli_query($mysqli,'UPDATE orders SET Quantity='.$Quantity.'   WHERE idClients='.$id.' AND idDishes='.$_SESSION['IDDishes'].'');
	
	
    mysqli_close($mysqli);
	unset($_SESSION);
	header("Location:  View_orders.php"); exit();
}}


?> 


  <body class="bg-light">




    <div class="container">
  <div class="py-5 text-center">
    
    <h1>  Редактировать заказ</h1>
    </div>

 
    <div class="order-md-1 ">
       <form class='formWithValidation' method="POST" class="form-signin" novalidate>
	   
			   <div class="row">
         
          <div class="col-md-3 mb-3">
             <label class="text" for="Name">Имя</label>
                <input type="text" class="form-control field" id="Name" name="Name" <?php echo 'value="'.$row['name'].'"'; ?>  required>
				
          </div>

           <div class="col-md-3 mb-3">
             <label  class="text" for="Surname">Фамилия</label>
                 <input type="text" class="form-control field" id="Surname" name="Lastname" <?php echo 'value="'.$row['lastname'].'"'; ?> required>
				 
          </div> 
		   	
           </div>
   <div class="row">
        <div class="col-md-2 mb-3">
	 <div class="form-group">
              <label  for="City">Город</label>
              <select class="form-control field" id="City" name="City" >
			   <option></option>
                 <option <?php if($row['city']=="Волгоград"){ echo 'selected';} ?>  value="Волгоград">Волгоград</option>
                 <option <?php if($row['city']=="Волжский"){ echo 'selected';}?>  value="Волжский">Волжский</option>
                 <option <?php if($row['city']=="Михайловка"){ echo 'selected';} ?>  value="Михайловка">Михайловка</option>
                 <option <?php if($row['city']=="Камышин"){ echo 'selected';} ?>  value="Камышин">Камышин</option>
                 <option <?php if($row['city']=="Калач на Дону"){ echo 'selected';} ?>  value="Калач на Дону">Калач на Дону</option>
             </select>
           </div>  
        </div>
		
		
		  <div class="col-md-2 mb-3">
          <label class="text" for="Quantity">Количество</label>
                <input type="text" class="form-control field" id="Quantity" name="Quantity" <?php echo 'value="'.$row1['Quantity'].'"'; ?> required>
				
        </div>
        </div>
        <div class=" text-center">
    <button class="btn btn-warning btn-lg validateBtn" type="submit" name="SaveChanges" >Сохранить</button>
    </div>
       
      </form>
    </div>
  

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="/docs/4.3.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
 <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js" ></script>
</body>
<script>
//Валидация формы
var form = document.querySelector('.formWithValidation');

var Name = document.getElementById('Name');
var Lastname = document.getElementById('Lastname');
var Quantity = document.getElementById('Quantity');
var fields = document.querySelectorAll('.field');


var generateError = function (text) {
  var error = document.createElement('div');
  error.className = 'error';
   error.style.color = 'red';
  error.innerHTML = text;
  return error;
}

 
form.addEventListener('submit', function (event) {
   
  var numbErrors = 0;
   //Удаляем ошибки
  var errors = form.querySelectorAll('.error');
  
  for (var i = 0; i < errors.length; i++) {
    errors[i].remove();
  }
  //Заполнены ли все поля
  for (var i = 0; i < fields.length; i++) {
    if (/^\s*$/.test(fields[i].value)) {
		numbErrors++;
	  var error = generateError('Cant be blank');
    form[i].parentElement.insertBefore(error, fields[i]);
    }
  }

  
  
  //Значение Name от 3 до 30 знаков
   if ( Name.value.length<3 || Name.value.length>30 ) {
	  numbErrors++;
	  var error = generateError('length 3 to 30 characters');
	   Name.parentElement.insertBefore(error, Name);
  }

//Значение Lastname от 3 до 30 знаков
   if ( Lastname.value.length<3 || Lastname.value.length>30 ) {
	  numbErrors++;
	  var error = generateError(' length 3 to 30 characters');
	  Surname.parentElement.insertBefore(error, Lastname);
  }
  
  //Значение Quantity число от 1 до 100
  if (/^[0-9]+$/.test(Quantity.value) ) {
    if( (Quantity.value<1) || (Quantity.value>100) ){
	     numbErrors++;
	     var error = generateError('from 1 to 100');
		  Quantity.parentElement.insertBefore(error, Quantity);
	     }
  } else {
	  numbErrors++;
	  var error = generateError('Enter a number from 1 to 100');
	   Quantity.parentElement.insertBefore(error, Quantity);
  }

  
  if (numbErrors==0) {return true;}
  else {event.preventDefault(); 
  }
})
  
</script>
</html>