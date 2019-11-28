<?php
	if($_SESSION['tipo'] != 'gestor'){
		header('Location: ./index.php?menu=informacion');
	}

	class SolicitudCompra{
		
		function __construct($id, $estadoSolicitud, $fechaSolicitud, $mensaje, $disco, $nombre, $apellidos, $email, $telefono, $direccion, $tarjeta, $anioCaducidad, $mesCaducidad, $codigoSeguridad, $fechaAceptacion){			
			$this->id = $id;
			$this->estadoSolicitud = $estadoSolicitud;
			$this->fechaSolicitud = $fechaSolicitud;
			$this->mensaje = $mensaje;
			$this->disco = $disco;

			$this->nombre = $nombre;
			$this->apellidos = $apellidos;
			$this->email = $email;
			$this->telefono = $telefono;
			$this->direccion = $direccion;

			$this->tarjeta = $tarjeta;
			$this->anioCaducidad = $anioCaducidad;
            $this->mesCaducidad = $mesCaducidad;
			$this->codigoSeguridad = $codigoSeguridad;
            
            $this->fechaAceptacion = $fechaAceptacion;
		}


		function getId(){
			return $this->id;
		}

		function getEstadoSolicitud(){
			return $this->estadoSolicitud;
		}

		function getfechaSolicitud(){
			return $this->fechaSolicitud;
		}

		function getMensaje(){
			return $this->mensaje;
		}

		function getDisco(){
			return $this->disco;
		}


		function getNombre(){
			return $this->nombre;
		}

		function getApellidos(){
			return $this->apellidos;
		}

		function getEmail(){
			return $this->email;
		}

		function getTelefono(){
			return $this->telefono;
		}

		function getDireccion(){
			return $this->direccion;
		}


		function getTarjeta(){
			return $this->tarjeta;
		}

		function getAnioCaducidad(){
			return $this->anioCaducidad;
		}
        
        function getMesCaducidad(){
			return $this->mesCaducidad;
		}

		function getCodigoSeguridad(){
			return $this->codigoSeguridad;
		}

		function getfechaAceptacion(){
			return $this->fechaAceptacion;
		}

	}



	/*
		Aceptar/Rechazar solicitud compras
	*/
	if(isset($_POST['accion'])){
		$estadoSolicitud = $_POST['accion'];
		$id = $_POST['id'];
		$mensaje = $_POST['mensaje'];
        $fecha = "NULL";
        

		if($_POST['accion'] == "aceptada"){
			$mensaje = "Su solicitud de compra ha sido aceptada";
            $fecha = "DEFAULT";
		}
        

		mysqli_query($connection, "UPDATE solicitudesCompra SET mensaje='$mensaje', estadoSolicitud='$estadoSolicitud', fechaAceptacion=$fecha WHERE id='$id'");

	//	print_r(mysqli_error_list($connection));
		header('Location: ./index.php?menu=gestor');
	}



	/*
		Contenido
	*/

	echo '
		<div>
			<form class="tipoSolicitud" method="POST">
				<button '; if(isset($_POST['tipo']) && $_POST['tipo']=="pendiente") echo'id="seleccionado"'; echo' type="submit" action="./index.php?menu=gestor" name="tipo" value="pendiente">Mostrar solicitudes pendientes</button>
				<button '; if(isset($_POST['tipo']) && $_POST['tipo']=="aceptada") echo'id="seleccionado"'; echo' type="submit" action="./index.php?menu=gestor" name="tipo" value="aceptada">Mostrar solicitudes aceptadas</button>
				<button '; if(isset($_POST['tipo']) && $_POST['tipo']=="rechazada") echo'id="seleccionado"'; echo'type="submit" action="./index.php?menu=gestor" name="tipo" value="rechazada">Mostrar solicitudes rechazadas</button>
			</form>
		<div>
	';


	if(isset($_POST['tipo'])){

		$solicitudes = $consulta->getSolicitudesCompra($_POST['tipo']);    

		if($solicitudes != null){

			echo '<h3> Solicitudes '.$_POST['tipo'].'s</h3>';

			foreach ($solicitudes as $i) {
				
				echo '
					<div class="solicitudCompra">

						<div class="datosComprador">
                            <h3>Datos del comprador</h3>
							<p><span class=negrita>Nombre: </span>'.$i->getNombre().'</p>
							<p><span class=negrita>Apellidos: </span>'.$i->getApellidos().'</p>
							<p><span class=negrita>Email: </span>'.$i->getEmail().'</p>
							<p><span class=negrita>Teléfono: </span>'.$i->getTelefono().'</p>
							<p><span class=negrita>Dirección: </span>'.$i->getDireccion().'</p>
						</div>

						<div class="datosPago">
                            <h3>Datos de pago</h3>
							<p><span class=negrita>Número de tarjeta: </span>'.$i->getTarjeta().'</p>
							<p><span class=negrita>Año de caducidad: </span>'.$i->getAnioCaducidad().'</p>
                            <p><span class=negrita>Mes de caducidad: </span>'.$i->getMesCaducidad().'</p>
							<p><span class=negrita>Código de seguridad: </span>'.$i->getCodigoSeguridad().'</p>
						</div>

						<div class="datosCompra">
                            <h3>Datos de compra</h3>
							<p><span class=negrita>Disco solicitado: </span>'.$i->getDisco().'</p>
							<p><span class=negrita>Fecha de solicitud: </span>'.$i->getfechaSolicitud().'</p>';
                            if(isset($_POST['tipo']) && $_POST['tipo']=="aceptada"){
                                echo '<p><span class=negrita>Fecha de aceptación: </span>'.$i->getfechaAceptacion().'</p>';
                            }
							echo '<p><span class=negrita>Mensaje: </span>'.$i->getMensaje().'</p>
                            
						</div>

						<div>';

							if($_POST['tipo'] == "pendiente"){

								echo '

									<form class="opcionesSolicitudes" method="POST">
										<input type="hidden" name="tipo" value="'.$_POST['tipo'].'">
										<input type="hidden" name="id" value="'.$i->getId().'">
										<button class="aceptar" type="submit" action="./index.php?menu=gestor" name="accion" value="aceptada">Aceptar</button>
										<button class="rechazar" type="submit" action="./index.php?menu=gestor" name="accion" value="rechazada">Rechazar</button>
										<p>Razón de rechazo de la solicitud<input class="razon" type="text" name="mensaje"></p>
									</form>

								';

							}else{

								echo '

									<form class="opcionesSolicitudes" method="POST">
										<input type="hidden" name="tipo" value="'.$_POST['tipo'].'">
										<input type="hidden" name="id" value="'.$i->getId().'">
										<button class="pendiente" type="submit" action="./index.php?menu=gestor" name="accion" value="pendiente">Mover a pendientes</button>
									</form>

								';

							}
						
							echo'
						</div>

					</div>
				';

			}

		}else{
			echo'<h3>No se encontraron solicitudes '.$_POST['tipo'].'s </h3>';
		}	

		
	}

?>


