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

<?php include '../../templates/header.php'; ?>

<style>
/* Estilos CSS para el dashboard */
body {
  font-family: Arial, sans-serif;
}

header {
  background-color: #333;
  color: #fff;
  padding: 20px;
}

h1 {
  margin: 0;
}

nav {
  background-color: #f4f4f4;
  padding: 10px;
}

nav ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

nav ul li {
  display: inline;
  margin-right: 10px;
}

main {
  padding: 20px;
}

.module {
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 20px;
}
</style>
<main>

  <div id="compras" class="module">
    <h2>Pedidos</h2>
    <a href="pedido_registrar.php">Agregar Pedido</a>
    <a href="/modules/login/iniciar_sesion.php">Volver a Inicio</a>

    <?php
    include '../../func_resources/php/conexion.php';
    $con = conectar();

    $sql = "SELECT * FROM pedidos";
    $query = mysqli_query($con, $sql);

            // Comprobamos si hay resultados
    if (mysqli_num_rows($query) > 0) {
      echo '<table>
      <thead>
      <tr>
      <th>ID Pedido</th>
      <th>Fecha</th>
      <th>Dirección</th>
      <th>ID Estado</th>
      <th>ID Producto</th>
      <th>ID Usuario</th>
      <th>Acciones</th>
      </tr>
      </thead>
      <tbody>';

                // Iteramos sobre los resultados
      while ($row = mysqli_fetch_assoc($query)) {

                    // Accedemos a los datos de cada fila
        $id_pedido = $row['id_pedido'];
        $fecha = $row['fecha'];
        $direccion = $row['direccion'];
        $id_estado = $row['id_estado'];
        $id_producto = $row['id_producto'];
        $id_usuario = $row['id_usuario'];

                    // Agregamos una fila a la tabla con los datos y los botones de editar y eliminar
        echo "  <tr>
        <td>$id_pedido</td>
        <td>$fecha</td>
        <td>$direccion</td>
        <td>$id_estado</td>
        <td>$id_producto</td>
        <td>$id_usuario</td>
        <td>
        <a href='actualizarPedido.php?id=$id_pedido'>Editar</a>
        <a href='eliminarPedido.php?id=$id_pedido'>Eliminar</a>
        </td>
        </tr>";
      }
      echo '</tbody>
      </table>';
    } else {
      echo "No se encontraron resultados.";
    }
    ?>
  </div>
</main>