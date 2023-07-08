<?php
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
}
?>

<?php require "../../templates/header.php"; ?>

<div class="container mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
        <?= $resultado['mensaje'] ?>
      </div>
    </div>
  </div>
</div>

<?php require "../../templates/footer.php"; ?>
