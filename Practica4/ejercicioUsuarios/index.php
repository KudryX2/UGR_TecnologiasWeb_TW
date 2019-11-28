<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>

	<body>

		<?php
			// Conectarse a base de datos
			$servername = "localhost";
			$username = "kudry1718";
			$password = "DXQuF0LY";
			$db = "kudry1718";

			$conn = mysqli_connect($servername, $username, $password, $db);

			if(mysqli_connect_errno($conn)){
			    echo "<h5>Error al conectarse</h5>";
			}else{ 
				echo "<h5>Conectado a base de datos</h5>";
			}

			// Iniciar sesion
			if (!isset($_SESSION)){
				session_start();
			}

			// Loguearse
			if(isset($_POST['entrar'])){
				
				$query = mysqli_query($conn, "SELECT email,clave,tipo FROM usuario");


				while($salida = mysqli_fetch_row($query)){
					
					if($salida[0] == $_POST['usuario'] && $salida[1] == $_POST['contrasena']){
						$_SESSION['login']=true;
						$_SESSION['usuario'] = $_POST['usuario'];
						$_SESSION['tipo'] = $salida[2];
					}
				}

			}

			if(isset($_SESSION['usuario'])){
				echo '<h5>Conectado como: '.$_SESSION['usuario'].' / privilegios: '.$_SESSION['tipo'].'</h5>';
			}

			// Desloguearse
			if(isset($_POST['salir'])){
				session_destroy();
				header('Location: ./index.php');
			}
		
			// Form loguearse	
			if(!isset($_SESSION['login'])){
				echo'
					<form action="" method="POST">
						<h3>Usuario(email)<input type="text" name="usuario"></h3>
						<h3>Contraseña<input type="text" name="contrasena"></h3> 
						<input type="submit" name="entrar" value="Entrar">
					</form>
				';
			}

			// Form desloguearse
			if(isset($_SESSION['login'])){
				echo'
					<form action="" method="POST">
						<input type="submit" name="salir" value="Salir">
					</form>
				';
			}

			/*
				SOLO ADMIN
			*/
			if(isset($_SESSION['tipo'])){
				if($_SESSION['tipo'] == 'admin'){

					// VISUALIZAR USUARIOS
					$query = mysqli_query($conn, "SELECT nombre,apellidos,email,clave,tipo FROM usuario");

					echo '
						<h2>Lista de usuarios</h2>
						<table>
							<tr>
								<th>Nombre</th>
								<th>Apellidos</th> 
								<th>Email</th>
								<th>Clave</th>
								<th>Tipo</th>
							</tr>
					';

					while($salida = mysqli_fetch_row($query)){
						echo '<tr>';
						echo '<td>'.$salida[0].'</td>'.'<td>'.$salida[1].'</td>'.'<td>'.$salida[2].'</td>'.'<td>'.$salida[3].'</td>'.'<td>'.$salida[4].'</td>';
						echo '</tr>';
					}
					echo '</table>';



					// MODIFICAR USUARIOS
					echo'
						<h2>Modificar un usuario</h2>
						<form action="" method="POST">
							<h3>Email de usuario a modificar<input type="text" name="usuarioModificar"</h3>
							<input type="submit" name="modificarUsuario" value="Modificar">
						</form>
					';

					if(isset($_POST['modificarUsuario'])){

						$usuarioModificar = $_POST['usuarioModificar'];
						$query = mysqli_query($conn, "SELECT nombre,apellidos,email,clave,tipo FROM usuario WHERE email='$usuarioModificar'");
						$salida = mysqli_fetch_row($query);

						echo '
							<form action="" method="POST">
							<h4>Nombre<input type="text" name="nombre" value='.$salida[0].'></h4>
							<h4>Apellidos<input type="text" name="apellidos" value='.$salida[1].'></h4>
							<h4>Email<input type="text" name="email" value='.$salida[2].'></h4>
							<h4>Clave<input type="text" name="clave" value='.$salida[3].'></h4>
							<h4>Tipo<input type="text" name="tipo" value='.$salida[4].'></h4>
							<input type="hidden" name="usuarioModificar" value='.$usuarioModificar.'>
							<input type="submit" name="guardarModificarUsuario" value="Guardar">
							</form>
						';
					}

					if(isset($_POST['guardarModificarUsuario'])){
						$nombre = $_POST['nombre'];
						$apellidos = $_POST['apellidos'];
						$email = $_POST['email'];
						$clave = $_POST['clave'];
						$tipo = $_POST['tipo'];
						$usuarioModificar = $_POST['usuarioModificar'];

						$sql = "UPDATE usuario SET nombre='$nombre', apellidos='$apellidos', email='$email', clave='$clave', tipo='$tipo' WHERE email='$usuarioModificar'";
						mysqli_query($conn, $sql);
					
						header('Location: ./index.php');
					}


					// CREAR UN NUEVO USUARIO
					echo'
						<h2>Crear un usuario</h2>
						<form action="" method="POST">
							<input type="submit" name="crearUsuario" value="Crear un nuevo usuario">
						</form>
					';

					if(isset($_POST['crearUsuario'])){
						echo '
							<form action="" method="POST">
							<h4>Nombre<input type="text" name="nombre"></h4>
							<h4>Apellidos<input type="text" name="apellidos"></h4>
							<h4>Email<input type="text" name="email"></h4>
							<h4>Clave<input type="text" name="clave"></h4>
							<h4>Tipo<input type="text" name="tipo"></h4>
							<input type="submit" name="guardarNuevoUsuario" value="Guardar">
							</form>
						';
					}

					if(isset($_POST['guardarNuevoUsuario'])){

						$nombre = $_POST['nombre'];
						$apellidos = $_POST['apellidos'];
						$email = $_POST['email'];
						$clave = $_POST['clave'];
						$tipo = $_POST['tipo'];

						$sql = "INSERT INTO usuario (nombre, apellidos, email, clave, tipo)VALUES ('$nombre', '$apellidos', '$email', '$clave', '$tipo')";
						mysqli_query($conn, $sql);
					
						header('Location: ./index.php');	
					}

					// ELIMINAR USUARIO
					echo'
						<h2>Eliminar un usuario</h2>
						<form action="" method="POST">
							<h3>Email de usuario a eliminar<input type="text" name="usuarioEliminar"</h3>
							<input type="submit" name="eliminarUsuario" value="Eliminar">
						</form>
					';

					if(isset($_POST['eliminarUsuario'])){
						$var = $_POST['usuarioEliminar'];
						$sql = "DELETE FROM usuario WHERE email='$var'";
						mysqli_query($conn, $sql);

						header('Location: ./index.php');
					}

				}

			}

			mysqli_close($conn);


		?>

		

	</body>

</html>