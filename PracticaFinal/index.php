<!DOCTYPE html>
<html>
	
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./css/general.css"/>
		<link rel="stylesheet" type="text/css" href="./css/informacion.css"/>
        <link rel="stylesheet" type="text/css" href="./css/discografia.css"/>
        <link rel="stylesheet" type="text/css" href="./css/conciertos.css"/>
        <link rel="stylesheet" type="text/css" href="./css/administradorUsuarios.css"/>
        <link rel="stylesheet" type="text/css" href="./css/gestor.css"/>
        <link rel="stylesheet" type="text/css" href="./css/administradorLog.css"/>

        <script src="./javaScript/funciones.js"></script>


		<title>Linkin Park</title>
	</head>

	<body>

		
		<?php
			/*
				Conectarse a base de datos
			*/
			require "./php/connectBD.php";
       

			/*
                Declaración de variables
            */
			if(isset($_GET['menu'])){
				$menu = $_GET['menu'];
			}else{
				$menu = 'informacion';
			}

			if(!isset($_SESSION['login'])){
				$_SESSION['login'] = false;
				$_SESSION['tipo'] = null;
			}

            
            /*
				Generar html
			*/
			require "./php/header.php";

			require "./php/body.php";

			include "./php/footer.php";

		?>

	</body>

</html>