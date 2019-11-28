<!DOCTYPE html>

<html>
	
	<head>
		<title>
			<meta charset="UTF-8">
			<title>Formulario</title>
		</title>
	</head>

	<body>
		<?php 

		
		//	SELECCIONAR AREA TEMATICA
		genSeleccionarAreaTematica();

		//  FORMULARIO
		validarFormulario();
		genFormulario();

		
		/*
			FUNCIONES GENERAR HTML
		*/
		function genSeleccionarAreaTematica(){

			if(isset($_POST['areaTematica'])){
				$tematica = $_POST['areaTematica'];
			}

			echo'<h2>Seleccione un area tematica</h2>';
			echo'
			<form action="index.php" method="POST">
				<h3>Areas tematicas<select name="areaTematica">
					';
					if(isset($tematica)){
						if($tematica == 'divulgacion')
							echo'
								<option value="divulgacion" selected=selected>Divulgación</option>
							';
						else
							echo'
								<option value="divulgacion">Divulgación</option>
							';

						if($tematica == 'motor')
							echo'
								<option value="motor" selected=selected>Motor</option>
							';
						else
							echo'
								<option value="motor">Motor</option>
							';

						if($tematica == 'viajes')
							echo'
								<option value="viajes" selected=selected>Viajes</option>
							';
						else
							echo'
								<option value="viajes">Viajes</option>
							';

					}else{
						echo'
							<option value="divulgacion">Divulgación</option>
							<option value="motor">Motor</option>
							<option value="viajes">Viajes</option>
						';

					}
				echo'							
				</select>
				<input type="submit" value="Seleccionar">
				</h3>
			</form>

			';

		}

		function genFormulario(){

			if(isset($_POST['areaTematica'])){
				$tematica = $_POST['areaTematica'];

				echo'
				<form action="index.php" method="POST">
					<fieldset>
						<h3>Información personal</h3>
				';
				
					echo '<h3>Nombre<input type="text" name="nombre" value="';if(isset($_POST['nombre'])) echo $_POST['nombre']; echo '">';
					if(isset($_POST['nombre']) && $_POST['nombre'] == '') 
						echo 'Introduzca un nombre valido'; 
					echo '</h3>';

					echo '<h3>Apellidos<input type="text" name="apellidos" value="';if(isset($_POST['apellidos'])) echo $_POST['apellidos'];echo'">';
					if(isset($_POST['apellidos']) && $_POST['apellidos'] == '') 
						echo 'Introduzca un/os apellido/s valido/s'; 
					echo '</h3>';

					echo '<h3>Dirección<input type="text" name="direccion" value="';if(isset($_POST['direccion'])) echo $_POST['direccion'];echo'">';
					if(isset($_POST['direccion']) && $_POST['direccion'] == '') 
						echo 'Introduzca una dirección valida'; 
					echo '</h3>';

					echo '<h3>Fecha de nacimiento<input type="text" name="fechaNacimiento" value="';if(isset($_POST['fechaNacimiento'])) echo $_POST['fechaNacimiento'];echo'">';
					if(isset($_POST['fechaNacimiento']) && $_POST['fechaNacimiento'] == '') 
						echo 'Introduzca una fecha de nacimiento valida'; 
					echo '</h3>';

					echo '<h3>Teléfono<input type="number" name="telefono" value="';if(isset($_POST['telefono'])) echo $_POST['telefono'];echo'">';
					if(isset($_POST['telefono']) && $_POST['telefono'] == '') 
						echo 'Introduzca un teléfono valido'; 
					echo '</h3>';

					echo '<h3>Email<input type="text" name="email" value="';if(isset($_POST['email'])) echo $_POST['email'];echo'">';
					if(isset($_POST['email']) && $_POST['email'] == '') 
						echo 'Introduzca un email valido'; 
					echo '</h3>';

					echo '<h3>Cuenta Corriente<input type="text" name="cuenta" value="';if(isset($_POST['cuenta'])) echo $_POST['cuenta'];echo'">';
					if(isset($_POST['cuenta']) && $_POST['cuenta'] == '') 
						echo 'Introduzca una cuenta valida'; 
					echo '</h3>';


				echo '</fieldset>';



				echo'
					<fieldset>
						<h3>Información sobre la suscripción</h3>
				';

				if($tematica == 'divulgacion'){
					echo'
						<h3>Revista seleccionada<select name="revistaSeleccionada">
							<option value="sabelotodo">Sabelotodo</option>
							<option value="solo se que no se nada">Solo sé que no sé nada</option>
							<option value="muy interesado">Muy interesado</option>
							<option value="ciencia con sabor">Ciencia con sabor</option>
						</select></h3>';
				}else if($tematica == 'motor'){
					echo'
						<h3>Revista seleccionada<select name="revistaSeleccionada">
							<option value="supercoches">Supercoches</option>
							<option value="corree que te pillo">Corre que te pillo</option>
							<option value="el mas lento de la carrera">El más lento de la carrera</option>
						</select></h3>';
				}else if($tematica == 'viajes'){
					echo'
						<h3>Revista seleccionada<select name="revistaSeleccionada">
							<option value="paraisos del mundo">Paraisos del mundo</option>
							<option value="conoce tu cuidad">Conoce tu cuidad</option>
							<option value="la casa de tu vecino: rincones inhospitos">La casa de tu vecino: rincones inhó</option>
						</select></h3>';
				}

				echo '

						<h3>Duración de la suscripción<select name="duracion">
							<option value="anual">Anual</option>
							<option value="bianual">Bianual</option>
						</select></h3>


						<h3>Método de pago<select name="metodoPago">
							<option value="tarjetaCredito">Tarjeta de credito</option>
							<option value="reembolso">Reembolso</option>
						</select></h3>

						<h3>Tipo de tarjeta<select name="tipoTarjeta">
							<option value="visa">Visa</option>
							<option value="mastercard">Mastercars</option>
						</select></h3>

					';
					echo '<h3>Fecha de caducidad de la tarjeta <input type="text" name="caducidadTarjeta" value="';if(isset($_POST['caducidadTarjeta'])) echo $_POST['caducidadTarjeta'];echo'">';
					if(isset($_POST['caducidadTarjeta']) && $_POST['caducidadTarjeta'] == '') 
						echo 'Introduzca una fecha de caducidad valida'; 
					echo '</h3>';

					echo '<h3>Código CVC<input type="number" name="cvc" value="';if(isset($_POST['cvc'])) echo $_POST['cvc'];echo'">';
					if(isset($_POST['cvc']) && $_POST['cvc'] == '') 
						echo 'Introduzca un código CVC valido'; 
					echo '</h3>';
					
					echo'
					</fieldset>

					<fieldset>
						<h3>Otra información</h3>

						<h3>Marque sus temas de interes</h3>
						<input type="checkbox" name="temasInteres" value="TemaInteres1">TemaInteres1</br>
						<input type="checkbox" name="temasInteres" value="TemaInteres2">TemaInteres2</br>
						<input type="checkbox" name="temasInteres" value="TemaInteres3">TemaInteres3</br>
									
						<h3>¿Accepta el envio de publicidad por email?<input type="checkbox" name="publicidad" value="publicidad"></h3>
					</fieldset>
				
					<input type="hidden" name="areaTematica" value="'.$tematica.'">
					<input type="submit" value="Validar la compra">

				</form>
				';

			}

		}

		function validarFormulario(){
			$validado = true;
			/* */
			if(isset($_POST['nombre'])){
				$nombre = $_POST['nombre'];
				if($nombre == '' || !preg_match('/^[a-z A-Z]*$/', $nombre)){
					$validado = false;
					$_POST['nombre'] = '';
				}
			}
			/* */
			if(isset($_POST['apellidos'])){
				$apellidos = $_POST['apellidos'];
				if($apellidos == '' || !preg_match('/^[a-z A-Z]*[a-z A-Z]*$/', $apellidos)){
					$validado = false;
					$_POST['apellidos'] = '';
				}
			}
			/* */
			if(isset($_POST['direccion'])){
				$direccion = $_POST['direccion'];
				if($direccion == '' || !preg_match('/^[a-z A-Z1-99\/,-]*$/', $direccion)){
					$validado = false;
					$_POST['direccion'] = '';
				}
			}
			/* */
			if(isset($_POST['fechaNacimiento'])){
				$fechaNacimiento = $_POST['fechaNacimiento'];
				
				$nac = new DateTime($fechaNacimiento);
				$act = new DateTime();
				$edad = $act->diff($nac)->y;


				if($fechaNacimiento == '' || $edad < 18 || !preg_match('/^[0-9]{2}[\/-][0-9]{2}[\/-][0-9]{4}\z/', $fechaNacimiento)){
					$validado = false;
					$_POST['fechaNacimiento'] = '';
				}

			}
			/* */
			if(isset($_POST['telefono'])){
				$telefono = $_POST['telefono'];
				if($telefono == '' || !preg_match('/^[1-99]*$/', $telefono)){
					$validado = false;
					$_POST['telefono'] = '';
				}
			}
			/* */
			if(isset($_POST['email'])){
				$email = $_POST['email'];
				if($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
					$validado = false;
					$_POST['email'] = '';
				}
			}
			/* */
			if(isset($_POST['cuenta'])){
				$cuenta = $_POST['cuenta'];

				$cuenta1 = substr($cuenta, 0,4); 
				$cuenta2 = substr($cuenta, 4,4);
				$cuenta3 = substr($cuenta, 8,2);
				$cuenta4 = substr($cuenta, 10,10);
			
				if($cuenta == '' || valcuenta_bancaria($cuenta1, $cuenta2, $cuenta3, $cuenta4) || !preg_match('/^[0-9 ]*$/', $cuenta)){
					$validado = false;
					$_POST['cuenta'] = '';
				}
			}
			/* */
			if(isset($_POST['caducidadTarjeta'])){
				$caducidad = $_POST['caducidadTarjeta'];

				if(!preg_match('/[0-9]{2}[\/-][0-9]{2}[\/-][0-9]{4}\z/', $caducidad)){
					$validado = false;
					$_POST['caducidadTarjeta'] = '';
				}
			}

			/* */
			if (isset($_POST['cvc'])){
				$cvc = $_POST['cvc'];

				if($cvc == '' || !preg_match('/^[1-9]*$/', $cvc)){
					$validado = false;
					$_POST['cvc'] = '';
				}
			}
			/* */

			if($validado){
				echo "<ul>";
				foreach ($_POST as $c => $v) {
					if(is_array($v)){
						echo "<li>$c = ";
						print_r($v);
						echo "</li>";
					}else{
						echo "<li>$c = $v</li>";
					}
				}
				echo "</ul>";
			}

			return $validado;
		}

		/*
			FUNCIONES VERIFICAR CUENTA BANCARIA
		*/
		function valcuenta_bancaria($cuenta1,$cuenta2,$cuenta3,$cuenta4){
			if (strlen($cuenta1)!=4) return false;
			if (strlen($cuenta2)!=4) return false;
			if (strlen($cuenta3)!=2) return false;
			if (strlen($cuenta4)!=10) return false;

			if (mod11_cuenta_bancaria("00".$cuenta1.$cuenta2)!=$cuenta3{0}) return false;
			if (mod11_cuenta_bancaria($cuenta4)!=$cuenta3{1}) return false;
			return true;
		}
		//////////////////////////////////////////////////////////////////////////////////////

		function mod11_cuenta_bancaria($numero){
			if (strlen($numero)!=10) return "?";

			$cifras = Array(1,2,4,8,5,10,9,7,3,6);
			$chequeo=0;
			for ($i=0; $i < 10; $i++)
			    $chequeo += substr($numero,$i,1) * $cifras[$i];

			$chequeo = 11 - ($chequeo % 11);
			if ($chequeo == 11) $chequeo = 0;
			if ($chequeo == 10) $chequeo = 1;
			return $chequeo;
		}

		?>


	</body>

</html>