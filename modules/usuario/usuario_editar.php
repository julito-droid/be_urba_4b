<?php
include '../../func_resources/php/funciones.php';

$config = include '../../func_resources/php/config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['identificacion'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El usuario no existe';
}

if (isset($_POST['submit'])) {
  $conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

  if (!$conn) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'Error en la conexión: ' . mysqli_connect_error();
  } else {
    $usuario = array(
     "usr__numero_identificacion" => $_POST['identificacion'],
     "usr__correo_electronico" => $_POST['correo'],
     "usr__direccion" => $_POST['direccion'],
     "usr__numero_celular" => $_POST['numero_celular'],
     "usr__nombre1" => $_POST['nombre_1'],
     "usr__nombre2" => $_POST['nombre_2'],
     "usr__apellido1" => $_POST['apellido_1'],
     "usr__apellido2" => $_POST['apellido_2'],
     "usr__tipo_usuario" => $_POST['tipo_usuario'],
     "usr__contrasena" => $_POST['contrasena']
    );

    $consultaSQL = "UPDATE tbl_usuarios SET
        usr__correo_electronico = '" . $usuario['usr__correo_electronico'] . "',
        usr__direccion = '" . $usuario['usr__direccion'] . "',
        usr__numero_celular = '" . $usuario['usr__numero_celular'] . "',
        usr__nombre1 = '" . $usuario['usr__nombre1'] . "',
        usr__nombre2 = '" . $usuario['usr__nombre2'] . "',
        usr__apellido1 = '" . $usuario['usr__apellido1'] . "',
        usr__apellido2 = '" . $usuario['usr__apellido2'] . "',
        usr__tipo_usuario = '" . $usuario['usr__tipo_usuario'] . "',
        usr__contrasena = '" . $usuario['usr__contrasena'] . "'
    WHERE usr__numero_identificacion = '" . $_POST['identificacion'] . "'";

    if (!mysqli_query($conn, $consultaSQL)) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'Error en la consulta: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
  }
}

$conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

if (!$conn) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'Error en la conexión: ' . mysqli_connect_error();
} else {
  $identificacion = $_GET['identificacion'];
  $consultaSQL = "SELECT * FROM tbl_usuarios WHERE usr__numero_identificacion = '" . $identificacion . "'";

  $resultados = mysqli_query($conn, $consultaSQL);

  if (!$resultados) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'Error en la consulta: ' . mysqli_error($conn);
  }

  $usuario = mysqli_fetch_assoc($resultados);

  if (!$usuario) {
    $$resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el usuario';
  }

  mysqli_close($conn);
}
?>

<?php require "../../templates/header.php"; ?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El usuario ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($usuario) && $usuario) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando datos del usuario <?= escapar($usuario['usr__nombre1']) . ' ' . escapar($usuario['usr__apellido1']) ?></h2>
        <hr>
        <form method="post">

          <div class="form-group">
            <label for="identificacion">Identificación</label>
            <input type="number" placeholder="Número de documento" name="identificacion" id="identificacion" class="form-control" value="<?= $usuario['usr__numero_identificacion'] ?>" required readonly>
          </div>

          <div class="form-group">
            <label for="direccion">Residencia</label>
            <input type="text" placeholder="Dirección de residencia" name="direccion" id="direccion" class="form-control" value="<?= $usuario['usr__direccion'] ?>" required>
          </div>

          <div class="form-group">
            <label for="numero_celular">Teléfono</label>
            <input type="number" placeholder="Número telefónico o de celular" name="numero_celular" id="numero_celular" class="form-control" value="<?= $usuario['usr__numero_celular'] ?>" required>
          </div>

          <div class="form-group">
            <label for="nombre_1">Primer Nombre</label>
            <input type="text" placeholder="Primer Nombre" name="nombre_1" id="nombre_1" class="form-control" value="<?= $usuario['usr__nombre1'] ?>" required>
          </div>

          <div class="form-group">
            <label for="nombre_2">Segundo Nombre (Opcional)</label>
            <input type="text" placeholder="Segundo Nombre" name="nombre_2" id="nombre_2" class="form-control" value="<?= $usuario['usr__nombre2'] ?>">
          </div>

          <div class="form-group">
            <label for="apellido_1">Primer Apellido</label>
            <input type="text" placeholder="Primer Apellido" name="apellido_1" id="apellido_1" class="form-control" value="<?= $usuario['usr__apellido1'] ?>" required>
          </div>

          <div class="form-group">
            <label for="apellido_2">Segundo Apellido (Opcional)</label>
            <input type="text" placeholder="Segundo Apellido" name="apellido_2" id="apellido_2" class="form-control" value="<?= $usuario['usr__apellido2'] ?>">
          </div>

          <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" placeholder="Correo electrónico" name="correo" id="correo" class="form-control" value="<?= $usuario['usr__correo_electronico'] ?>" required>
          </div>

          <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <input type="password" placeholder="Contraseña" name="contrasena" id="contrasena" class="form-control" value="<?= $usuario['usr__contrasena'] ?>" required>
          </div>

          <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="<?= $usuario['usr__tipo_usuario'] ?>">

          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="/index.html">Regresar al inicio</a>
            <a class="btn btn-primary" href="usuarios_listar.php">Ver registros de usuarios</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../../templates/footer.php"; ?>
