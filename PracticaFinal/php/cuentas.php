<?php

	if($_SESSION['login'] == false){
		echo'
			<form action="" method="POST">
				<p>Usuario<input type="text" name="usuario"></p>
				<p>Contraseña<input type="password" name="pass"></p> 
				<input type="submit" name="entrar" value="Entrar">
			</form>
		';
	}else{
		header('Location: ./index.php?menu=informacion');
	}

	if(isset($_POST['entrar'])){
					
		$query = mysqli_query($connection, "SELECT login,pass,tipo FROM usuarios");


		while($salida = mysqli_fetch_row($query)){
			
			if($salida[0] == $_POST['usuario'] && $salida[1] == $_POST['pass']){
				$_SESSION['login']=true;
				$_SESSION['usuario'] = $_POST['usuario'];
				$_SESSION['tipo'] = $salida[2];
				registrarEnLog($connection, "log in");
				header('Location: ./index.php');
			}
		}

		if($_SESSION['login'] == false){
			registrarEnLog($connection, "wrong pass");
		}

	}

	if(isset($_GET['salir'])){
		session_destroy();
		registrarEnLog($connection, "log out");
		header('Location: ./index.php');
	}

?>