<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$config = include '../../func_resources/php/config.php';

$spreadsheet = new Spreadsheet();
$nombre_archivo = 'Exportacion_Usuarios_BeUrban-Admin'; # TODO: Cambiar "Admin" por el nombre de quien crea el archivo

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
$query = "SELECT * FROM tbl_usuarios";
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
          ->setCellValue('I'.$rowNumber, 'Tipo de usuario');

	$sheet->getStyle('A'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('B'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('C'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('D'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('E'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('F'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('G'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('H'.$rowNumber)->getFont()->setBold(true);
	$sheet->getStyle('I'.$rowNumber)->getFont()->setBold(true);

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
              ->setCellValue('I'.$rowNumber, $row["usr__tipo_usuario"]);
    }

    // Ajustar automáticamente el ancho de las columnas
	foreach (range('A', 'I') as $column) {
        $sheet->getColumnDimension($column)
              ->setAutoSize(true);
    }
} elseif (!$result->num_rows) {
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