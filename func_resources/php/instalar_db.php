<?php
$config = include 'config.php';

$conexion = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass']);

if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}

$sql = file_get_contents("../../data/db.sql");

if (mysqli_multi_query($conexion, $sql)) {
  echo "La base de datos 'be_urban_4b' se ha creado con éxito. <a href='instalar_db_procedimientos.ph'>Click aquí para instalar los procedimientos de la base de datos.</a>";
} else {
  echo "Error en la creación de la base de datos: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>