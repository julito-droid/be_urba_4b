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
    <h2>Ventas</h2>
    <a href="venta_registrar.php">Agregar Venta</a>
    <a href="venta_crear_excel.php">Generar Excel de Ventas</a>
    <a href="/modules/login/iniciar_sesion.php">Volver a Inicio</a>

    <?php
    include '../../func_resources/php/conexion.php';
    $con = conectar();
    $sql_ventas = "SELECT * FROM ventas";
    $query_ventas = mysqli_query($con, $sql_ventas);

            // Comprobamos si hay resultados
    if (mysqli_num_rows($query_ventas) > 0) {
      echo '<table>
      <thead>
      <tr>
      <th>ID Venta</th>
      <th>ID Producto</th>
      <th>Fecha</th>
      <th>Cantidad</th>
      <th>Precio Total</th>
      <th>Acciones</th>
      </tr>
      </thead>
      <tbody>';
                // Iteramos sobre los resultados
      while ($row = mysqli_fetch_assoc($query_ventas)) {
                    // Accedemos a los datos de cada fila
        $id_venta = $row['id_venta'];
        $id_producto = $row['id_producto'];
        $fecha_venta = $row['fecha_venta'];
        $cantidad = $row['cantidad'];
        $precio_total = $row['precio_total'];

                    // Agregamos una fila a la tabla con los datos y los botones de editar y eliminar
        echo "<tr>
        <td>$id_venta</td>
        <td>$id_producto</td>
        <td>$fecha_venta</td>
        <td>$cantidad</td>
        <td>$precio_total</td>
        <td>
        <a href='venta_actualizar.php?id=$id_venta'>Editar</a>
        <a href='venta_eliminar.php?id=$id_venta'>Eliminar</a>
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