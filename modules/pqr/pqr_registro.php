<?php

// ************************ Validacion Acceso a Pagina ************************

// Si no existe las cookies o si no es usuario da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'])) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

use PHPMailer\PHPMailer\PHPMailer;
require '../../vendor/autoload.php';
    
include '../../func_resources/php/funciones.php';


if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El PQR ha sido agregado con éxito'
  ];

  $config = include '../../func_resources/php/config.php';

  $conn = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);

  if (!$conn) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'Error en la conexión: ' . mysqli_connect_error();
  } else {
    $usuario = array(
      "pqr__identificacion_solicitante" => $_POST['identificacion'],
      "pqr__tipo_pqr" => $_POST['tipo_pqr'],
      "pqr__puntuacion_calidad" => $_POST['puntuacion'],
      "pqr__descripcion" => $_POST['descripcion'],
    );

    $consultaSQL = "INSERT INTO tbl_pqr(pqr__identificacion_solicitante, pqr__tipo_pqr, pqr__puntuacion_calidad, pqr__descripcion) VALUES ('" . implode("', '", $usuario) . "')";

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
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
<style>
.star-rating {
  display: inline-block;
}

input[type="radio"] {
  display: none;
}

.star-rating label {
  float: right;
  color: #ccc;
}

.star-rating label:before {
  content: '\2605';
  margin-right: 5px;
}

.star-rating input[type="radio"]:hover ~ label {
  color: #d9ad26;
}

.star-rating input[type="radio"]:checked ~ label {
  color: #ffcc00;
}

</style>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Registro de PQR</h2>
      <hr>
      <form method="post">

        <div class="form-group">
          <label for="identificacion">Identificación</label>
          <input type="number" placeholder="Número de documento" name="identificacion" id="identificacion" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="drop_tipos">Tipos de PQR</label>
          <div class="dropdown" id="drop_tipos">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Tipos de PQR
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <input type="radio" id="pqr1" name="tipo_pqr" value="1">
              <label for="pqr1" class="dropdown-item">Pregunta</label>
              <input type="radio" id="pqr2" name="tipo_pqr" value="2">
              <label for="pqr2" class="dropdown-item">Queja</label>
              <input type="radio" id="pqr3" name="tipo_pqr" value="3">
              <label for="pqr3" class="dropdown-item">Reclamo</label>
              <input type="radio" id="pqr4" name="tipo_pqr" value="4">
              <label for="pqr4" class="dropdown-item">Sugerencia</label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="punt">Puntuación del servicio</label>
          <br>
          <div class="star-rating" id="punt">
            <input type="radio" id="star5" name="puntuacion" value="5">
            <label for="star5"></label>
            <input type="radio" id="star4" name="puntuacion" value="4">
            <label for="star4"></label>
            <input type="radio" id="star3" name="puntuacion" value="3">
            <label for="star3"></label>
            <input type="radio" id="star2" name="puntuacion" value="2">
            <label for="star2"></label>
            <input type="radio" id="star1" name="puntuacion" value="1">
            <label for="star1"></label>
          </div>
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción del PQR</label>
          <textarea placeholder="Descripción del PQR" name="descripcion" id="descripcion" class="form-control" rows="5" required></textarea>
        </div>

        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary ml-2" href="/modules/login/iniciar_sesion.php">Ir a Inicio</a>
          <?= $_COOKIE['tipo_usuario'] == 3 || $_COOKIE['tipo_usuario'] == 4 ? '<a class="btn btn-primary" href="pqr_listar.php">Ver PQRs</a>' : "" ?>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../../templates/footer.php'; ?>
