
<!doctype html>

<html lang="ru">

  <head>
	<?php
	require_once('php/header.php');
	?>
  </head>
<?php	



// Добавление данных в таблицу
if (isset($_POST['Date'])&& isset($_POST['Name']) && isset($_POST['Price'])&& isset($_POST['Сode'])&& isset($_POST['Quantity'])){

	
	
    $mysql = mysqli_connect('127.0.0.1', 'root','', 'baza1');
		if ($mysql == false){
		echo 'Не удалось подключиться к бд<br>';
		echo mysqli_connect_error();
		exit();
		}
    // Переменные с формы
	mysqli_set_charset($mysql, 'utf8');
	
	$date=$_POST['Date'];
    $name = mysqli_real_escape_string($mysql, $_POST['Name']);
    $price = $_POST['Price'];
    $code = $_POST['Сode'];
    $quantity = $_POST['Quantity'];
	
    $result = mysqli_query($mysql,"INSERT INTO dishes (date, name, price, code, amount) VALUES ('$date',N'$name',N'$price','$code','$quantity')");  
    	
    mysqli_close($mysql);
	
	header("Location: /Dishes.php"); 
	exit();
}




?> 


  <body class="bg-light">




    <div class="container">
  <div class="py-5 text-center">
    
    <h1> Добавить блюдо</h1>
    </div>

 
    <div class="order-md-1 ">
       <form class='formWithValidation' enctype="multipart/form-data" method="POST" class="form-signin" novalidate>
        <div class="row">
		 </div>
		     <div class="row">
          <div class="col-md-2 mb-3">
             <label  class="text" for="Date">Дата</label>
                 <input type="date" class="form-control field" id="Date" name="Date" required>
				 
          </div>
          <div class="col-md-3 mb-3">
             <label class="text" for="Name">Название</label>
                <input type="text" class="form-control field" id="Name" name="Name" required>
				
          </div>



        <div class="col-md-2 mb-3">
           <label class="text" for="Price">Цена</label>
                <input type="text" class="form-control field" id="Price" name="Price"  required>
				
        </div>


        <div class="col-md-2 mb-3">
          <label class="text" for="Сode">Код </label>
                <input type="text" class="form-control field" id="Сode" name="Сode"  required>
				
        </div>
       
        <div class="col-md-2 mb-3">
          <label class="text" for="Quantity">Количество</label>
                <input type="text" class="form-control field" id="Quantity" name="Quantity"  required>
				
        </div>
		
		 
        </div>
        <div class=" text-center">
    <button class="btn btn-warning btn-lg validateBtn" type="submit" >Добавить</button>
    </div>
       
      </form>
    </div>
  


</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="/docs/4.3.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="/docs/4.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
 <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js" ></script>
</body>
<script>
//Валидация формы
var form = document.querySelector('.formWithValidation');

var Date = document.getElementById('Date');
var Name = document.getElementById('Name');
var Price = document.getElementById('Price');
var Сode = document.getElementById('Сode');
var Quantity = document.getElementById('Quantity');

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
     // console.log('field is blank', fields[i]);
	  var error = generateError('Cant be blank');
    form[i].parentElement.insertBefore(error, fields[i]);
    }
  }
  
  
   //Значение Date 1900-2099 года
  if (/^(19|20)\d\d-((0[1-9]|1[012])-(0[1-9]|[12]\d)|(0[13-9]|1[012])-30|(0[13578]|1[02])-31)$/.test(Date.value) ) {
  } else {
	  numbErrors++;
	  var error = generateError('Not correct date');
	  Date.parentElement.insertBefore(error, Date);
  }
  
  //Значение Name от 3 до 30 знаков
   if ( Name.value.length<3 || Name.value.length>30 ) {
	  numbErrors++;
	  var error = generateError('Name length 3 to 30 characters');
	   Name.parentElement.insertBefore(error, Name);
  }


  //Значение Price число от 1 до 10000
  if (/^[0-9]+$/.test(Price.value) ) {
    if( (Price.value<1) || (Price.value>10000) ){
	     numbErrors++;
	     var error = generateError('from 1 to 10000');
		 Price.parentElement.insertBefore(error, Price);
	     }
  } else {
	  numbErrors++;
	  var error = generateError('Enter a number from 1 to 10000');
	   Price.parentElement.insertBefore(error, Price);
  }
  
  //Значение Сode ровно 6 цифр 
  if (/^[0-9][0-9][0-9][0-9][0-9][0-9]$/.test(Сode.value) ) {
  } else {
	  numbErrors++;
	  var error = generateError('The code is exactly 6 digits');
	  Сode.parentElement.insertBefore(error, Сode);
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
 console.log(numbErrors);
  
</script>
</html>