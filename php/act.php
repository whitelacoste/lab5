<?php
$char = $_POST["name"]; 
$text = file_get_contents($_POST["ssil"]);
$text = str_replace($char, "<span style='color : #f00;'>{$char}</span>", $text);
echo $text;
?>