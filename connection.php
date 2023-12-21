<?php 

include('config.env.php');

$conn = null;

$conn = mysqli_connect($host, $user, $password, $database) or die(mysqli_error);

if($conn->connect_error){
	die('A conexão falhou !'.$conn->connect_error);
}
