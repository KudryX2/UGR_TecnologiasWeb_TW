<!DOCTYPE html>

<html>

	<head>
		<title></title>
	</head>

	<body>

		<?php

			if(isset($_POST['continuar'])){
				if(isset($_POST['talla']) && preg_match('/^[1-9]*$/', $_POST['talla']) && isset($_POST['color'])){
					setcookie("talla", $_POST['talla'], time()+100);
					setcookie("color", $_POST['color'], time()+100);
					unset($_POST['talla']);
					unset($_POST['color']);	
					header('Location: ./formulario3.php');
				}				
			}

			if(isset($_COOKIE['nombre']) && isset($_COOKIE['prenda'])){

				echo '
					<form action="./formulario2.php" method="POST">

						<h3>Introduzca la talla<input type="number" name="talla"></h3>
						<h3>Seleccione el color<select name="color">
								<option value="rojo">Rojo</option>
								<option value="verde">Verde</option>
								<option value="azul">Azul</option>
							</select></h3>

						<input type="submit" name="continuar" value="Continuar">
					

					</form>
				';

			}else{
				header('Location: ./formulario1.php');
			}
			

		?>
	
	</body>

</html>