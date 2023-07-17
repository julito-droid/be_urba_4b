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

  <div id="inventario" class="module">
    <h2>Inventario</h2>
    <a href="producto_registrar.php">Agregar Producto</a>
    <a href="producto_crear_excel.php">Generar Excel de Productos</a>
    <a href="/modules/login/iniciar_sesion.php">Volver a Inicio</a>

    <?php

    include '../../func_resources/php/conexion.php';
    $con = conectar();

    $sql_inventario = "SELECT * FROM productos";
    $query_inventario = mysqli_query($con, $sql_inventario);

            // Comprobamos si hay resultados
    if (mysqli_num_rows($query_inventario) > 0) {
      echo '<table>
      <thead>
      <tr>
      <th>ID Producto</th>
      <th>Cantidad</th>
      <th>ID Tipo</th>
      <th>ID Talla</th>
      <th>ID Color</th>
      <th>Precio Unitario</th>
      <th>Acciones</th>
      </tr>
      </thead>
      <tbody>';
                // Iteramos sobre los resultados
      while ($row = mysqli_fetch_assoc($query_inventario)) {
                    // Accedemos a los datos de cada fila
        $id_producto = $row['id_producto'];
        $cantidad = $row['cantidad'];
        $id_tipo = $row['id_tipo'];
        $id_talla = $row['id_talla'];
        $id_color = $row['id_color'];
        $precio_und = $row['precio_und'];

                    // Agregamos una fila a la tabla con los datos y los botones de editar y eliminar
        echo "<tr>
        <td>$id_producto</td>
        <td>$cantidad</td>
        <td>$id_tipo</td>
        <td>$id_talla</td>
        <td>$id_color</td>
        <td>$precio_und</td>
        <td>
        <a href='producto_actualizar.php?id=$id_producto'>Editar</a>
        <a href='producto_eliminar.php?id=$id_producto'>Eliminar</a>
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