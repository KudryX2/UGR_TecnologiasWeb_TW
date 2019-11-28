<?php 

	class Concierto{

		function __construct($fecha, $hora, $lugar, $descripcion){
			$this->fecha = $fecha;
			$this->hora = $hora;
			$this->lugar = $lugar;
			$this->descripcion = $descripcion;
		}

		function getFecha(){
			return $this->fecha;
		}

		function getHora(){
			return $this->hora;
		}

		function getLugar(){
			return $this->lugar;
		}

		function getDescripcion(){
			return $this->descripcion;
		}

	}

	// Insertar concierto
    if(isset($_POST['insertarConcierto'])){
        $fecha = $_POST['fechaNuevo'];
		$hora = $_POST['horaNuevo'];
		$lugar = $_POST['lugarNuevo'];
        $descripcion = $_POST['descripcionNuevo'];
		    
        mysqli_query($connection, "INSERT INTO conciertos VALUES ('$fecha', '$hora', '$lugar', '$descripcion')");
        registrarEnLog($connection, "Añadir concierto");
        
        header('Location: ./index.php?menu=conciertos');
    }

    // Editar concierto
    if(isset($_POST['actualizarConcierto'])){
    	
    	$actualizar = $_POST['actualizarConcierto'];   

    	$fecha = $_POST['fecha'];
		$hora = $_POST['hora'];
		$lugar = $_POST['lugar'];
        $descripcion = $_POST['descripcion'];

        mysqli_query($connection, "UPDATE conciertos SET fecha='$fecha', hora='$hora', lugar='$lugar', descripcion='$descripcion' WHERE fecha='$actualizar'");
        registrarEnLog($connection, "Editar concierto");

    	header('Location: ./index.php?menu=conciertos');
    
    }

    if(isset($_POST['eliminarConcierto'])){
		$eliminar = $_POST['eliminarConcierto'];
		    
        mysqli_query($connection, "DELETE FROM conciertos WHERE fecha='$eliminar'");
        registrarEnLog($connection, "Eliminar concierto");
        
        header('Location: ./index.php?menu=conciertos');
    }


	// NUEVO CONCIERTO
    if($_SESSION['tipo'] == 'administrador'){
        if (!isset($_POST['nuevoConcierto'])){
            echo '
            <form class="editarComponente" method="POST">
                <button type="submit" action="./index.php?menu=conciertos" name="nuevoConcierto">Añadir nuevo concierto</button>
            </form>';
        }else{
            echo '
                <form class="editarComponente" method="POST">
                    <p>Fecha: <input type="text" name="fechaNuevo"> (Formato: YYYY-MM-DD)</p>
                    <p>Hora: <input type="text" name="horaNuevo"></p>
                    <p>Lugar: <input type="text" name="lugarNuevo"></p>
                    <p>Descripción: <input type="text" name="descripcionNuevo"></p>

                    <button type="submit" action="./index.php?menu=informacion" name="insertarConcierto">Añadir</button> 
                </form>
            ';
        }
        
    }



	$conciertos = $consulta->getConciertos();

	echo'<h2>Próximos conciertos</h2>';

    if ($_SESSION['tipo'] == null){
        $query = mysqli_query($connection, "SELECT lugar FROM conciertos GROUP BY lugar");
        $ciudades;

        while($output = mysqli_fetch_row($query)){
            $ciudades[] = $output[0];
        }
        echo '
        <form class="editarComponente" method="POST">
            <select name=ciudad>
                <option></option>';
                foreach ($ciudades as $i){
                    echo '<option value="'.$i.'" '; if (isset($_POST['ciudad']) && $_POST['ciudad'] == $i) echo 'selected'; echo '>'.$i.'</option>';
                }
            echo '</select>
            <button type="submit" action="./index.php?menu=conciertos" name="buscadorCiudad">Filtrar por ciudad</button>
            
            <span>Fecha inicial (Formato: YYYY-MM-DD): <input type="text" action="./index.php?menu=conciertos" name="fechaInicial"></span>
            <span>Fecha final: <input type="text" action="./index.php?menu=conciertos" name="fechaFinal"></span>
            <button type="submit" action="./index.php?menu=conciertos" name="buscadorFecha">Filtrar por fecha</button>
            
            <button type="submit" action="./index.php?menu=conciertos">Mostrar todos</button>
        </form>';
    }

    if (isset($_POST['buscadorFecha'])){
        $fechaInicial = $_POST['fechaInicial'];
        $fechaFinal = $_POST['fechaFinal'];
    }
    else{
        $fechaInicial = null;
        $fechaFinal = null;
    }

	foreach ($conciertos as $i) {
		
		if(!isset($_POST['editarConcierto']) || $_POST['editarConcierto'] != $i->getFecha()){

            // Si no se está buscando o si se está buscando y coincide con el filtro, se muestra la información
            if (!isset($_POST['buscadorCiudad']) && !isset($_POST['buscadorFecha']) ||
                (isset($_POST['buscadorCiudad']) && ($_POST['ciudad'] == $i->getLugar() || $_POST['ciudad'] == ""))||
                ((isset($_POST['buscadorFecha'])) && (strtotime($fechaInicial) < strtotime($i->getFecha())) && (strtotime($fechaFinal) > strtotime($i->getFecha())))){
                
                echo '
                    <div class="concierto">
                        <div class="ubicacion">
                            <h3>'.$i->getFecha().' </h3>
                            <h3>'.$i->getHora().' </h3>
                            <h3>'.$i->getLugar().' </h3>
                        </div>

                        <p>'.$i->getDescripcion().'</p>

                        ';
                        if($_SESSION['tipo'] == 'administrador'){
                            echo '
                            <form method="POST">
                                <button type="submit" action="./index.php?menu=conciertos" name="editarConcierto" value="'.$i->getFecha().'">
                                    <img src="https://cdn.icon-icons.com/icons2/841/PNG/512/flat-style-circle-edit_icon-icons.com_66939.png"/>
                                </button>

                                <button type="submit" action="./index.php?menu=conciertos" name="eliminarConcierto" value="'.$i->getFecha().'">
                                    <img src="http://contraloriadelmagdalena.gov.co/contratacion/imagenes/botones/eliminar.png"/>
                                </button>
                            </form>';
                        }

                        echo '
                    </div>
                ';
            }

		}else{
			// EDITAR CONCIERTO
			 echo '
                <form class="editarComponente" method="POST">
                    <p>Fecha: <input type="text" name="fecha" value="'.$i->getFecha().'"> (Formato: YYYY-MM-DD)</p>
                    <p>Hora: <input type="text" name="hora" value="'.$i->getHora().'"> </p>
                    <p>Lugar: <input type="text" name="lugar" value="'.$i->getLugar().'"></p>
                    <p>Descripción: <input type="text" name="descripcion" value="'.$i->getDescripcion().'"></p>

                    <button type="submit" action="./index.php?menu=conciertos" name="actualizarConcierto" value="'.$i->getFecha().'">Editar</button> 

                </form>
            ';

		}

	}



?>