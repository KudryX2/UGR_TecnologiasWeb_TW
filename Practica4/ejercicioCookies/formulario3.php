<!DOCTYPE html>

<html>

	<head>
		<title></title>
	</head>

	<body>

		<?php

			if(isset($_POST['confirmar'])){
				setcookie('nombre', '', time()-1);
				setcookie('prenda', '', time()-1);
				setcookie('talla', '', time()-1);
				setcookie('color', '', time()-1);
				unset($_POST['talla']);
				unset($_POST['color']);
				header('Location: ./formulario1.php');	
			}

			if(!isset($_COOKIE['nombre']) || !isset($_COOKIE['prenda'])){
				header('Location: ./formulario1.php');
			
			}else if(!isset($_COOKIE['talla']) || !isset($_COOKIE['color'])){
				header('Location: ./formulario2.php');

			}else{

				echo '
					<h2>Los datos proporcionados son: </h2>
				';

				echo '<h3>El nombre del comprador es: '.$_COOKIE['nombre'].'</h3>';
				echo '<h3>La prenda seleccionada es: '.$_COOKIE['prenda'].'</h3>';
				echo '<h3>La talla seleccionada es: '.$_COOKIE['talla'].'</h3>';
				echo '<h3>El color seleccionado es: '.$_COOKIE['color'].'</h3>';

				echo '
					<form action="" method="POST">
						<input type="submit" name="confirmar" value="Confirmar">
					</form>
				';

				
				
			}

		?>
	
	</body>

</html>