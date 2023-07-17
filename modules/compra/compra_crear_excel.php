<?php

// ************************ Validacion Acceso a Pagina ************************

// Sino existe las cookies o si no es usuario Asesor (3) o Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 3 || $_COOKIE['tipo_usuario'] == 4)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$config = include '../../func_resources/php/config.php';

$spreadsheet = new Spreadsheet();
$nombre_archivo = 'Exportacion_Compras_' . $config['db']['trdm'] .'_ID-' . $_COOKIE['identificacion'];

// Conectar a la base de datos MySQL
$servername = $config['db']['host'];
$username = $config['db']['user'];
$password = $config['db']['pass'];
$dbname = $config['db']['name'];

# Ajusta la conexión a la Base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ejecutar la consulta MySQL
$query = "SELECT * FROM compras";
$result = $conn->query($query);

// Verificar si hay resultados
if ($result->num_rows > 0) {
	
	// Definir la primera fila como encabezados de columna
  static $rowNumber = 1;

	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('A'.$rowNumber, '#')
        ->setCellValue('B'.$rowNumber, 'Fecha')
        ->setCellValue('C'.$rowNumber, 'Cantidad')
        ->setCellValue('D'.$rowNumber, 'Descripción')
        ->setCellValue('E'.$rowNumber, 'Precio Unitario')
        ->setCellValue('F'.$rowNumber, 'Total')
        ->setCellValue('G'.$rowNumber, 'ID Proveedor')
        ->setCellValue('H'.$rowNumber, 'ID Producto');

	$sheet->getStyle('A'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('B'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('C'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('D'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('E'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('F'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('G'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('H'.$rowNumber)->getFont()->setBold(true);

	while ($row = $result->fetch_assoc()) {
		$rowNumber++;
        $sheet->setCellValue('A'.$rowNumber, $row["id_compra"])
              ->setCellValue('B'.$rowNumber, $row["fecha_compra"])
              ->setCellValue('C'.$rowNumber, $row["cantidad"])
              ->setCellValue('D'.$rowNumber, $row["descripcion"])
              ->setCellValue('E'.$rowNumber, $row["precio_und"])
              ->setCellValue('F'.$rowNumber, $row["total"])
              ->setCellValue('G'.$rowNumber, $row["id_proveedor"])
              ->setCellValue('H'.$rowNumber, $row["id_producto"]);
    }

    // Ajustar automáticamente el ancho de las columnas
	foreach (range('A', 'H') as $column) {
        $sheet->getColumnDimension($column)
              ->setAutoSize(true);
    }

} 

// Si no hay registros en la base de datos muestra un mensaje al respecto
elseif (!$result->num_rows) {
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('A1', 'No hay registros de compras.');
	$sheet->getStyle('A1')->getFont()->setBold(true)->setItalic(true);
	$sheet->getColumnDimension('A')->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);

// Establece las cabeceras para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $nombre_archivo . '.xlsx"');

// Guarda el archivo y envíalo al navegador
$writer->save('php://output');