<?php
include '../../func_resources/php/funciones.php';


if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El usuario '. escapar($_POST['nombre_1']) . ' ' . escapar($_POST['apellido_1']) . ' ha sido agregado con éxito'
  ];

  $config = include '../../func_resources/php/config.php';

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

    $consultaSQL = "INSERT INTO tbl_usuarios(usr__numero_identificacion, usr__correo_electronico, usr__direccion, usr__numero_celular, usr__nombre1, usr__nombre2, usr__apellido1, usr__apellido2, usr__tipo_usuario, usr__contrasena) VALUES ('" . implode("', '", $usuario) . "')";

    if (!mysqli_query($conn, $consultaSQL)) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'Error en la consulta: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
  }
}
?>

<?php include '../../templates/header.php'; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?> <?php if (isset($_POST['submit']) && !isset($_COOKIE['identificacion'])) { ?>
            <a class="btn btn-primary ml-2" href="/modules/login/iniciar_sesion.php">Ir a Inicio de sesión</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
<style>
  input[type="radio"] {
    display: none;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Registro de Usuario</h2>
      <hr>
      <form method="post">

        <div class="form-group">
          <label for="identificacion">Identificación</label>
          <input type="number" placeholder="Número de documento" name="identificacion" id="identificacion" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="direccion">Residencia</label>
          <input type="text" placeholder="Dirección de residencia" name="direccion" id="direccion" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="numero_celular">Teléfono</label>
          <input type="number" placeholder="Número telefónico o celular" name="numero_celular" id="numero_celular" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="nombre_1">Primer Nombre</label>
          <input type="text" placeholder="Primer Nombre" name="nombre_1" id="nombre_1" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="nombre_2">Segundo Nombre (Opcional)</label>
          <input type="text" placeholder="Segundo Nombre" name="nombre_2" id="nombre_2" class="form-control">
        </div>

        <div class="form-group">
          <label for="apellido_1">Primer Apellido</label>
          <input type="text" placeholder="Primer Apellido" name="apellido_1" id="apellido_1" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="apellido_2">Segundo Apellido (Opcional)</label>
          <input type="text" placeholder="Segundo Apellido" name="apellido_2" id="apellido_2" class="form-control">
        </div>

        <div class="form-group">
          <label for="correo">Correo Electrónico</label>
          <input type="email" placeholder="Correo electrónico" name="correo" id="correo" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="contrasena">Contraseña</label>
          <input type="password" placeholder="Contraseña" name="contrasena" id="contrasena" class="form-control" required>
        </div>

        <?php if (isset($_COOKIE['tipo_usuario']) && $_COOKIE['tipo_usuario'] == 4) { ?>
        <div class="form-group">
          <label for="drop_tipos">Tipos de Usuarios</label>
          <div class="dropdown" id="drop_tipos">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Tipos de Usuarios
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <input type="radio" id="pqr1" name="tipo_usuario" value="1" required>
              <label for="pqr1" class="dropdown-item">Cliente</label>
              <input type="radio" id="pqr2" name="tipo_usuario" value="2">
              <label for="pqr2" class="dropdown-item">Vendedor</label>
              <input type="radio" id="pqr3" name="tipo_usuario" value="3">
              <label for="pqr3" class="dropdown-item">Asesor</label>
              <input type="radio" id="pqr4" name="tipo_usuario" value="4">
              <label for="pqr4" class="dropdown-item">Administrador</label>
            </div>
          </div>
        </div>
        <?php
        } else {
        ?>
          <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="1">
        <?php } ?>

        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="/">Ir a la página principal</a>
          <?php if (isset($_POST['submit']) && !isset($_COOKIE['identificacion'])) { ?>
            <a class="btn btn-primary" href="/modules/login/iniciar_sesion.php">Ir a Inicio de sesión</a>
          <?php } elseif (isset($_COOKIE['identificacion'])) { ?>
            <a class="btn btn-primary" href="/modules/login/iniciar_sesion.php">Ir a Inicio</a>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../../templates/footer.php'; ?>
