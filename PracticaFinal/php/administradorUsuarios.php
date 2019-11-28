<?php

	if($_SESSION['tipo'] != 'administrador'){
		header('Location: ./index.php?menu=cuentas');
	}

	class Usuario{
		
		function __construct($nombre, $apellidos, $telefono, $email, $login, $pass, $tipo){
			$this->nombre = $nombre;
			$this->apellidos = $apellidos;
			$this->telefono = $telefono;
			$this->email = $email;
			$this->login = $login;
			$this->pass = $pass;
			$this->tipo = $tipo;
		}

		function getNombre(){
			return $this->nombre;
		}

		function getApellidos(){
			return $this->apellidos;
		}

		function getTelefono(){
			return $this->telefono;
		}

		function getEmail(){
			return $this->email;
		}

		function getLogin(){
			return $this->login;
		}

		function getPass(){
			return $this->pass;
		}

		function getTipo(){
			return $this->tipo;
		}

	}

    // Insertar usuario
    if(isset($_POST['insertarUsuario'])){
        $nombre = $_POST['nombreNuevo'];
		$apellidos = $_POST['apellidosNuevo'];
		$telefono = $_POST['telefonoNuevo'];
		$email = $_POST['emailNuevo'];
		$login = $_POST['loginNuevo'];
		$pass = $_POST['passNuevo'];
		$tipo = $_POST['tipoNuevo'];
		    
        mysqli_query($connection, "INSERT INTO usuarios VALUES ('$nombre', '$apellidos', '$telefono', '$email', '$login', '$pass', '$tipo')");
        registrarEnLog($connection, "Añadir usuario");

        header('Location: ./index.php?menu=administradorUsuarios');
    }

    if(isset($_POST['eliminarUsuario'])){
    	$login = $_POST['eliminarUsuario'];
		    
        mysqli_query($connection, "DELETE FROM usuarios WHERE login='$login'");
        registrarEnLog($connection, "Eliminar usuario");
        
        header('Location: ./index.php?menu=administradorUsuarios');
    }

    if(isset($_POST['actualizarUsuario'])){
		$actualizar = $_POST['actualizarUsuario']; 

		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$telefono = $_POST['telefono'];
		$email = $_POST['email'];
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		$tipo = $_POST['tipo'];
		
        // Se actualiza la variable usuario para que siga coincidiendo
        if ($actualizar == $_SESSION['usuario']){
            $_SESSION['usuario'] = $login;
        }
        
		mysqli_query($connection, "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', telefono='$telefono', email='$email', login='$login', pass='$pass', tipo='$tipo' WHERE login='$actualizar'");
        registrarEnLog($connection, "Editar usuario");

		header('Location: ./index.php?menu=administradorUsuarios');
    }


	if (!isset($_POST['nuevoUsuario'])){
        echo '
        <form class="editarComponente" method="POST">
            <button type="submit" action="./index.php?menu=administradorUsuarios" name="nuevoUsuario">Añadir nuevo usuario</button>
        </form>';
    }else{
        echo '
            <form class="editarComponente" method="POST">
                <p>Nombre: <input type="text" name="nombreNuevo"></p>
                <p>Apellidos: <input type="text" name="apellidosNuevo"></p>
                <p>Teléfono: <input type="text" name="telefonoNuevo"></p>
                <p>Email: <input type="text" name="emailNuevo"></p>
                <p>Login: <input type="text" name="loginNuevo"></p>
                <p>Contraseña: <input type="text" name="passNuevo"></p>
                <p>Tipo de usuario:
                	<select name="tipoNuevo">
                		<option value="administrador">Administrador</option>
                		<option value="gestor">Gestor</option>  
                	</select>
                </p>

                <button type="submit" action="./index.php?menu=administradorUsuarios" name="insertarUsuario">Añadir usuario</button> 
            </form>
        ';
    }


   	$usuarios = $consulta->getUsuarios();    


	echo'<h3>Usuarios registrados en el sistema</h3>';

    echo '<div id=listaUsuarios>';

        foreach ($usuarios as $i) {

        	if(!isset($_POST['editarUsuario']) || $_POST['editarUsuario'] != $i->getLogin()){

	            echo '

	            <div class="usuarioVistaAdministrador">
	            
	                <div class="datos1">
	                    <p>'.$i->getNombre().'</p>
	                    <p>'.$i->getApellidos().'</p>
	                    <p>'.$i->getTelefono().'</p>
	                    <p>'.$i->getEmail().'</p>
	                </div>

	                <div class="datos2">
	                    <p>'.$i->getLogin().'</p>
	                    <p>'.$i->getPass().'</p>
	                    <p>'.$i->getTipo().'</p>
	                </div>

	                <form method="POST">

	                    <button type="submit" action="./index.php?menu=administradorUsuarios" name="editarUsuario" value="'.$i->getLogin().'">
	                        <img src="https://cdn.icon-icons.com/icons2/841/PNG/512/flat-style-circle-edit_icon-icons.com_66939.png"/>
	                    </button>';

                        if ($_SESSION['usuario'] != $i->getLogin()){
                            echo '<button type="submit" action="./index.php?menu=administradorUsuarios" name="eliminarUsuario" value="'.$i->getLogin().'">
                                <img src="http://contraloriadelmagdalena.gov.co/contratacion/imagenes/botones/eliminar.png"/>
                            </button>';
                        }
                            

	                echo '</form>

	            </div>';
        
        	}else{
        
        		 echo '

	                <form class="editarComponente" method="POST">
	                    <p>Nombre: <input type="text" name="nombre" value="'.$i->getNombre().'"></p>
	                    <p>Apellidos: <input type="text" name="apellidos" value="'.$i->getApellidos().'"></p>
	                    <p>Teléfono: <input type="text" name="telefono" value="'.$i->getTelefono().'"></p>
	                    <p>Email: <input type="text" name="email" value="'.$i->getEmail().'"></p>
	                    <p>Login: <input type="text" name="login" value="'.$i->getLogin().'"></p>
	                    <p>Contraseña: <input type="text" name="pass" value="'.$i->getPass().'"></p>';
                        if ($_SESSION['usuario'] != $i->getLogin()){
                            echo '
                            <p>Tipo de usuario:
                                <select name="tipo">
                                    <option'; if($i->getTipo()=='administrador') echo' selected="selected"'; echo' value="administrador">Administrador</option>
                                    <option'; if($i->getTipo()=='gestor') echo' selected="selected"'; echo' value="gestor">Gestor</option>  
                                </select>
                            </p>';
                        }else{
                            echo '
                            <p>Tipo de usuario: Administrador (Nota: no puedes cambiar tu propio tipo de usuario)</p>
                            ';
                        }

	                    echo '<button type="submit" action="./index.php?menu=administradorUsuarios" name="actualizarUsuario" value="'.$i->getLogin().'">Editar</button> 

	                </form>
            	';
        	}

        }

    echo '</div>';

?>