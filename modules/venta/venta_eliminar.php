<?php

// ************************ Validacion Acceso a Pagina ************************

// Sino existe las cookies o si no es usuario Vendedor (2) o Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 2 || $_COOKIE['tipo_usuario'] == 4)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

include("../../func_resources/php/conexion.php");
$con = conectar();

// Verificar si se proporcionó un ID de venta válido
if (isset($_GET["id"])) {
    $id_venta = $_GET["id"];

    // Eliminar la venta de la base de datos
    $sql = "DELETE FROM ventas WHERE id_venta = $id_venta";
    if (mysqli_query($con, $sql)) {
        echo "La venta se ha eliminado correctamente.";
    } else {
        echo "Error al eliminar la venta: " . mysqli_error($con);
    }
} else {
    echo "No se proporcionó un ID de venta válido.";
}

echo "<br><a href='venta_leer.php'>Ver registros de Ventas</a>";
echo "<br><a href='/modules/login/iniciar_sesion.php'>Volver a Inicio</a>";

// Cerramos la conexión a la base de datos
mysqli_close($con);
?>