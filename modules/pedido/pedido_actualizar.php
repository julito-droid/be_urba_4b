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
    $id_pedido = $_POST["id_pedido"];
    $fecha = $_POST["fecha"];
    $direccion = $_POST["direccion"];
    $id_estado = $_POST["id_estado"];
    $id_producto = $_POST["id_producto"];
    $id_usuario = $_POST["id_usuario"];

    // Actualizar los datos del pedido en la base de datos
    $sql = "UPDATE pedidos SET fecha = '$fecha', direccion = '$direccion', id_estado = $id_estado, id_producto = $id_producto, id_usuario = $id_usuario WHERE id_pedido = $id_pedido";
    if (mysqli_query($con, $sql)) {
        echo "El pedido se ha actualizado correctamente.";
    } else {
        echo "Error al actualizar el pedido: " . mysqli_error($con);
    }
}

// Obtener el ID del pedido a editar
if (isset($_GET["id"])) {
    $id_pedido = $_GET["id"];

    // Consultar los datos del pedido a editar
    $sql = "SELECT * FROM pedidos WHERE id_pedido = $id_pedido";
    $query = mysqli_query($con, $sql);

    // Comprobar si se encontró el pedido
    if (mysqli_num_rows($query) == 1) {
        // Obtener los datos del pedido
        $row = mysqli_fetch_assoc($query);
        $id_pedido = $row['id_pedido'];
        $fecha = $row['fecha'];
        $direccion = $row['direccion'];
        $id_estado = $row['id_estado'];
        $id_producto = $row['id_producto'];
        $id_usuario = $row['id_usuario'];

        // Mostrar el formulario de edición con los datos del pedido
        echo '
        <h1>Editar Pedido</h1>
        <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <input type="hidden" name="id_pedido" value="' . $id_pedido . '">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" value="' . $fecha . '" required><br>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" value="' . $direccion . '" required><br>

            <label for="id_estado">ID Estado:</label>
            <input type="number" name="id_estado" value="' . $id_estado . '" required><br>

            <label for="id_producto">ID Producto:</label>
            <input type="number" name="id_producto" value="' . $id_producto . '" required><br>

            <label for="id_usuario">ID Usuario:</label>
            <input type="number" name="id_usuario" value="' . $id_usuario . '" required><br>

            <input type="submit" value="Actualizar Pedido">
        </form>';
    } else {
        echo "No se encontró el pedido.";
    }
}

echo '<br> <a class="btn btn-primary" href="pedido_leer.php">Ver registros de Pedidos</a> <br>';
echo '<a class="btn btn-primary" href="/modules/login/iniciar_sesion.php">Ir a Inicio</a> <br>';

// Cerramos la conexión a la base de datos
mysqli_close($con);

?>