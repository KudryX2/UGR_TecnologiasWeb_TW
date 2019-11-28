<?php
	if($_SESSION['tipo'] != 'administrador'){
		header('Location: ./index.php?menu=cuentas');
	}

	echo "cosas de administrador";

?>