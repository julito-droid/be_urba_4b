<?php
include '../../func_resources/php/funciones.php';
$config = include '../../func_resources/php/config.php';

$error = false;

$conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

if (!$conn) {
  $error = 'Error en la conexión: ' . mysqli_connect_error();
} else {
	
	if (isset($_POST['correo'])) {
		$consultaSQL = "SELECT usr__numero_identificacion, usr__correo_electronico, usr__tipo_usuario, usr__contrasena, usr__nombre1, usr__apellido1 FROM tbl_usuarios" . 
					   " WHERE usr__correo_electronico = '" . $_POST['correo'] . "' AND usr__contrasena = '" . $_POST['contrasena'] . "'";
							   
		$resultados = mysqli_query($conn, $consultaSQL);

		if (!$resultados) {
			$error = 'Error en busqueda de usuario: ' . mysqli_error($conn);
		} else {
			if ($resultados && mysqli_num_rows($resultados) > 0 && mysqli_num_rows($resultados) < 2) {
				$arreglo_recibido = array();
				while ($fila = mysqli_fetch_assoc($resultados)) {
						$arreglo_recibido[] = $fila;
				}

				$nombre = $arreglo_recibido[0]['usr__nombre1']  . ' ' . $arreglo_recibido[0]['usr__apellido1'];
				
				if (
					setcookie('identificacion', $arreglo_recibido[0]['usr__numero_identificacion'], time() + (24 * 3600 * 30), "/" ) and
					setcookie('correo',         $arreglo_recibido[0]['usr__correo_electronico'],    time() + (24 * 3600 * 30), "/" ) and
					setcookie('tipo_usuario',   $arreglo_recibido[0]['usr__tipo_usuario'],          time() + (24 * 3600 * 30), "/" ) and
					setcookie('contrasena',     $arreglo_recibido[0]['usr__contrasena'],            time() + (24 * 3600 * 30), "/" ) and
					setcookie('nombre',         $nombre,                                            time() + (24 * 3600 * 30), "/" )
				) {
					sleep(1);
					header("Location: /modules/index.php?correo=" . $_COOKIE['correo'] . "&contrasena=" . $_COOKIE['contrasena'] . "&tipo_usuario=" . $_COOKIE['tipo_usuario'] );
				}
			}
			
		}
		

		mysqli_close($conn);
	}
	
	elseif (isset($_COOKIE['identificacion'])) {
		$consultaSQL = "SELECT usr__numero_identificacion, usr__correo_electronico, usr__tipo_usuario, usr__contrasena FROM tbl_usuarios" . 
					   " WHERE usr__correo_electronico = '" . $_COOKIE['correo'] . "' AND usr__contrasena = '" . $_COOKIE['contrasena'] . "'";
							   
		$resultados = mysqli_query($conn, $consultaSQL);

		if (!$resultados) {
			$error = 'Error en busqueda de usuario: ' . mysqli_error($conn);
		} else {
			if ($resultados && mysqli_num_rows($resultados) > 0 && mysqli_num_rows($resultados) < 2) {
				static $arreglo_recibido;
				while ($fila = mysqli_fetch_assoc($resultados)) {
						$arreglo_recibido[] = array(
								$fila['usr__correo_electronico'],
								$fila['usr__tipo_usuario'],
								$fila['usr__contrasena']
						);
				}
				if ($arreglo_recibido[0][0] == $_COOKIE['correo'] && $arreglo_recibido[0][2] == $_COOKIE['contrasena'])
					header("Location: /modules/index.php?correo=" . $_COOKIE['correo'] . "&contrasena=" . $_COOKIE['contrasena'] . "&tipo_usuario=" . $_COOKIE['tipo_usuario'] );
			}
		}
		
		mysqli_close($conn);
	}

}

?>

<?php include "../../templates/header.php";?>
    <style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
		
		html,
		body {
		  height: 100%;
		}

		body {
			display: -ms-flexbox;
			display: flex;
			-ms-flex-align: center;
			align-items: center;
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
		}

		.form-signin {
			width: 100%;
			max-width: 330px;
			padding: 15px;
			margin: auto;
		}
		
		.form-signin .checkbox {
			font-weight: 400;
		}
		
		.form-signin .form-control {
			position: relative;
			box-sizing: border-box;
			height: auto;
			padding: 10px;
			font-size: 16px;
		}
		
		.form-signin .form-control:focus {
			z-index: 2;
		}
		
		.form-signin input[type="email"] {
			margin-bottom: -1px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
		}
		
		.form-signin input[type="password"] {
			margin-bottom: 10px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
    </style>
	
    <form class="form-signin text-center" method="post">
			<img class="mb-4" src="../../img/logo.jpg" alt="" width="142" height="142">
			<h1 class="h3 mb-3 font-weight-normal">Por favor inicia sesión</h1>
			
			<label for="correo" class="sr-only">Correo Electrónico</label>
			<input type="email" id="correo" name="correo" class="form-control" placeholder="Correo Electrónico" required autofocus>
			
			<label for="contrasena" class="sr-only">Contraseña</label>
			<input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" required>
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesión</button>
			<p class="mt-5 mb-3">¿No tienes cuenta? <a href="/modules/usuario/usuario_registro.php">Creala aquí</a></p>
			<p class="mb-3 text-muted">&copy; 2023</p>
		</form>


	
<?php include "../../templates/footer.php";?>