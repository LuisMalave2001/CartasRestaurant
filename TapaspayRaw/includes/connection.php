<?php 


function getConnection(){
	$user = "admin";
	$password = "admin123";
	return new PDO('mysql:host=localhost;dbname=restaurante_cartas', $user, $password);
}

?>