<?php 

	class Disco{

		function __construct($nombre, $fecha, $caratula, $precio, $canciones){
			$this->nombre = $nombre;
			$this->fecha = $fecha;
			$this->caratula = $caratula;
			$this->precio = $precio;
            $this->canciones = $canciones;
		}

		function getNombre(){
			return $this->nombre;
		}

		function getFecha(){
			return $this->fecha;
		}

		function getCaratula(){
			return $this->caratula;
		}

		function getPrecio(){
			return $this->precio;
		}

        function getCanciones(){
			return $this->canciones;
		}
        
	}

	class Cancion{
		
		function __construct($nombre, $numero, $disco, $duracion){
			$this->nombre = $nombre;
			$this->numero = $numero;
            $this->disco = $disco;
            $this->duracion = $duracion;
		}

		function getNombre(){
			return $this->nombre;
		}		

		function getNumero(){
			return $this->numero;
		}
        
        function getDisco(){
			return $this->disco;
		}
        
        function getDuracion(){
			return $this->duracion;
		}

	}

    /*
        Comprar album
    */
    if(isset($_POST['comprar'])){
        $disco = $_POST['disco'];

        $nombre = $_POST['nombreComprador'];
        $apellidos = $_POST['apellidosComprador'];
        $email = $_POST['emailComprador'];
        $telefono = $_POST['telefonoComprador'];
        $direccion = $_POST['direccionComprador'];

        $tarjeta = $_POST['numeroTarjeta'];
        $anioCaducidad = $_POST['anioCaducidad'];
        $mesCaducidad = $_POST['mesCaducidad'];
        $codigoSeguridad = $_POST['seguridadTarjeta'];

        mysqli_query($connection, "INSERT INTO solicitudesCompra VALUES (DEFAULT, 'pendiente', DEFAULT, 'Pendiente de validar', '$disco', '$nombre', '$apellidos', '$email', '$telefono', '$direccion', '$tarjeta', '$anioCaducidad', '$mesCaducidad', '$codigoSeguridad', NULL)");

        print_r(mysqli_error_list($connection));
        //header('Location: ./index.php?menu=discografia');
    }

    if(isset($_POST['comprarAlbum'])){
        echo'

            <form class="formulario" method="POST">
                
                <fieldset>
                    <p>Se ha solicitado la compra del album : '.$_POST['comprarAlbum'].'</p>
                    <input type="hidden" name="disco" value="'.$_POST['comprarAlbum'].'">
                </fieldset>

                <fieldset>
                    <h3>Datos del comprador</h3>
                    
                    <p>Nombre: <input type="text" name="nombreComprador"></p>
                    <p>Apellidos: <input type="text" name="apellidosComprador"></p>
                    <p>Email: <input type="text" name="emailComprador"></p>
                    <p>Teléfono: <input type="text" name="telefonoComprador"></p>
                    <p>Dirección de envio: <input type="text" name="direccionComprador"></p>
                </fieldset>

                <fieldset>
                    <h3>Metodo de pago</h3>
                    
                    <p>Contra reembolso <input type="radio" name="metodoPago" value="contaReembolso"></p>
                    <p>Tarjeta de credito <input type="radio" name="metodoPago" value="tarjeta"></p>

                    <p>Numero de tarjeta: <input type="text" name="numeroTarjeta"></p>
                    <p>
                        Año de caducidad: <input type="number" name="anioCaducidad">
                        Mes de caducidad: <select name="mesCaducidad">
                            <option value=""></option>
                            <option value=enero>Enero</option>
                            <option value=febrero>Febrero</option>
                            <option value=marzo>Marzo</option>
                            <option value=abril>Abril</option>
                            <option value=mayo>Mayo</option>
                            <option value=junio>Junio</option>
                            <option value=julio>Julio</option>
                            <option value=agosto>Agosto</option>
                            <option value=septiembre>Septiembre</option>
                            <option value=octubre>Octubre</option>
                            <option value=noviembre>Noviembre</option>
                            <option value=diciembre>Diciembre</option>
                        </select>
                    </p>
                    
                    <p>Código de seguridad: <input type="text" name="seguridadTarjeta"></p>
                </fieldset>

                <fieldset>
                    <button type="submit" action="./index.php?menu=discografia" name="comprar">Solicitar compra</button>
                </fieldset>

            </form>

        ';
    }



    
    // Insertar disco
    if(isset($_POST['insertarDisco'])){
        $nombreDisco = $_POST['nombreNuevo'];
        $fecha = $_POST['fechaNuevo'];
        $caratula = $_POST['caratulaNuevo'];
        $precio = $_POST['precioNuevo'];
            
        mysqli_query($connection, "INSERT INTO discos VALUES ('$nombreDisco', '$fecha', '$caratula', '$precio')");
        registrarEnLog($connection, "Añadir disco");
        
        // Canciones
        $n = $_POST['numeroCanciones'];
        
        for ($i = 1; $i <= $n; $i++){
            $nombreCancion = $_POST['nombreCancion'.$i];
            $duracionCancion = $_POST['duracionCancion'.$i];
            
            mysqli_query($connection, "INSERT INTO canciones VALUES ('$nombreCancion', '$i', '$nombreDisco', '$duracionCancion')");
        }
      
    //    print_r(mysqli_error_list($connection));  
        header('Location: ./index.php?menu=discografia');
    }

    // Eliminar disco
    if(isset($_POST['eliminarDisco'])){
        $nombre = $_POST['eliminarDisco'];
		    
        mysqli_query($connection, "DELETE FROM discos WHERE nombre='$nombre'");
        
        // Eliminar canciones del disco
        mysqli_query($connection, "DELETE FROM canciones WHERE disco='$nombre'");
        
        registrarEnLog($connection, "Eliminar disco");
        
        header('Location: ./index.php?menu=discografia');
    }

    // Actualizar disco
	if(isset($_POST['actualizarDisco'])){
        $actualizar = $_POST['actualizarDisco'];    // Es el nombre del disco que se quiere actualizar
                
		$nombreDisco = $_POST['nombre'];
		$fecha = $_POST['fecha'];
		$caratula = $_POST['caratula'];
        
        // Actualización de canciones
        $canciones = $consulta->getCanciones($actualizar);
        foreach($canciones as $i){
            $cancionActualizar = $i->getNumero();
            
            if (isset($_POST['eliminarCancion'.$i->getNumero()])){
                mysqli_query($connection, "DELETE FROM canciones WHERE disco='$actualizar' AND numero='$cancionActualizar'");
                registrarEnLog($connection, "Eliminar canción");
            }else{
                $nombreCancion = $_POST['nombreCancion'.$cancionActualizar];
                $numeroCancion = $_POST['numeroCancion'.$cancionActualizar];
                $duracionCancion = $_POST['duracionCancion'.$cancionActualizar];

                // Esta comparación es para evitar que se acceda a la base de datos por cada canción si no se ha cambiado ningún dato
                if ($nombreCancion != $i->getNombre() || $numeroCancion != $i->getNumero() || $duracionCancion != $i->getDuracion()){
                    mysqli_query($connection, "UPDATE canciones SET nombre='$nombreCancion', numero='$numeroCancion', duracion='$duracionCancion' WHERE disco='$actualizar' AND  numero='$cancionActualizar'");
                    registrarEnLog($connection, "Editar canciones");
                }
            }
        }
        
        // Actualización de datos del disco
        mysqli_query($connection, "UPDATE discos SET nombre='$nombreDisco', fecha='$fecha', caratula='$caratula' WHERE nombre='$actualizar'");
        registrarEnLog($connection, "Editar disco");
        
        // Actualización del disco al que pertenecen las canciones (solo si se ha cambiado el nombre del disco)
        if ($nombreDisco != $actualizar){
            mysqli_query($connection, "UPDATE canciones SET disco='$nombreDisco' WHERE disco='$actualizar'");
        }
        
        // Nuevas canciones
        if (isset($_POST['numeroCancionesEditar'])){
            $n = $_POST['numeroCancionesEditar'];
            
            for($i = 1; $i <= $n; $i++){
                $nombreNueva = $_POST['nombreCancionNueva'.$i];
                $numeroNueva = $_POST['numeroCancionNueva'.$i];
                $duracionNueva = $_POST['duracionCancionNueva'.$i];

                mysqli_query($connection, "INSERT INTO canciones VALUES ('$nombreNueva', '$numeroNueva', '$nombreDisco', '$duracionNueva')");
                registrarEnLog($connection, "Añadir canción a disco");
            }
        }

		header('Location: ./index.php?menu=discografia');
	}
    
    // Editar precio
    if(isset($_POST['editarPrecio'])){
        $nombreDisco = $_POST['editarPrecio'];
        $nuevoPrecio = $_POST['nuevoPrecio'];
        
        mysqli_query($connection, "UPDATE discos SET precio='$nuevoPrecio' WHERE nombre='$nombreDisco'");
        registrarEnLog($connection, "Editar precio de disco");
        
        header('Location: ./index.php?menu=discografia');
    }



    // NUEVO DISCO
    if($_SESSION['tipo'] == 'administrador'){
        if (!isset($_POST['nuevoDisco']) && !isset($_POST['numeroCanciones'])){
            echo '
            <form class="editarComponente" method="POST">
                <button type="submit" action="./index.php?menu=discografia" name="nuevoDisco">Añadir nuevo disco</button>
            </form>';
        }else{
            echo '
                <form class="editarComponente" method="POST">
                    <p>Nombre: <input type="text" name="nombreNuevo"></p>
                    <p>Fecha: <input type="number" name="fechaNuevo"></p>
                    <p>Caratula: <input type="text" name="caratulaNuevo"></p>
                    <p>Precio: <input type="text" name="precioNuevo"></p>
                    <p>Introducir número de canciones: <input type="number" name="numeroCanciones"'; if(isset($_POST['numeroCanciones'])) echo ' value="'.$_POST['numeroCanciones'].'"'; echo '><button type="submit" action="./index.php?menu=discografia">Seleccionar</button></p>';
                    if (isset($_POST['numeroCanciones'])){
                        $n = $_POST['numeroCanciones'];
                        for ($i = 1; $i <= $n; $i++){
                            echo '
                            <p>Nombre canción '.$i.': <input type="text" name="nombreCancion'.$i.'"> 
                                Duración: <input type="text" name="duracionCancion'.$i.'">'; if ($i == 1 ) echo ' (Formato: mm:ss)
                            </p>';
                        }
                    }
                    echo '<button type="submit" action="./index.php?menu=discografia" name="insertarDisco">Añadir</button> 
                </form>
            ';
        }
    }

	$discos = $consulta->getDiscos();    

	echo'<h2>Discografía</h2>';
		
    foreach ($discos as $i) {
        
        // VISUALIZACIÓN DE DISCOS
        if(!isset($_POST['editarDisco']) || $_POST['editarDisco'] != $i->getNombre()){

            echo '
            <div class="discografia">

                <div class="discografiaImagen">
                    <img src='.$i->getCaratula().'>
                </div>

                <div class="disco">

                    <h2>'.$i->getNombre().' ('.$i->getFecha().')</h2>

                    <div class="canciones">
                        <ol>';

                        $canciones = $i->getCanciones();
                            if($canciones != null){
                            foreach($canciones as $j){
                                echo '<li>'.$j->getNombre().' <span> '.$j->getDuracion().'</span></li>';
                            }
                        }

                        echo '</ol>
                    </div>';

                    if($_SESSION['tipo'] == 'administrador'){
                        echo '
                        <form method="POST">
                            <button class="eliminar" type="submit" action="./index.php?menu=discografia" name="eliminarDisco" value="'.$i->getNombre().'">
                                <img src="http://contraloriadelmagdalena.gov.co/contratacion/imagenes/botones/eliminar.png"/>
                            </button>
                            <button class="editar" type="submit" action="./index.php?menu=discografia" name="editarDisco" value="'.$i->getNombre().'">
                                <img src="https://cdn.icon-icons.com/icons2/841/PNG/512/flat-style-circle-edit_icon-icons.com_66939.png"/>
                            </button>
                        </form>';
                    }
                    
                    echo '<form action="" method="POST">';
            
                    // Editar precio
                    if ($_SESSION['tipo'] == 'gestor'){
                        echo '
                        <p>
                            Precio: <input type="text" name="nuevoPrecio" value="'.$i->getPrecio().'"> 
                            <button class=comprar type="submit" name="editarPrecio" value="'.$i->getNombre().'">Editar precio</button>
                        </p>';
                    }else{
                        echo '<button class=comprar type="submit" name="comprarAlbum" value="'.$i->getNombre().'">Comprar '.$i->getPrecio().'€ </button>';
                    }
            
                    echo '</form>
                    
                </div>
            </div>';

        }else{ // EDICIÓN DE DISCOS
            echo '

                <form class="editarDisco" action="" method="POST">
                    <p>Nombre: <input type="text" name="nombre" value="'.$i->getNombre().'"></p>
                    <p>Año de lanzamiento: <input type="number" name="fecha" value="'.$i->getFecha().'"></p>
                    <p>Imagen de carátula: <input type="text" name="caratula" value="'.$i->getCaratula().'"></p>';

                    $canciones = $i->getCanciones();
                    
                    if($canciones != null){
                        foreach($canciones as $j){
                            echo '<p>Canción '.$j->getNumero().': <input type="text" name="nombreCancion'.$j->getNumero().'" value="'.$j->getNombre().'"> 
                                    Número: <input type="text" name="numeroCancion'.$j->getNumero().'" value="'.$j->getNumero().'">
                                    Duración: <input type="text" name="duracionCancion'.$j->getNumero().'" value="'.$j->getDuracion().'">
                                    Eliminar <input type="checkbox" name="eliminarCancion'.$j->getNumero().'">
                            </p>';
                        }
                    }

                    echo '<p>Introducir número de canciones a añadir: <input type="number" name="numeroCancionesEditar"'; if(isset($_POST['numeroCancionesEditar'])) echo ' value="'.$_POST['numeroCancionesEditar'].'"'; echo '><button type="submit" action="./index.php?menu=discografia">Seleccionar</button></p>';
                    if (isset($_POST['numeroCancionesEditar'])){
                        $n = $_POST['numeroCancionesEditar'];
                        for ($j = 1; $j <= $n; $j++){
                            echo '
                            <p>Nombre canción: <input type="text" name="nombreCancionNueva'.$j.'">
                                Número: <input type="number" name="numeroCancionNueva'.$j.'">
                                Duración: <input type="text" name="duracionCancionNueva'.$j.'">'; if ($j == 1 ) echo ' (Formato: mm:ss)
                            </p>';
                        }
                    }
                    // Para almacenar el nombre sin editar del disco que se está actualizando
                    echo '<input type="hidden" name="editarDisco" value="'.$i->getNombre().'">
                    
                    <p><button type="submit" action="./index.php?menu=discografia" name="actualizarDisco" value="'.$i->getNombre().'">Editar</button></p>

                </form>
            ';


    }

        
	}

?>