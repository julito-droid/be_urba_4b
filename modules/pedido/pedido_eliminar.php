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

// Verificar si se proporcionó un ID de pedido válido
if (isset($_GET["id"])) {
    $id_pedido = $_GET["id"];

    // Eliminar el pedido de la base de datos
    $sql = "DELETE FROM pedidos WHERE id_pedido = $id_pedido";
    if (mysqli_query($con, $sql)) {
        echo "El pedido se ha eliminado correctamente.";
    } else {
        echo "Error al eliminar el pedido: " . mysqli_error($con);
    }
} else {
    echo "No se proporcionó un ID de pedido válido.";
}

echo '<br> <a class="btn btn-primary" href="pedido_leer.php">Ver registros de Pedidos</a> <br>';
echo '<a class="btn btn-primary" href="/modules/login/iniciar_sesion.php">Ir a Inicio</a> <br>';

// Cerramos la conexión a la base de datos
mysqli_close($con);

?>