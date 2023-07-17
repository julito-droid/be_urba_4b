<?php

// ************************ Validacion Acceso a Pagina ************************

// Si no existe las cookies o si no es usuario Asesor (3) con identificación, 
// Cliente (1), Vendedor (2) o Admin (4) genera error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");

} elseif (!($_COOKIE['tipo_usuario'] == 3 && isset($_GET['identificacion']))) {
  if (!($_COOKIE['tipo_usuario'] == 1 || $_COOKIE['tipo_usuario'] == 2
            || $_COOKIE['tipo_usuario'] == 4)) {
    header("Location: /error/404.php");
  }
}


// ********************** Fin Validacion Acceso a Pagina **********************

include '../../func_resources/php/funciones.php';

$config = include '../../func_resources/php/config.php';

$resultado = [
  'error' => false,
  'mensaje' => 'Usuario eliminado exitosamente'
];

$conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

if (!$conn) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'Error en la conexión: ' . mysqli_connect_error();
} else {
  $identificacion = $_GET['identificacion'];
  $correo = $_GET['correo'];
  $contrasena = $_GET['contrasena'];

  $consultaSQL = "DELETE FROM tbl_usuarios WHERE usr__numero_identificacion = '$identificacion' AND usr__correo_electronico = '$correo' AND usr__contrasena = '$contrasena'";

  if (!mysqli_query($conn, $consultaSQL)) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'Error en la consulta: ' . mysqli_error($conn);
  }

  mysqli_close($conn);

  if ($_GET['identificacion'] == $_COOKIE['identificacion'] &&
      $_GET['correo'] == $_COOKIE['correo'] &&
      $_GET['contrasena'] == $_COOKIE['contrasena']) {
    
    // Recorrer todas las cookies existentes
    foreach ($_COOKIE as $nombre => $valor) {
        // Establecer tiempo de expiración en el pasado para eliminar la cookie
        setcookie($nombre, '', 0);
    }
  }
}
?>

<?php require "../../templates/header.php"; ?>

<div class="container mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
        <?= $resultado['mensaje'] ?> <a class="btn btn-primary ml-2" href="/modules/login/iniciar_sesion.php">Ir a Inicio</a>
      </div>
    </div>
  </div>
</div>

<?php require "../../templates/footer.php"; ?>
