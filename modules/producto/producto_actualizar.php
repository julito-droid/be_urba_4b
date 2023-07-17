<?php

// ************************ Validacion Acceso a Pagina ************************

// Sino existe las cookies o si no es usuario Asesor (3) o Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 3 || $_COOKIE['tipo_usuario'] == 4)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <?php
    include("../../func_resources/php/conexion.php");
    $con = conectar();

    // Verificar si se envió el formulario de edición
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $id_producto = $_POST["id_producto"];
        $cantidad = $_POST["cantidad"];
        $id_tipo = $_POST["id_tipo"];
        $id_talla = $_POST["id_talla"];
        $id_color = $_POST["id_color"];
        $precio_und = $_POST["precio_und"];

        // Actualizar los datos del producto en la base de datos
        $sql = "UPDATE productos SET cantidad = $cantidad, id_tipo = $id_tipo, id_talla = $id_talla, id_color = $id_color, precio_und = $precio_und WHERE id_producto = $id_producto";
        if (mysqli_query($con, $sql)) {
            echo "El producto se ha actualizado correctamente.";
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($con);
        }
    }

    // Obtener el ID del producto a editar
    if (isset($_GET["id"])) {
        $id_producto = $_GET["id"];

        // Consultar los datos del producto a editar
        $sql = "SELECT * FROM productos WHERE id_producto = $id_producto";
        $query = mysqli_query($con, $sql);

        // Comprobar si se encontró el producto
        if (mysqli_num_rows($query) == 1) {
            // Obtener los datos del producto
            $row = mysqli_fetch_assoc($query);
            $id_producto = $row['id_producto'];
            $cantidad = $row['cantidad'];
            $id_tipo = $row['id_tipo'];
            $id_talla = $row['id_talla'];
            $id_color = $row['id_color'];
            $precio_und = $row['precio_und'];

            // Mostrar el formulario de edición con los datos del producto
            echo '
            <h1>Editar Producto</h1>
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <input type="hidden" name="id_producto" value="' . $id_producto . '">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" value="' . $cantidad . '" required><br>

                <label for="id_tipo">ID Tipo:</label>
                <input type="number" name="id_tipo" value="' . $id_tipo . '" required><br>

                <label for="id_talla">ID Talla:</label>
                <input type="number" name="id_talla" value="' . $id_talla . '" required><br>

                <label for="id_color">ID Color:</label>
                <input type="number" name="id_color" value="' . $id_color . '" required><br>

                <label for="precio_und">Precio Unitario:</label>
                <input type="number" name="precio_und" value="' . $precio_und . '" step="0.01" required><br>

                <input type="submit" value="Actualizar Producto">
                
            </form>';
        } else {
            echo "No se encontró el producto.";
        }
    }

    echo "<br><a href='producto_leer.php'>Ver registros de Productos</a>";
    echo "<br><a href='/modules/login/iniciar_sesion.php'>Volver a Inicio</a>";

    // Cerramos la conexión a la base de datos
    mysqli_close($con);
    ?>
</body>
</html>