<?php

	class Consulta{

		function __construct($connection){
			$this->connection = $connection;
		}

		function getComponentes(){

			$componentes;
			$query = mysqli_query($this->connection, "SELECT * FROM componentes");

			while($output = mysqli_fetch_row($query)){
				$componentes[] = new Componente($output[0],$output[1],$output[2],$output[3],$output[4]); 
			}

			return $componentes;
		}

		function getBiografia(){
			$biografia;
			$query = mysqli_query($this->connection, "SELECT * FROM biografia ORDER by fecha ASC");

			while($output = mysqli_fetch_row($query)){
				$biografia[] = new Biografia($output[0],$output[1],$output[2]); 
			}

			return $biografia;
		}

        function getDiscos(){
			$disco;
            $canciones = array();
                
			$query = mysqli_query($this->connection, "SELECT * FROM discos ORDER by fecha ASC");

			while($output = mysqli_fetch_row($query)){
                $canciones = $this->getCanciones($output[0]);
				$disco[] = new Disco($output[0],$output[1],$output[2],$output[3],$canciones); 
			}

			return $disco;
		}
        
        function getCanciones($disco){
			$canciones;
			$query = mysqli_query($this->connection, "SELECT * FROM canciones WHERE disco='$disco' ORDER by numero ASC");

			$canciones = null;

			while($output = mysqli_fetch_row($query)){
				$canciones[] = new Cancion($output[0],$output[1],$output[2],$output[3]); 
			}

			return $canciones;
		}

		function getConciertos(){
			$conciertos = null;
			$query = mysqli_query($this->connection, "SELECT * FROM conciertos ORDER by fecha ASC");

			while($output = mysqli_fetch_row($query)){
				$conciertos[] = new Concierto($output[0],$output[1],$output[2],$output[3]);
			}

			return $conciertos;
		}

		function getUsuarios(){
			$usuarios = null;
			$query = mysqli_query($this->connection, "SELECT * FROM usuarios ORDER by tipo ASC");

			while($output = mysqli_fetch_row($query)){
				$usuarios[] = new Usuario($output[0],$output[1],$output[2],$output[3],$output[4],$output[5],$output[6]);
			}

			return $usuarios;
		}

		function getSolicitudesCompra($tipo){
			$solicitudes = null;
			$query = mysqli_query($this->connection, "SELECT * FROM solicitudesCompra WHERE estadoSolicitud = '$tipo' ORDER by fechaSolicitud ASC");

			while($output = mysqli_fetch_row($query)){
				$solicitudes[] = new SolicitudCompra($output[0],$output[1],$output[2],$output[3],$output[4],$output[5],$output[6],$output[7],$output[8],$output[9],$output[10],$output[11],$output[12],$output[13],$output[14]);
			}

			return $solicitudes;
		}

		function getLog(){
			$log = null;

			$query = mysqli_query($this->connection, "SELECT * FROM log ORDER by fecha DESC");
	
			while($output = mysqli_fetch_row($query)){
				$log[] = new Log($output[0],$output[1],$output[2],$output[3]);
			}

			return $log;
		}
		

	}


	function registrarEnLog($connection, $accion){

		IF(isset($_SESSION['usuario'])){
			$usuario = $_SESSION['usuario'];
		}else{
			$usuario = "guest";
		}

		mysqli_query($connection, "INSERT INTO log VALUES (DEFAULT, DEFAULT, '$usuario', '$accion')");

	//	print_r(mysqli_error_list($connection));
	}


	$consulta = new Consulta($connection);

	if($menu == 'discografia'){
		include "./php/discografia.php";
	}else if($menu == 'conciertos'){
		include "./php/conciertos.php";
	}else if($menu == 'cuentas'){
		include "./php/cuentas.php";
	}else if($menu == 'gestor'){
		include "./php/gestor.php";
	}else if($menu == 'administradorUsuarios'){
		include "./php/administradorUsuarios.php";
	}else if($menu == 'administradorLog'){
		include "./php/administradorLog.php";
	}else{
		include "./php/informacion.php";
	}

?>