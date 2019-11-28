<!DOCTYPE html>

<html>

	<head>
		<title></title>
	</head>

	<body>

		<?php

			if(isset($_POST['continuar'])){
				if(isset($_POST['nombre']) && preg_match('/^[a-z A-Z]*$/', $_POST['nombre']) && isset($_POST['prenda'])){
					setcookie("nombre", $_POST['nombre'], time()+100);
					setcookie("prenda", $_POST['prenda'], time()+100);	
					unset($_POST['nombre']);
					unset($_POST['prenda']);
					header('Location: ./formulario2.php');
				}				
			}

			echo '
				<form action="./formulario1.php" method="POST">

					<h3>Introduzca su nombre<input type="text" name="nombre"></h3>
					<h3>Seleccione una prenda<select name="prenda">
							<option value="camisa">Camisa</option>
							<option value="pantalón">Pantalon</option>
							<option value="falda">Falda</option>
						</select></h3>

					<input type="submit" name="continuar" value="Continuar">
				</form>
			';

		?>
	
	</body>

</html>