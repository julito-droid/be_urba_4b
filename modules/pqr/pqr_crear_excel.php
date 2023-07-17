<?php

// ************************ Validacion Acceso a Pagina ************************

// Si no existe las cookies o si no es usuario Vendedor (2) con identificación, 
// Cliente (1), Asesor (3) o Admin (4) genera error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");

} elseif (!(($_COOKIE['tipo_usuario'] == 2 || $_COOKIE['tipo_usuario'] == 1) 
	         && isset($_GET['identificacion']))) {
  if (!($_COOKIE['tipo_usuario'] == 3 || $_COOKIE['tipo_usuario'] == 4)) {
    header("Location: /error/404.php");
  }
}


// ********************** Fin Validacion Acceso a Pagina **********************

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$config = include '../../func_resources/php/config.php';

$spreadsheet = new Spreadsheet();
$nombre_archivo = 'Exportacion_PQR_' . $config['db']['trdm'] .'_ID-' . $_COOKIE['identificacion'];

// Conectar a la base de datos MySQL
$servername = $config['db']['host'];
$username = $config['db']['user'];
$password = $config['db']['pass'];
$dbname = $config['db']['name'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ejecutar la consulta MySQL
$query = isset($_GET['identificacion']) ? 
				 "SELECT * FROM tbl_pqr WHERE pqr__identificacion_solicitante = "
				                                        . $_GET['identificacion']
				 : "SELECT * FROM tbl_pqr";
$result = $conn->query($query);

// Verificar si hay resultados
if ($result->num_rows > 0) {
	// Definir la primera fila como encabezados de columna
    static $rowNumber = 1;

	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('A'.$rowNumber, '#')
          ->setCellValue('B'.$rowNumber, 'Identificación')
          ->setCellValue('C'.$rowNumber, 'Tipo de PQR')
          ->setCellValue('D'.$rowNumber, 'Puntuación')
          ->setCellValue('F'.$rowNumber, 'Descripción')
          ->setCellValue('G'.$rowNumber, 'Estado')
          ->setCellValue('E'.$rowNumber, 'Fecha');

	$sheet->getStyle('A'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('B'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('C'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('D'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('E'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('F'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('G'.$rowNumber)->getFont()->setBold(true);

	while ($row = $result->fetch_assoc()) {
		$rowNumber++;
        $sheet->setCellValue('A'.$rowNumber, $row["pqr__id_pqr"])
              ->setCellValue('B'.$rowNumber, $row["pqr__identificacion_solicitante"])
              ->setCellValue('C'.$rowNumber, $row["pqr__tipo_pqr"])
              ->setCellValue('D'.$rowNumber, $row["pqr__puntuacion_calidad"])
              ->setCellValue('F'.$rowNumber, $row["pqr__descripcion"])
              ->setCellValue('G'.$rowNumber, $row["pqr__respondido"] ? "Respondido" : "No respondido" )
              ->setCellValue('E'.$rowNumber, $row["pqr__fecha_pqr"]);
    }

    // Ajustar automáticamente el ancho de las columnas
	foreach (range('A', 'G') as $column) {
        $sheet->getColumnDimension($column)
              ->setAutoSize(true);
    }
} elseif (!$result->num_rows) {
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('A1', 'No hay registros de PQR.');
	$sheet->getStyle('A1')->getFont()->setBold(true)->setItalic(true);
	$sheet->getColumnDimension('A')->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);

// Establece las cabeceras para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $nombre_archivo . '.xlsx"');

// Guarda el archivo y envíalo al navegador
$writer->save('php://output');