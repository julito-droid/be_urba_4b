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

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $id_venta = $_POST["id_venta"];
    $id_producto = $_POST["id_producto"];
    $fecha_venta = $_POST["fecha_venta"];
    $cantidad = $_POST["cantidad"];
    $precio_total = $_POST["precio_total"];

    // Actualizar los datos de la venta en la base de datos
    $sql = "UPDATE ventas SET id_producto = $id_producto, fecha_venta = '$fecha_venta', cantidad = $cantidad, precio_total = $precio_total WHERE id_venta = $id_venta";
    if (mysqli_query($con, $sql)) {
        echo "La venta se ha actualizado correctamente.";
    } else {
        echo "Error al actualizar la venta: " . mysqli_error($con);
    }
}

// Obtener el ID de la venta a editar
if (isset($_GET["id"])) {
    $id_venta = $_GET["id"];

    // Consultar los datos de la venta a editar
    $sql = "SELECT * FROM ventas WHERE id_venta = $id_venta";
    $query = mysqli_query($con, $sql);

    // Comprobar si se encontró la venta
    if (mysqli_num_rows($query) == 1) {
        // Obtener los datos de la venta
        $row = mysqli_fetch_assoc($query);
        $id_venta = $row['id_venta'];
        $id_producto = $row['id_producto'];
        $fecha_venta = $row['fecha_venta'];
        $cantidad = $row['cantidad'];
        $precio_total = $row['precio_total'];

        // Mostrar el formulario de edición con los datos de la venta
        echo '
        <h1>Editar Venta</h1>
        <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <input type="hidden" name="id_venta" value="' . $id_venta . '">
            <label for="id_producto">ID Producto:</label>
            <input type="number" name="id_producto" value="' . $id_producto . '" required><br>

            <label for="fecha_venta">Fecha de Venta:</label>
            <input type="date" name="fecha_venta" value="' . $fecha_venta . '" required><br>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" value="' . $cantidad . '" required><br>

            <label for="precio_total">Precio Total:</label>
            <input type="number" name="precio_total" value="' . $precio_total . '" required><br>

            <input type="submit" value="Actualizar Venta">
        </form>';
    } else {
        echo "No se encontró la venta.";
    }
}

echo "<br><a href='venta_leer.php'>Ver registros de Ventas</a>";
echo "<br><a href='/modules/login/iniciar_sesion.php'>Volver a Inicio</a>";

// Cerramos la conexión a la base de datos
mysqli_close($con);
?>