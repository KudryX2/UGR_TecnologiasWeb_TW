<?php

	class Log{

		function __construct($id, $fecha, $usuario, $accion){
			$this->id = $id;
			$this->fecha = $fecha;
			$this->usuario = $usuario;
			$this->accion = $accion;
		}

		function getId(){
			return $this->id;
		}

		function getFecha(){
			return $this->fecha;
		}

		function getUsuario(){
			return $this->usuario;
		}

		function getAccion(){
			return $this->accion;
		}

	}

	$solicitudes = $consulta->getLog();    


	foreach ($solicitudes as $i) {
		
		echo'
			
			<div class="log">
				<p>Fecha: '.$i->getFecha().'</p>
				<p>Usuario: '.$i->getUsuario().'</p>
				<p>Acción: '.$i->getAccion().'</p>
			</div>

		';

	}


?>