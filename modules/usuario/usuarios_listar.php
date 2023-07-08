<?php
include '../../func_resources/php/funciones.php';
$config = include '../../func_resources/php/config.php';

$error = false;

$conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

if (!$conn) {
  $error = 'Error en la conexión: ' . mysqli_connect_error();
} else {
  if (isset($_POST['busqueda'])) {
    $consultaSQL = "SELECT * FROM tbl_usuarios WHERE usr__numero_identificacion LIKE '%" . $_POST['busqueda'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM tbl_usuarios";
  }

  $resultados = mysqli_query($conn, $consultaSQL);

  if (!$resultados) {
    $error = 'Error en la consulta: ' . mysqli_error($conn);
  }

  mysqli_close($conn);
}

$titulo = isset($_POST['busqueda']) ? 'Lista de usuarios (' . $_POST['busqueda'] . ')' : 'Lista de usuarios';
?>

<?php include "../../templates/header.php"; ?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="usuario_registro.php" class="btn btn-primary mt-4">Crear usuario</a>
      <a href="usuario_crear_excel.php" class="btn btn-success mt-4">Exportar a Excel <i class="bi bi-filetype-xlsx"></i></a>
      <hr>
      <?php if ($resultados && mysqli_num_rows($resultados) > 0) { ?>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="busqueda" name="busqueda" placeholder="Buscar por Identificacion" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
      </form>
      <?php } ?>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>Número de Documento</th>
            <th colspan="2">Nombre(s)</th>
            <th colspan="2">Apellido(s)</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Tipo de usuario</th>
            <th>Fecha creación</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($resultados && mysqli_num_rows($resultados) > 0) {
            while ($fila = mysqli_fetch_assoc($resultados)) {
              ?>
              <tr>
                <td><?php echo escapar($fila["usr__numero_identificacion"]); ?></td>
                <td><?php echo escapar($fila["usr__nombre1"]); ?></td>
                <td style="color: lightgreen;"><?php echo escapar($fila["usr__nombre2"]); ?></td>
                <td><?php echo escapar($fila["usr__apellido1"]); ?></td>
                <td style="color: lightgreen;"><?php echo escapar($fila["usr__apellido2"]); ?></td>
                <td><?php echo escapar($fila["usr__correo_electronico"]); ?></td>
                <td><?php echo escapar($fila["usr__direccion"]); ?></td>
                <td><?php echo escapar($fila["usr__numero_celular"]); ?></td>
                <td><?php echo escapar($fila["usr__tipo_usuario"]); ?></td>
                <td><?php echo escapar($fila["usr__fecha_creacion"]); ?></td>
                
                <td>
                  <a href="<?= 'usuario_borrar.php?identificacion=' . escapar($fila["usr__numero_identificacion"]) . '&correo=' . escapar($fila["usr__correo_electronico"]) . '&contrasena=' . escapar($fila["usr__contrasena"]) ?>"><i class="bi bi-file-x" style="color: red;"></i> Borrar</a>
                  <br>
                  <a href="<?= 'usuario_editar.php?identificacion=' . escapar($fila["usr__numero_identificacion"]) ?>"><i class="bi bi-pencil-fill" style="color: green;"></i> Editar</a>
                </td>
              </tr>
              <?php
            }
          } elseif (!$resultados || mysqli_num_rows($resultados) == 0) { ?>
            <tr>
            <td colspan="10"><i><strong>No hay registros de usuarios</strong></i></td>  
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include "../../templates/footer.php"; ?>
