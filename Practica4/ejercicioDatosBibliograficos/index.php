<!DOCTYPE html>

<html>

	<head>
		<title></title>
	</head>

	<body>

		<?php

			echo '
				<form action="./index.php" method="get">
					<h3>Busqueda<input type="text" name="cadena"></h3>
					<input type="submit" name="" value="Buscar">
				</form>
			';

			if(isset($_GET["cadena"])){

				$busqueda = $_GET["cadena"];
				$busqueda = str_replace(' ', '+', $busqueda);


				$ch=curl_init();

				curl_setopt($ch, CURLOPT_URL, 'http://bencore.ugr.es/iii/encore/search?formids=target&lang=spi&suite=def&reservedids=lang%2Csuite&submitmode=&submitname=&target='.$busqueda);
				curl_setopt($ch, CURLOPT_HEADER, 'Content-Type: application/html');
				curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
				curl_setopt($ch, CURLOPT_AUTOREFERER, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_VERBOSE, true);

	        	$output = curl_exec($ch); 

	        	curl_close($ch);


	        	preg_match_all('/recordDisplayLink2Component[_0-9]*.*>[ \s]*(.*)<\/a.*[ \s]*<.*>[ \/]*(.*)<\/span><\/span>/', $output, $resultado, PREG_SET_ORDER);


	        	echo '<ul>';
	        	for($i = 0 ; $i < sizeof($resultado) ; $i++){
	        		echo '<li>';
	        		echo nl2br($resultado[$i][1]."\n".$resultado[$i][2]);
	        		echo '</li>';
	        	}
	        	echo '</ul>';

        	}

		?>
	
	</body>

</html>