<?php


# Variable que recibe el HTML a imprimir (Se inicializa nula)
$html = null;

// Si recibe la variable del correo y no es nula, ejecuta el codigo principal
if (isset($_GET['correo']) && $_GET['correo']) {

	
	// ------------------------------------------------------------------------
	// ****************** SECCION MENU DE USUARIOS SEGUN ROL ******************
	// ------------------------------------------------------------------------

	// Según el rol de usuario, desplegará diferentes menús a los que acceder
	switch ($_GET['tipo_usuario']) {

		// * Valga aclarar que CUALQUIERA REGISTRADO O NO en al página puede 
		// crear un nuevo usuario, por lo cual omito la mención en cada rol

		// Rol 1 : Cliente
		// Acciones al módulo disponibles:
		//
		// Módulo Usuarios: - Actualizar sus datos
        //                  - Eliminar su usuario
        // 
        // Módulo PQR : - Registrar PQR
        //              - Generar Excel de sus PQR's

		case '1':
			$html = <<<HTML

	<!-- Menú de Acciones -->
	<div class="btn-group">
	  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: darkgreen;">
	    Acciones
	  </button>

	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/usuario/usuario_registro.php">Registrar Nuevo Usuario</a>
	    <a class="dropdown-item" href="/modules/usuario/usuario_editar.php?identificacion={$_COOKIE['identificacion']}">Actualizar Tus Datos</a>
	    <a class="dropdown-item" href="/modules/usuario/usuario_borrar.php?identificacion={$_COOKIE['identificacion']}&correo={$_COOKIE['correo']}&contrasena={$_COOKIE['contrasena']}">Eliminar Tu Usuario</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/pqr/pqr_registro.php">Registrar PQR</a>
	    <a class="dropdown-item" href="/modules/pqr/pqr_crear_excel.php?identificacion={$_COOKIE['identificacion']}">Generar Excel de Tus PQR's</a>
	  </div>
	</div>
HTML;
			break;


		// Rol 2 : Vendedor
		// Acciones al módulo disponibles:
		//
		// Módulo PQR : - Registrar PQR
        //              - Generar Excel de sus PQR's
		//
		// Módulo Usuarios: - Ver los usuarios registrados
		//      	        - Actualizar datos de cualquier usuario
        //                  - Eliminar cualquier usuario
		//                  - Generar Excel de usuarios
		//
		// Módulo Ventas: - Ver las ventas registradas
		//      	      - Actualizar datos de cualquier venta
        //                - Eliminar cualquier venta
		//                - Generar Excel de ventas
		//                - Crear nueva venta
		//
		// Módulo Pedidos: - Ver los pedidos registrados
		//      	       - Actualizar datos de cualquier pedido
        //                 - Eliminar cualquier pedido
		//                 - Generar Excel de pedidos
		//                 - Crear nuevo pedido

		case '2':
			$html = <<<HTML

	<!-- Menú de PQR (Vendedor) -->
	<div class="btn-group">
	  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    PQR
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/pqr/pqr_registro.php">Registrar PQR</a>
	    <a class="dropdown-item" href="/modules/pqr/pqr_crear_excel.php?identificacion={$_COOKIE['identificacion']}">Generar Excel de PQR's</a>
	  </div>
	</div>

	<!-- Menú de Usuarios -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Usuarios
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/usuario/usuario_registro.php">Registrar Usuario</a>
	    <a class="dropdown-item" href="/modules/usuario/usuarios_listar.php">Listar Usuarios</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/usuario/usuario_crear_excel.php">Generar Excel de Usuarios</a>
	  </div>
	</div>

	<!-- Menú de Ventas -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Ventas
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/venta/venta_registrar.php">Registrar Venta</a>
	    <a class="dropdown-item" href="/modules/venta/venta_leer.php">Listar Ventas</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/venta/venta_crear_excel.php">Generar Excel de Ventas</a>
	  </div>
	</div>

	<!-- Menú de Pedidos -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Pedidos
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/pedido/pedido_registrar.php">Registrar Pedidos</a>
	    <a class="dropdown-item" href="/modules/pedido/pedido_leer.php">Listar Pedidos</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/pedido/pedido_crear_excel.php">Generar Excel de Pedidos</a>
	  </div>
	</div>

HTML;
			break;


		// Rol 3 : Asesor
		// Acciones al módulo disponibles:
		//
		// Módulo Usuarios: - Actualizar sus datos
		//                  - Eliminar su usuario
		//
		// Módulo PQR: - Ver los PQR registrados
		//      	   - Registrar PQR
        //             - Responder PQR's
		//             - Generar Excel de PQR
		// 
		// Módulo Compras: - Ver las compras registradas
		//                 - Editar las compras realizadas
		//                 - Crear compras
		//                 - Eliminar compras
		//                 - Generar Excel de las compras registradas
		//
		// Módulo Productos: - Ver los productos registrados
		//                   - Editar los productos realizados
		//                   - Crear productos
		//                   - Eliminar productos
		//                   - Generar Excel de los productos registrados
		

		case '3':
			$html = <<<HTML
	<!-- Menú de Usuarios (Asesor) -->
	<div class="btn-group">
	  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Usuarios
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/usuario/usuario_registro.php">Registrar Usuario</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/usuario/usuario_editar.php?identificacion={$_COOKIE['identificacion']}">Actualizar Tus Datos</a>
	    <a class="dropdown-item" href="/modules/usuario/usuario_borrar.php?identificacion={$_COOKIE['identificacion']}&correo={$_COOKIE['correo']}&contrasena={$_COOKIE['contrasena']}">Eliminar Tu Usuario</a>
	  </div>
	</div>

	<!-- Menú de PQR -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    PQR
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/pqr/pqr_registro.php">Registrar PQR</a>
	    <a class="dropdown-item" href="/modules/pqr/pqr_listar.php">Listar PQR's</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/pqr/pqr_crear_excel.php">Generar Excel de PQR's</a>
	  </div>
	</div>

	<!-- Menú de Compras -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Compras
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/compra/compra_registrar.php">Registrar Compra</a>
	    <a class="dropdown-item" href="/modules/compra/compra_leer.php">Listar Compras</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/compra/compra_crear_excel.php">Generar Excel de Compras</a>
	  </div>
	</div>

	<!-- Menú de Productos -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Productos
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/producto/producto_registrar.php">Registrar Productos</a>
	    <a class="dropdown-item" href="/modules/producto/producto_leer.php">Listar Productos</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/producto/producto_crear_excel.php">Generar Excel de Productos</a>
	  </div>
	</div>

HTML;
			break;


		// Rol 4 : Administrador
		// Acciones al módulo disponibles:
		//
		// Módulo Usuarios: - Ver los usuarios registrados
		//					- Crear nuevo usuario
		//      	        - Actualizar datos de cualquier usuario
        //                  - Eliminar cualquier usuario
		//                  - Generar Excel de usuarios
		//
		// Módulo PQR: - Ver los PQR registrados
		//      	   - Registrar PQR
        //             - Responder PQR's
		//             - Generar Excel de PQR's
		// 
		// Módulo Compras: - Ver las compras registradas
		//                 - Editar las compras realizadas
		//                 - Crear compras
		//                 - Eliminar compras
		//                 - Generar Excel de las compras registradas
		//
		// Módulo Productos: - Ver los productos registrados
		//                   - Editar los productos realizados
		//                   - Crear productos
		//                   - Eliminar productos
		//                   - Generar Excel de los productos registrados
		//
		// Módulo Ventas: - Ver las ventas registradas
		//      	      - Actualizar datos de cualquier venta
        //                - Eliminar cualquier venta
		//                - Generar Excel de ventas
		//                - Crear nueva venta
		//
		// Módulo Pedidos: - Ver los pedidos registrados
		//      	       - Actualizar datos de cualquier pedido
        //                 - Eliminar cualquier pedido
		//                 - Generar Excel de pedidos
		//                 - Crear nuevo pedido

		case '4':
			$html = <<<HTML
	<!-- Menú de Usuarios -->
	<div class="btn-group">
	  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Usuarios
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/usuario/usuario_registro.php">Registrar Usuario</a>
	    <a class="dropdown-item" href="/modules/usuario/usuarios_listar.php">Listar Usuarios</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/usuario/usuario_crear_excel.php">Generar Excel de Usuarios</a>
	  </div>
	</div>

	<!-- Menú de PQR -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    PQR
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/pqr/pqr_registro.php">Registrar PQR</a>
	    <a class="dropdown-item" href="/modules/pqr/pqr_listar.php">Listar PQR's</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/pqr/pqr_crear_excel.php">Generar Excel de PQR's</a>
	  </div>
	</div>

	<!-- Menú de Compras -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Compras
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/compra/compra_registrar.php">Registrar Compra</a>
	    <a class="dropdown-item" href="/modules/compra/compra_leer.php">Listar Compras</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/compra/compra_crear_excel.php">Generar Excel de Compras</a>
	  </div>
	</div>

	<!-- Menú de Productos -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Productos
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/producto/producto_registrar.php">Registrar Productos</a>
	    <a class="dropdown-item" href="/modules/producto/producto_leer.php">Listar Productos</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/producto/producto_crear_excel.php">Generar Excel de Productos</a>
	  </div>
	</div>

	<!-- Menú de Ventas -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Ventas
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/venta/venta_registrar.php">Registrar Venta</a>
	    <a class="dropdown-item" href="/modules/venta/venta_leer.php">Listar Ventas</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/venta/venta_crear_excel.php">Generar Excel de Ventas</a>
	  </div>
	</div>

	<!-- Menú de Pedidos -->
	<div class="btn-group ml-2">
	  <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Pedidos
	  </button>
	  <div class="dropdown-menu">
	    <a class="dropdown-item" href="/modules/pedido/pedido_registrar.php">Registrar Pedidos</a>
	    <a class="dropdown-item" href="/modules/pedido/pedido_leer.php">Listar Pedidos</a>
	    <div class="dropdown-divider"></div>
	    <a class="dropdown-item" href="/modules/pedido/pedido_crear_excel.php">Generar Excel de Pedidos</a>
	  </div>
	</div>

HTML;
			break;
	}
	
	// ------------------------------------------------------------------------
	// **************** FIN SECCION MENU DE USUARIOS SEGUN ROL ****************
	// ------------------------------------------------------------------------
	
} 

// Sino recibe correo por metodo GET o si es nulo, redirije a "Iniciar sesión"
else {
	header("Location: /modules/login/iniciar_sesion.php");
}

?>

<?php include '../templates/header.php'; ?>

	<div class="container">
		<p class="h1 mt-4">Bienvenido, <?= $_COOKIE['nombre'] ?></p>
		<hr>
		<br>
		<p class="h3">¿Que te gustaría hacer hoy?</p>
		<br>
		<!-- Menús segun rol -->
		<?= $html ?>
	</div>
	

<?php include '../templates/footer.php'; ?>