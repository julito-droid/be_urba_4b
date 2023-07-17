<?php

// ************************ Validacion Acceso a Pagina ************************

// Sino existe las cookies o si no es usuario Vendedor (2) o Admin (4) da error

if (!isset($_COOKIE['tipo_usuario'])) {
    header("Location: /error/404.php");
} elseif (!($_COOKIE['tipo_usuario'] == 2 || $_COOKIE['tipo_usuario'] == 4)) {
  header("Location: /error/404.php");
}

// ********************** Fin Validacion Acceso a Pagina **********************

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$config = include '../../func_resources/php/config.php';

$spreadsheet = new Spreadsheet();
$nombre_archivo = 'Exportacion_Usuarios_' . $config['db']['trdm'] .'_ID-' . $_COOKIE['identificacion'];

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
$query = isset($_GET['identificacion']) ? 
				 "SELECT * FROM tbl_usuarios WHERE usr__numero_identificacion LIKE '%"
				                                       . $_GET['identificacion'] . "%'"
				 : "SELECT * FROM tbl_usuarios";
$result = $conn->query($query);

// Verificar si hay resultados
if ($result->num_rows > 0) {
	
	// Definir la primera fila como encabezados de columna
  static $rowNumber = 1;

	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('A'.$rowNumber, '# Documento')
        ->setCellValue('B'.$rowNumber, 'Primer Nombre')
        ->setCellValue('C'.$rowNumber, 'Segundo Nombre')
        ->setCellValue('D'.$rowNumber, 'Primer Apellido')
        ->setCellValue('E'.$rowNumber, 'Segundo Apellido')
        ->setCellValue('F'.$rowNumber, 'Correo Electrónico')
        ->setCellValue('G'.$rowNumber, 'Número de Teléfono')
        ->setCellValue('H'.$rowNumber, 'Dirección de Residencia')
        ->setCellValue('I'.$rowNumber, 'Tipo de usuario')
        ->setCellValue('J'.$rowNumber, 'Fecha de creación')
        ->setCellValue('K'.$rowNumber, 'Fecha de actualización');

	$sheet->getStyle('A'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('B'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('C'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('D'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('E'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('F'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('G'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('H'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('I'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('J'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('K'.$rowNumber)->getFont()->setBold(true);

	while ($row = $result->fetch_assoc()) {
		$rowNumber++;
        $sheet->setCellValue('A'.$rowNumber, $row["usr__numero_identificacion"])
              ->setCellValue('B'.$rowNumber, $row["usr__nombre1"])
              ->setCellValue('C'.$rowNumber, $row["usr__nombre2"])
              ->setCellValue('D'.$rowNumber, $row["usr__apellido1"])
              ->setCellValue('E'.$rowNumber, $row["usr__apellido2"])
              ->setCellValue('F'.$rowNumber, $row["usr__correo_electronico"])
              ->setCellValue('G'.$rowNumber, $row["usr__numero_celular"])
              ->setCellValue('H'.$rowNumber, $row["usr__direccion"])
              ->setCellValue('I'.$rowNumber, $row["usr__tipo_usuario"])
              ->setCellValue('J'.$rowNumber, $row["usr__fecha_creacion"])
          	  ->setCellValue('K'.$rowNumber, $row["usr__fecha_actualización"]);
    }

    // Ajustar automáticamente el ancho de las columnas
	foreach (range('A', 'K') as $column) {
        $sheet->getColumnDimension($column)
              ->setAutoSize(true);
    }

} 

// Si no hay registros en la base de datos muestra un mensaje al respecto
elseif (!$result->num_rows) {
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('A1', 'No hay registros de usuarios.');
	$sheet->getStyle('A1')->getFont()->setBold(true)->setItalic(true);
	$sheet->getColumnDimension('A')->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);

// Establece las cabeceras para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $nombre_archivo . '.xlsx"');

// Guarda el archivo y envíalo al navegador
$writer->save('php://output');