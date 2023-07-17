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
    <title>Crear Producto</title>
</head>
<body>
    <?php
    include("../../func_resources/php/conexion.php");
    $con = conectar();

    // Verificar si se envió el formulario de creación
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $cantidad = $_POST["cantidad"];
        $id_tipo = $_POST["id_tipo"];
        $id_talla = $_POST["id_talla"];
        $id_color = $_POST["id_color"];
        $precio_und = $_POST["precio_und"];

        // Insertar los datos del producto en la base de datos
        $sql = "INSERT INTO productos (cantidad, id_tipo, id_talla, id_color, precio_und) VALUES ($cantidad, $id_tipo, $id_talla, $id_color, $precio_und)";
        if (mysqli_query($con, $sql)) {
            echo "El producto se ha creado correctamente.";
        } else {
            echo "Error al crear el producto: " . mysqli_error($con);
        }
    }
    ?>

    <h1>Crear Producto</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" required><br>

        <label for="id_tipo">ID Tipo:</label>
        <input type="number" name="id_tipo" required><br>

        <label for="id_talla">ID Talla:</label>
        <input type="number" name="id_talla" required><br>

        <label for="id_color">ID Color:</label>
        <input type="number" name="id_color" required><br>

        <label for="precio_und">Precio Unitario:</label>
        <input type="number" name="precio_und" step="0.01" required><br>

        <input type="submit" value="Crear Producto">
    </form>

    <br><a href='producto_leer.php'>Ver registros de Productos</a>
    <br><a href='/modules/login/iniciar_sesion.php'>Volver a Inicio</a>

    <?php
    // Cerramos la conexión a la base de datos
    mysqli_close($con);
    ?>
</body>
</html>