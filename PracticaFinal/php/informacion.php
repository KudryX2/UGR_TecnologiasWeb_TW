<?php 
	class Componente{

		function __construct($nombre, $fechaNacimiento, $lugarNacimiento, $foto, $biografia){
			$this->nombre = $nombre;
			$this->fechaNacimiento = $fechaNacimiento;
			$this->lugarNacimiento = $lugarNacimiento;
			$this->foto = $foto;
			$this->biografia = $biografia;
		}

		function getNombre(){
			return $this->nombre;
		}

		function getFechaNacimiento(){
			return $this->fechaNacimiento;
		}

		function getLugarNacimiento(){
			return $this->lugarNacimiento;
		}

		function getFoto(){
			return $this->foto;
		}

		function getBiografia(){
			return $this->biografia;
		}

	}

	class Biografia{
		
		function __construct($fecha, $descripcion, $identificador){
			$this->fecha = $fecha;
			$this->descripcion = $descripcion;
            $this->identificador = $identificador;
		}

		function getFecha(){
			return $this->fecha;
		}		

		function getDescripcion(){
			return $this->descripcion;
		}
        
        function getIdentificador(){
			return $this->identificador;
		}

	}

    $componentes = $consulta->getComponentes();
    $biografia = $consulta->getBiografia();


    // ACTUALIZACIÓN DE COMPONENTES
	if(isset($_POST['actualizarComponente'])){
        $actualizar = $_POST['actualizarComponente'];   // Es el nombre del componente que se quiere actualizar
        
		$nombre = $_POST['nombre'];
		$fechaNacimiento = $_POST['fechaNacimiento'];
		$lugarNacimiento = $_POST['lugarNacimiento'];
        $foto = $_POST['foto'];
		$biografia = $_POST['biografia'];
		
        echo'
            <script type="text/javascript">
                validarComponente();
            </script>
        ';

		mysqli_query($connection, "UPDATE componentes SET nombre='$nombre', fechaNacimiento='$fechaNacimiento', lugarNacimiento='$lugarNacimiento', biografia='$biografia', foto='$foto' WHERE nombre='$actualizar'");
        registrarEnLog($connection, "Editar componente");

		header('Location: ./index.php?menu=informacion');
	}
    // Insertar componente
    if(isset($_POST['insertarComponente'])){
        $nombre = $_POST['nombreNuevo'];
		$fechaNacimiento = $_POST['fechaNuevo'];
		$lugarNacimiento = $_POST['lugarNuevo'];
        $foto = $_POST['fotoNuevo'];
		$biografia = $_POST['biografiaNuevo'];
		    
        mysqli_query($connection, "INSERT INTO componentes VALUES ('$nombre', '$fechaNacimiento', '$lugarNacimiento', '$foto', '$biografia')");
        registrarEnLog($connection, "Añadir componente");
        
        header('Location: ./index.php?menu=informacion');
    }
    // Eliminar componente
    if(isset($_POST['eliminarComponente'])){
        $nombre = $_POST['eliminarComponente'];
		    
        mysqli_query($connection, "DELETE FROM componentes WHERE nombre='$nombre'");
        registrarEnLog($connection, "Eliminar componente");
        
        header('Location: ./index.php?menu=informacion');
    }



    // ACTUALIZACIÓN DE BIOGRAFÍA
    if(isset($_POST['actualizarBiografia'])){
        
        // Actualizar o eliminar entradas
		foreach($biografia as $i){
            $identificador = $i->getIdentificador();
            if (isset($_POST['eliminarEntrada'.$identificador])){
                mysqli_query($connection, "DELETE FROM biografia WHERE identificador='$identificador'");
                registrarEnLog($connection, "Eliminar entrada biografía");
            }else{
                $fecha = $_POST['fecha'.$identificador];
                if ($fecha == "") $fecha = "NULL";
                $descripcion = $_POST['descripcion'.$identificador];

                // Esta comparación es para evitar que se acceda a la base de datos por cada entrada si no se ha cambiado ningún dato
                if ($fecha != $i->getFecha() || $descripcion != $i->getDescripcion()){
                    mysqli_query($connection, "UPDATE biografia SET fecha=$fecha, descripcion='$descripcion' WHERE identificador='$identificador'");
                    registrarEnLog($connection, "Editar entrada biografía");
                }
            }
        }
        
        // Introducir nueva entrada
        $fechaNueva = $_POST['fechaNueva'];
        if ($fechaNueva == "") $fechaNueva = "NULL";
        $descripcionNueva = $_POST['descripcionNueva'];
        
        $identificadorNueva = 0;
        $query = mysqli_query($connection, "SELECT identificador FROM biografia ORDER by identificador ASC");

        // Este bucle busca un identificador libre en la tabla
        while($output = mysqli_fetch_row($query)){
            if($identificadorNueva == $output[0]){
                $identificadorNueva += 1;
            }
        }
        
        if ($descripcionNueva != ""){
            mysqli_query($connection, "INSERT INTO biografia VALUES ($fechaNueva, '$descripcionNueva', '$identificadorNueva')");
            registrarEnLog($connection, "Añadir entrada biografía");
        }

		header('Location: ./index.php?menu=informacion');
	}

    
    // NUEVO COMPONENTE
    if($_SESSION['tipo'] == 'administrador'){
        if (!isset($_POST['nuevoComponente'])){
            echo '
            <form class="editarComponente" method="POST">
                <button type="submit" action="./index.php?menu=informacion" name="nuevoComponente">Añadir nuevo componente</button>
            </form>';
        }else{
            echo '
                <form class="editarComponente" method="POST">
                    <p>Nombre: <input type="text" name="nombreNuevo"></p>
                    <p>Fecha de nacimiento: <input type="text" name="fechaNuevo"> (Formato: YYYY-MM-DD)</p>
                    <p>Lugar de nacimiento: <input type="text" name="lugarNuevo"></p>
                    <p>Biografia: <input type="text" name="biografiaNuevo"></p>
                    <p>Foto: <input type="text" name="fotoNuevo"></p>

                    <button type="submit" action="./index.php?menu=informacion" name="insertarComponente">Añadir</button> 
                </form>
            ';
        }
    }
	
    

    echo'<h2>Integrantes del grupo</h2>';

	foreach ($componentes as $i) {

        // VISUALIZACIÓN DE COMPONENTES
        if(!isset($_POST['editarComponente']) || $_POST['editarComponente'] != $i->getNombre()){

            echo '<div class="componentes">

                <div class="componentesImagen">
                    <img src='.$i->getFoto().'>
                </div>

                <div class="informacion">

                    <h2>'.$i->getNombre().'</h2>
                    <h2>'.$i->getLugarNacimiento().'</h2>
                    <h2>'.$i->getFechaNacimiento().'</h2>
                    <p>'.$i->getBiografia().'</p>
                    ';
                    if($_SESSION['tipo'] == 'administrador'){
                        echo '
                        <form method="POST">
                            <button class="eliminar" type="submit" action="./index.php?menu=informacion" name="eliminarComponente" value="'.$i->getNombre().'">
                                <img src="http://contraloriadelmagdalena.gov.co/contratacion/imagenes/botones/eliminar.png"/>
                            </button>
                            
                            <button type="submit" action="./index.php?menu=informacion" name="editarComponente" value="'.$i->getNombre().'">
                                <img src="https://cdn.icon-icons.com/icons2/841/PNG/512/flat-style-circle-edit_icon-icons.com_66939.png"/>
                            </button>
                        </form>';
                    }

                echo'</div>
            </div>
            ';


        }else{  

            // EDICIÓN DE COMPONENTES
            echo '

                <form class="editarComponente"  action="./index.php?menu=informacion" method="POST" onsubmit="return validarComponente();">
                    <p>Nombre: <input id="nombreInput" type="text" name="nombre" value="'.$i->getNombre().'"></p>
                    <p>Fecha de nacimiento: <input id="fechaInput" type="text" name="fechaNacimiento" value="'.$i->getFechaNacimiento().'"> (Formato: YYYY-MM-DD)</p>
                    <p>Lugar de nacimiento: <input id="lugarInput" type="text" name="lugarNacimiento" value="'.$i->getLugarNacimiento().'"></p>
                    <p>Biografia: <input id="biografiaInput" type="text" name="biografia" value="'.$i->getBiografia().'"></p>
                    <p>Foto: <input id="fotoInput" type="text" name="foto" value="'.$i->getFoto().'"></p>
                    <button type="submit" action="./index.php?menu=informacion" name="actualizarComponente" value="'.$i->getNombre().'">Editar</button> 
                </form>
                
            ';
        }
	}



	echo '<h2>Biografía del grupo</h2>';

    echo '<div id="biografia">';

        // VISUALIZACIÓN DE BIOGRAFÍA
        if(!isset($_POST['editarBiografia'])){
            foreach ($biografia as $i) {
                echo '<p>';
                if($i->getFecha() != null) echo '<span class="fecha">'.$i->getFecha().'</span> : '; 
                echo $i->getDescripcion().'</p>';
            }

            if($_SESSION['tipo'] == 'administrador'){
                echo '
                <form method="POST">
                    <button type="submit" action="./index.php?menu=informacion#biografia" name="editarBiografia" value="">
                        <img src="https://cdn.icon-icons.com/icons2/841/PNG/512/flat-style-circle-edit_icon-icons.com_66939.png"/>
                    </button>
                </form>';
            }
        }else{ // EDICIÓN DE BIOGRAFÍA
            echo '<form class="editarBiografia" method="POST">';
            
            foreach ($biografia as $i) {
                echo '
                <p>
                Año: <input type="number" name="fecha'.$i->getIdentificador().'" value="'.$i->getFecha().'">
                Descripción: <input type="text" name="descripcion'.$i->getIdentificador().'" value="'.$i->getDescripcion().'">
                Eliminar <input type="checkbox" name="eliminarEntrada'.$i->getIdentificador().'">
                </p>';
            }
            
            echo '
                <p>
                Añadir entrada --- Año: <input type="number" name="fechaNueva">
                Descripcion: <input type="text" name="descripcionNueva"> 
                </p>

                <button type="submit" action="./index.php?menu=informacion" name="actualizarBiografia">Editar</button> 

            </form>';
        }

    echo '</div>';



?>