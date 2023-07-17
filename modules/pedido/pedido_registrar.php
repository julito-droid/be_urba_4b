<?php

// ************************ Validacion Acceso a Pagina ************************

// Sino existe las cookies o si no es usuario Cliente (1), Vendedor (2) o 
// Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 2 || $_COOKIE['tipo_usuario'] == 4 || 
            $_COOKIE['tipo_usuario'] == 1)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

include("../../func_resources/php/conexion.php");
$con = conectar();

$sql = "SELECT * FROM pedidos";
$query = mysqli_query($con, $sql);


// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $fecha = $_POST["fecha"];
    $direccion = $_POST["direccion"];
    $id_estado = $_POST["id_estado"];
    $id_producto = $_POST["id_producto"];
    $id_usuario = $_POST["id_usuario"];

    // Insertar los datos del pedido en la base de datos
    $sql = "INSERT INTO pedidos (fecha, direccion, id_estado, id_producto, usr__numero_identificacion) VALUES ('$fecha', '$direccion', $id_estado, $id_producto, $id_usuario)";
    if (mysqli_query($con, $sql)) {
        echo "El pedido se ha registrado correctamente.";
    } else {
        echo "Error al registrar el pedido: " . mysqli_error($con);
    }
}



?>

<h1>Formulario de Pedido</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br>

        <label for="id_estado">ID Estado:</label>
        <input type="number" name="id_estado" required><br>

        <label for="id_producto">ID Producto:</label>
        <input type="number" name="id_producto" required><br>

        <label for="id_usuario">ID Usuario:</label>
        <input type="number" name="id_usuario" required><br>

        <input type="submit" value="Enviar Pedido">
    </form>
    <a class="btn btn-primary" href="/modules/login/iniciar_sesion.php">Ir a Inicio</a> <br>
    <?php if ($_COOKIE['tipo_usuario'] == 2 || $_COOKIE['tipo_usuario'] == 4) { ?>
        <a class="btn btn-primary" href="pedido_leer.php">Ver registros de Pedidos</a>
    <?php } ?>
</body>
</html>