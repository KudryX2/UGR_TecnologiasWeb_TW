<?php
	
	echo '
		<header>

			<img src="http://as01.epimg.net/tikitakas/imagenes/2017/02/16/portada/1487264551_879292_1487264812_noticia_normal.jpg">

			<nav>
				<ul>
					<a '; if($menu == 'informacion') echo'id="seleccionado"'; echo'href="index.php?menu=informacion"><li>Información</li></a>
					<a '; if($menu == 'discografia') echo'id="seleccionado"'; echo'href="index.php?menu=discografia"><li>Discografía</li></a>
					<a '; if($menu == 'conciertos') echo'id="seleccionado"'; echo'href="index.php?menu=conciertos"><li>Conciertos</li></a>';
					

					if($_SESSION['login'] == true){

						if($_SESSION['tipo'] == 'gestor'){
							echo '<a '; if($menu == 'gestor') echo'id="seleccionado"'; echo'href="index.php?menu=gestor"><li>Menú Gestor</li></a>';
						}

						if($_SESSION['tipo'] == 'administrador'){
							echo '

							<div class="dropdown">
								<li>
								<button class="dropbtn">Menú Administrador
									<i class="fa fa-caret-down"></i>
								</buttom>
								</li>

								<div class="dropdown-content">';

									echo'
										<a '; if($menu == 'administradorUsuarios') echo'id="seleccionado"'; echo'href="index.php?menu=administradorUsuarios"><li>Gestión de usuarios</li></a>
									';

									echo'
										<a '; if($menu == 'administradorLog') echo'id="seleccionado"'; echo'href="index.php?menu=administradorLog"><li>Log</li></a>
									';

								echo'
								</div>

							</div>
								';
						}
						
					}


					echo '<a '; if($menu == 'login') echo'id="seleccionado"';
					if($_SESSION['login'] == true){
						echo'href="index.php?menu=cuentas&salir=true"><li>Log out</li></a>';
					}else{
						echo'href="index.php?menu=cuentas"><li>Log in</li></a>';
					}




					echo '
				</ul>

				

			</nav>

		</header>
	';

?>