<?php

	$servername = "localhost";
	$username = "raol1718";
	$password = "A5n9Wqob";
	$db = "raol1718";

	$connection = mysqli_connect($servername, $username, $password, $db);
	mysqli_set_charset($connection, "utf8");

	if(mysqli_connect_errno($connection)){
	    echo "<p>Error al conectarse a la base de datos</p>";
	}else{ 
		//echo "<p>Conectado a base de datos</p>";

		// Iniciar sesion
		if (!isset($_SESSION)){
			session_start();
		}


	}

?>