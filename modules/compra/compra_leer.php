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
    <h2>Compras</h2>
    <a href="compra_registrar.php">Agregar Compra</a>
    <a href="compra_crear_excel.php">Generar Excel de Compras</a>
    <a href="/modules/login/iniciar_sesion.php">Volver a Inicio</a>

    <?php
    include '../../func_resources/php/conexion.php';
    $con = conectar();

    $sql_compras = "SELECT * FROM compras";
    $query_compras = mysqli_query($con, $sql_compras);

    // Comprobamos si hay resultados
    if (mysqli_num_rows($query_compras) > 0) {
      echo '<table>
      <thead>
      <tr>
      <th>ID Compra</th>
      <th>Fecha</th>
      <th>Cantidad</th>
      <th>Descripción</th>
      <th>Precio Unitario</th>
      <th>Total</th>
      <th>ID Proveedor</th>
      <th>ID Producto</th>
      <th>Acciones</th>
      </tr>
      </thead>
      <tbody>';
    // Iteramos sobre los resultados
      while ($row = mysqli_fetch_assoc($query_compras)) {
      // Accedemos a los datos de cada fila
        $id_compra = $row['id_compra'];
        $fecha_compra = $row['fecha_compra'];
        $cantidad = $row['cantidad'];
        $descripcion = $row['descripcion'];
        $precio_und = $row['precio_und'];
        $total = $row['total'];
        $id_proveedor = $row['id_proveedor'];
        $id_producto = $row['id_producto'];

      // Agregamos una fila a la tabla con los datos y los botones de editar y eliminar
        echo "<tr>
        <td>$id_compra</td>
        <td>$fecha_compra</td>
        <td>$cantidad</td>
        <td>$descripcion</td>
        <td>$precio_und</td>
        <td>$total</td>
        <td>$id_proveedor</td>
        <td>$id_producto</td>
        <td>
        <a href='compra_actualizar.php?id=$id_compra'>Editar</a>
        <a href='compra_eliminar.php?id=$id_compra'>Eliminar</a>
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