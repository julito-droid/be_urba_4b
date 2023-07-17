<?php

// ************************ Validacion Acceso a Pagina ************************

// Sino existe las cookies o si no es usuario Vendedor (2) o Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 2 || $_COOKIE['tipo_usuario'] == 4)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Ventas</title>
</head>
<body>
    <?php
    include("../../func_resources/php/conexion.php");
    $con = conectar();

    // Verificar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $id_producto = $_POST["id_producto"];
        $fecha_venta = $_POST["fecha_venta"];
        $cantidad = $_POST["cantidad"];
        $precio_total = $_POST["precio_total"];

        // Insertar los datos de la venta en la base de datos
        $sql = "INSERT INTO ventas (id_producto, fecha_venta, cantidad, precio_total) VALUES ($id_producto, '$fecha_venta', $cantidad, $precio_total)";
        if (mysqli_query($con, $sql)) {
            echo "La venta se ha registrado correctamente.";
        } else {
            echo "Error al registrar la venta: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
    ?>

    <h1>Registro de Ventas</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id_producto">ID Producto:</label>
        <input type="number" name="id_producto" required><br>

        <label for="fecha_venta">Fecha de Venta:</label>
        <input type="date" name="fecha_venta" required><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" required><br>

        <label for="precio_total">Precio Total:</label>
        <input type="number" name="precio_total" required><br>

        <input type="submit" value="Registrar Venta">
    </form>

    <br><a href='venta_leer.php'>Ver registros de Ventas</a>
    <br><a href='/modules/login/iniciar_sesion.php'>Volver a Inicio</a>
</body>
</html>