<?php

// ************************ Validacion Acceso a Pagina ************************

// Si no existe las cookies o si no es usuario Asesor (3) o Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 3 || $_COOKIE['tipo_usuario'] == 4)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

include '../../func_resources/php/funciones.php';
$config = include '../../func_resources/php/config.php';

$error = false;

$conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

if (!$conn) {
  $error = 'Error en la conexión: ' . mysqli_connect_error();
} else {
  if (isset($_POST['busqueda'])) {
    $consultaSQL = "SELECT * FROM tbl_pqr WHERE pqr__identificacion_solicitante LIKE '%" . $_POST['busqueda'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM tbl_pqr";
  }

  $resultados = mysqli_query($conn, $consultaSQL);

  if (!$resultados) {
    $error = 'Error en la consulta: ' . mysqli_error($conn);
  }

  mysqli_close($conn);
}

$titulo = isset($_POST['busqueda']) ? 'Lista de PQRs por Usuario: (' . $_POST['busqueda'] . ')' : 'Lista de PQRs';
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
      <a href="pqr_registro.php" class="btn btn-primary mt-4">Crear PQR</a>
      <a href="pqr_crear_excel.php<?= isset($_POST['busqueda']) ? '?identificacion=' . $_POST['busqueda'] : '' ?>" class="btn btn-success mt-4">Exportar a Excel <i class="bi bi-filetype-xlsx"></i></a>
      <a class="btn btn-primary mt-4 ml-4" href="/modules/login/iniciar_sesion.php">Ir a Inicio</a>
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
            <th>#</th>
            <th>Número de Documento</th>
            <th>Tipo de PQR</th>
            <th>Puntaje</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($resultados && mysqli_num_rows($resultados) > 0) {
            while ($fila = mysqli_fetch_assoc($resultados)) {
              switch ($fila["pqr__puntuacion_calidad"]) {
                case '1':
                  $puntaje_color = "red";
                  break;
                case '2':
                  $puntaje_color = "orange";
                  break;
                case '3':
                  $puntaje_color = "green";
                  break;
                case '4':
                  $puntaje_color = "blue";
                  break;
                case '5':
                  $puntaje_color = "#FFD700";
                  break;
              }
              ?>
              <tr>
                <td><?php echo escapar($fila["pqr__id_pqr"]); ?></td>
                <td><?php echo escapar($fila["pqr__identificacion_solicitante"]); ?></td>
                <td><?php echo escapar($fila["pqr__tipo_pqr"]); ?></td>
                <td><strong style="color: <?= $puntaje_color ?>"><?php echo escapar($fila["pqr__puntuacion_calidad"]); ?> / 5</strong></td>
                <td><?php echo escapar($fila["pqr__fecha_pqr"]); ?></td>
                <td class="text-break"><?php echo escapar($fila["pqr__descripcion"]); ?></td>
                <td><?php echo !escapar($fila["pqr__respondido"]) ? "<strong style='color: red;'>No respondido</strong>" : "<strong style='color: green;'>Respondido</strong>"; ?></td>
                
                <td>
                  <a href="<?= 'pqr_responder.php?id_pqr=' . escapar($fila["pqr__id_pqr"]) ?>"><i class="bi bi-pencil-fill" style="color: green;"></i> Responder</a>
                </td>
              </tr>
              <?php
            }
          } elseif (!$resultados || mysqli_num_rows($resultados) == 0) { ?>
            <tr>
            <td colspan="10"><i><strong>No hay registros de PQR's</strong></i></td>  
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include "../../templates/footer.php"; ?>
