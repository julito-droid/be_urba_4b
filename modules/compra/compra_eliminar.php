<?php

// ************************ Validacion Acceso a Pagina ************************

// Sino existe las cookies o si no es usuario Asesor (3) o Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 3 || $_COOKIE['tipo_usuario'] == 4)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

include("../../func_resources/php/conexion.php");
$con = conectar();

// Verificar si se proporcionó un ID de compra válido
if (isset($_GET["id"])) {
    $id_compra = $_GET["id"];

    // Eliminar la compra de la base de datos
    $sql = "DELETE FROM compras WHERE id_compra = $id_compra";
    if (mysqli_query($con, $sql)) {
        echo "La compra se ha eliminado correctamente.";
    } else {
        echo "Error al eliminar la compra: " . mysqli_error($con);
    }
} else {
    echo "No se proporcionó un ID de compra válido.";
}

echo "<br><a href='compra_leer.php'>Ver registros de Compras</a>";
echo "<br><a href='/modules/login/iniciar_sesion.php'>Volver a Inicio</a>";

// Cerramos la conexión a la base de datos
mysqli_close($con);
?>