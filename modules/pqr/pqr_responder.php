<?php

// ************************ Validacion Acceso a Pagina ************************

// Sino existe las cookies o si no es usuario Asesor (3) o Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 3 || $_COOKIE['tipo_usuario'] == 4)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

// Importaciones para usar la funcionalidad de E-Mail
require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

// Importaciones del archivo de funciones y de configuración de la DB
include '../../func_resources/php/funciones.php';
$config = include '../../func_resources/php/config.php';

# Arreglo usado para determinar si hay error o no
$resultado = [
  'error' => false,
  'mensaje' => ''
];

// Si no se recibe el ID del PQR por metodo Get se obtiene mensaje de error
if (!isset($_GET['id_pqr'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El PQR no existe';
}

// Conexión a la base de datos
$conn = mysqli_connect($config['db']['host'], $config['db']['user'], 
                       $config['db']['pass'], $config['db']['name']);

// Si no hay conexión a DB, muestra error
if (!$conn) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'Error en la conexión a la base de datos: ' . 
                          mysqli_connect_error();
}

// Si efectivamente hay conexión a DB, procede con el programa principal
else {

  // --------------------------------------------------------------------------
  // *********************** SECCION ENVIO DE RESPUESTA ***********************
  // --------------------------------------------------------------------------


  // Si se recibe información por metodo POST (se envió el formulario)
  if (isset($_POST['submit'])) {

    // Variable que guarda la información recibida del formulario
    $usuario = array(
      "pqr__id_pqr"                => $_POST['id_pqr'],
      "usr__numero_identificacion" => $_POST['identificacion'],
      "usr__correo_electronico"    => $_POST['correo'],
      "usr__nombre"                => $_POST['nombre'],
      "pqr__respuesta"             => $_POST['respuesta'],
    );

    // ********************** Codigo para enviar correo ***********************


    // Cuerpo del Correo a enviar
    $msg = <<<HTML
<h3>Buen día, <strong>{$usuario['usr__nombre']}</stong><h3>
<hr>
<br>
<p>Se informa que el PQR #{$usuario['pqr__id_pqr']} ha sido respondido con lo 
siguiente:</p>
<br>
{$usuario['pqr__respuesta']}
HTML;

    $mail = new PHPMailer;

    // Configuraciones para enviar correo por protocolo SMTP usando 
    // el cliente de Microsoft Outlook

    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';  # Servidor SMTP
    $mail->Port = 587;  # Puerto del servidor
    $mail->SMTPAuth = true;
    $mail->Username = 'ht6c0jnu6zh1yu4@outlook.com'; # E-mail de envio
    $mail->Password = ',hAqYB5F*Q=QW+h';  # Contraseña del e-mail
    $mail->SMTPDebug = 0;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  # Encriptación SMTP

    // Configuración del mensaje por correo a enviar

    # Ajuste del correo y nombre a mostrar en envio del correo (Correo Envio)
    $mail->setFrom('ht6c0jnu6zh1yu4@outlook.com', 'Feeder Matic Informacion');
    
    # Dirección de correo electrónico al cual va a llegar (Correo destino)
    $mail->addAddress($usuario['usr__correo_electronico']);
    
    # Asunto del correo a enviar
    $mail->Subject = 'Respuesta al PQR #' . $usuario['pqr__id_pqr'];

    # Cuerpo del correo
    $mail->isHTML(true);  # Indica que el correo va a ser un HTML
    $mail->msgHTML($msg);  # Ajusta el HTML del cuerpo del correo

    // Envío del correo

    if (!$mail->send()) {

      // Si el envio del correo no es exitoso, genera error
      $resultado['error'] = true;
      $resultado['mensaje'] = 'Error en el envío del correo: ' 
                              . $mail->ErrorInfo;
    } else {
      
      // Si el envío es exitoso, se actualiza el estado del PQR en la DB
      $consultaSQL = "UPDATE tbl_pqr SET
        pqr__respondido = TRUE
      WHERE pqr__id_pqr = '" . $usuario['pqr__id_pqr'] . "'";

      // Si acaso fallase la actualización, se alerta de que se envió correo
      // mas nó se actualizó el estado
      if (!mysqli_query($conn, $consultaSQL)) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'El correo ha sido enviado, pero no se ' . 
                                'actualizó la base de datos con el nuevo ' . 
                                'estado debido a este error: ' . 
                                mysqli_error($conn);
      }
    }
    // ******************** Fin Codigo para enviar correo *********************

    // Se cierra conexión a MySQL
    mysqli_close($conn);
  }

  // --------------------------------------------------------------------------
  // ********************* FIN SECCION ENVIO DE RESPUESTA *********************
  // --------------------------------------------------------------------------



  // --------------------------------------------------------------------------
  // ********************* SECCION OBTENER PQR Y USUARIO **********************
  // --------------------------------------------------------------------------

  else {
    
    # ID del PQR obtenido por metodo GET
    $id_pqr = $_GET['id_pqr'];

    // ****************** Seccion Traer datos de PQR de la DB *****************
    
    # Consulta SQL para el PQR usando su ID
    $consultaPQRSQL = "SELECT * FROM tbl_pqr WHERE pqr__id_pqr = '" . 
                      $id_pqr . "'";

    # Variable que guarda el resultado del query de PQR
    $resultadoPQR = mysqli_query($conn, $consultaPQRSQL);

    // Ejecución del query
    if (!$resultadoPQR) {

      # Si da error la consulta, se muestra el error
      $resultado['error'] = true;
      $resultado['mensaje'] = 'Error consultando el PQR en la base de datos: ' 
                              . mysqli_error($conn);
    } else {

      # Si no da error la consulta, se guardan el resultado
      $pqr = mysqli_fetch_assoc($resultadoPQR);

      // Si el retorno de la consulta está vacío significa que no existe el PQR
      // por lo
      if (!$pqr) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el PQR';
      }
    }

   
    // **************** Fin Seccion Traer datos de PQR de la DB ***************

    // **************** Seccion Traer Usuario del PQR de la DB ****************
    $consultaUsuarioSQL = "SELECT usr__numero_identificacion, usr__correo_electronico, usr__nombre1, usr__nombre2, usr__apellido1, usr__apellido2  FROM tbl_usuarios WHERE usr__numero_identificacion = (SELECT pqr__identificacion_solicitante FROM tbl_pqr WHERE pqr__id_pqr = $id_pqr)";


    $resultadoUsuario = mysqli_query($conn, $consultaUsuarioSQL);

    if (!$resultadoUsuario) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'Error en la consulta: ' . mysqli_error($conn);
    }

    $usuario = mysqli_fetch_assoc($resultadoUsuario);

    if (!$usuario) {
      $resultado['error'] = true;
      $resultado['mensaje'] = 'No se ha encontrado el usuario';
    }
    // ************** Fin Seccion Traer Usuario del PQR de la DB **************

    mysqli_close($conn);
  }

  // --------------------------------------------------------------------------
  // ******************* FIN SECCION OBTENER PQR Y USUARIO ********************
  // --------------------------------------------------------------------------
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
          El PQR ha sido respondido y su estado ha cambiado a "Respondido"
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if ($usuario && $pqr) {

  # Nombre del usuario del PQR
  $nombre = $usuario['usr__nombre1'] . ' ' . 
            $usuario['usr__nombre2'] . ' ' . 
            $usuario['usr__apellido1'] . ' ' . 
            $usuario['usr__apellido2'];

  // Según la calificación del usuario, el texto de calificación cambiará
  // (Valga aclarar que la puntuación es sobre 5)
  # 1 = Rojo    (Muy mal)
  # 2 = Naranja (Mal)
  # 3 = Verde   (Pasable)
  # 4 = Azul    (Buena)
  # 5 = Dorado  (Excelente)

  switch ($pqr["pqr__puntuacion_calidad"]) {
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
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Respondiendo PQR #<?= escapar($pqr['pqr__id_pqr']) ?> del usuario <?= escapar($usuario['usr__nombre1']) . ' ' . escapar($usuario['usr__apellido1']) ?></h2>
        <hr>
        <form method="post">

          <!-- Valores a enviar para el debido proceso de envio a la base de datos  -->
          <input type="hidden" name="id_pqr" value="<?= $pqr['pqr__id_pqr'] ?>">
          <input type="hidden" name="identificacion" value="<?= $usuario['usr__numero_identificacion'] ?>">
          <input type="hidden" name="correo" value="<?= $usuario['usr__correo_electronico'] ?>">
          <input type="hidden" name="nombre" value="<?= escapar($nombre) ?>">


          <!-- Tarjeta con la información del PQR del usuario -->
          <div class="card">
            <div class="card-header"><strong><?= escapar($nombre) ?> (<?= $usuario['usr__correo_electronico'] ?>)</strong></div>
            <div class="card-body">
              <p class="card-subtitle mb-2"><strong>Dia y hora de creación: <?= escapar($pqr['pqr__fecha_pqr']) ?></strong></p>
              <h6 class="card-subtitle mb-2"><strong style="color: <?= $puntaje_color ?>">Calificación: <?= $pqr["pqr__puntuacion_calidad"] ?> / 5</strong></h6>
              <p class="card-text"><?= escapar($pqr["pqr__descripcion"]) ?></p>
              <a href="#" class="card-link">Card link</a>
              <a href="#" class="card-link">Another link</a>
            </div>
          </div>
          <br>  
          <hr>  
          <br> 
          <div class="form-group">
            <p class="h3">Respuesta</p>
            <label for="respuesta">Respuesta al PQR</label>
            <textarea placeholder="Tu respuesta... (Puedes incluir etiquetas HTML)" name="respuesta" id="respuesta" class="form-control" rows="6" required></textarea>
          </div>

          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary ml-2" href="/modules/login/iniciar_sesion.php">Ir a Inicio</a>
            <a class="btn btn-primary" href="pqr_listar.php">Ver registros de PQR's</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../../templates/footer.php"; ?>
