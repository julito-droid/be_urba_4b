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

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $id_compra = $_POST["id_compra"];
    $fecha_compra = $_POST["fecha_compra"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];
    $precio_und = $_POST["precio_und"];
    $total = $_POST["total"];
    $id_proveedor = $_POST["id_proveedor"];
    $id_producto = $_POST["id_producto"];

    // Actualizar los datos de la compra en la base de datos
    $sql = "UPDATE compras SET fecha_compra = '$fecha_compra', cantidad = $cantidad, descripcion = '$descripcion', precio_und = $precio_und, total = $total, id_proveedor = $id_proveedor, id_producto = $id_producto WHERE id_compra = $id_compra";
    if (mysqli_query($con, $sql)) {
        echo "La compra se ha actualizado correctamente.";
    } else {
        echo "Error al actualizar la compra: " . mysqli_error($con);
    }
}

// Obtener el ID de la compra a editar
if (isset($_GET["id"])) {
    $id_compra = $_GET["id"];

    // Consultar los datos de la compra a editar
    $sql = "SELECT * FROM compras WHERE id_compra = $id_compra";
    $query = mysqli_query($con, $sql);

    // Comprobar si se encontró la compra
    if (mysqli_num_rows($query) == 1) {
        // Obtener los datos de la compra
        $row = mysqli_fetch_assoc($query);
        $id_compra = $row['id_compra'];
        $fecha_compra = $row['fecha_compra'];
        $cantidad = $row['cantidad'];
        $descripcion = $row['descripcion'];
        $precio_und = $row['precio_und'];
        $total = $row['total'];
        $id_proveedor = $row['id_proveedor'];
        $id_producto = $row['id_producto'];

        // Mostrar el formulario de edición con los datos de la compra
        echo '
        <h1>Editar Compra</h1>
        <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <input type="hidden" name="id_compra" value="' . $id_compra . '">
            
            <label for="fecha_compra">Fecha:</label>
            <input type="date" name="fecha_compra" value="' . $fecha_compra . '" required><br>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" value="' . $cantidad . '" required><br>

            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" value="' . $descripcion . '" required><br>

            <label for="precio_und">Precio Unitario:</label>
            <input type="number" name="precio_und" value="' . $precio_und . '" step="0.01" required><br>

            <label for="total">Total:</label>
            <input type="number" name="total" value="' . $total . '" step="0.01" required><br>

            <label for="precio_und">ID Proveedor:</label>
            <input type="number" name="id_proveedor" value="' . $id_proveedor . '" required><br>

            <label for="id_producto">ID Producto:</label>
            <input type="number" name="id_producto" value="' . $id_producto . '" required><br>

            <input type="submit" value="Actualizar Compra">
        </form>';
    } else {
        echo "No se encontró la compra.";
    }
}

echo "<br><a href='compra_leer.php'>Ver registros de Compras</a>";
echo "<br><a href='/modules/login/iniciar_sesion.php'>Volver a Inicio</a>";

// Cerramos la conexión a la base de datos
mysqli_close($con);
?>