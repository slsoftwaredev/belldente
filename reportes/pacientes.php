<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

date_default_timezone_set('America/Guayaquil');

require_once __DIR__ . '/../libs/fpdf.php';
require_once __DIR__ . '/../model/reportes.php';

function pdfText($texto)
{
    return iconv(
        'UTF-8',
        'windows-1252//TRANSLIT',
        $texto
    );
}

/* =========================================================
   VALIDAR SESIÓN
========================================================= */

if (!isset($_SESSION['id_usuario'])) {
    die('Sesión no válida.');
}

/* =========================================================
   FILTRO
========================================================= */

$estado = isset($_GET['estado'])
    ? intval($_GET['estado'])
    : -1;

if (!in_array($estado, [-1, 0, 1], true)) {
    $estado = -1;
}

/* =========================================================
   OBTENER PACIENTES
========================================================= */

$reporteModel = new Reporte();

$pacientes = $reporteModel->pacientes($estado);

/* =========================================================
   TEXTO DEL FILTRO
========================================================= */

if ($estado === 1) {
    $filtroEstado = 'Activos';
} elseif ($estado === 0) {
    $filtroEstado = 'Inactivos';
} else {
    $filtroEstado = 'Todos';
}

/* =========================================================
   PDF
========================================================= */

class PDFReportePacientes extends FPDF
{
    function Header()
    {
        $rutaLogo =
            __DIR__ .
            '/../public/assets/img/documentos/Logo_certificado.jpg';

        if (file_exists($rutaLogo)) {
            $this->Image($rutaLogo, 55, 8, 100);
        }

        $this->SetY(40);

        $this->SetFont('Arial', 'B', 16);

        $this->Cell(
            0,
            8,
            pdfText('REPORTE DE PACIENTES'),
            0,
            1,
            'C'
        );

        $this->Ln(4);
    }

    function Footer()
    {
        $this->SetY(-25);

        $this->SetFillColor(0, 0, 0);

        $this->Rect(
            0,
            $this->GetY(),
            297,
            25,
            'F'
        );

        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', '', 8);

        $y = $this->GetY() + 5;

        // TELÉFONOS
        $this->SetXY(20, $y);

        $this->MultiCell(
            70,
            4,
            pdfText("0939836297\n0980822876"),
            0,
            'C'
        );

        // CORREOS
        $this->SetXY(110, $y);

        $this->MultiCell(
            80,
            4,
            pdfText(
                "nahui.lema@hotmail.com\n" .
                "dtr.lema@hotmail.it"
            ),
            0,
            'C'
        );

        // DIRECCIÓN
        $this->SetXY(205, $y);

        $this->MultiCell(
            75,
            4,
            pdfText(
                "Calle Sucre y Quiroga - Otavalo\n" .
                "Plaza de los Ponchos"
            ),
            0,
            'C'
        );

        $this->SetTextColor(0, 0, 0);
    }
}

/* =========================================================
   CREAR DOCUMENTO
========================================================= */

$pdf = new PDFReportePacientes(
    'L',
    'mm',
    'A4'
);

$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 30);

$pdf->AddPage();

$pdf->SetY(56);

/* =========================================================
   INFORMACIÓN DEL REPORTE
========================================================= */

$pdf->SetFont('Arial', '', 10);

$pdf->Cell(
    140,
    7,
    pdfText('Estado: ' . $filtroEstado),
    0,
    0
);

$pdf->Cell(
    137,
    7,
    pdfText(
        'Fecha de generación: ' .
        date('d/m/Y H:i')
    ),
    0,
    1,
    'R'
);

$pdf->Cell(
    140,
    7,
    pdfText(
        'Total de pacientes: ' .
        count($pacientes)
    ),
    0,
    1
);

$pdf->Ln(5);

/* =========================================================
   CABECERA DE TABLA
========================================================= */

$pdf->SetFillColor(235, 235, 235);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(15, 8, 'Nro.', 1, 0, 'C', true);
$pdf->Cell(30, 8, pdfText('Cédula'), 1, 0, 'C', true);
$pdf->Cell(65, 8, pdfText('Paciente'), 1, 0, 'C', true);
$pdf->Cell(22, 8, pdfText('Sexo'), 1, 0, 'C', true);
$pdf->Cell(32, 8, pdfText('Teléfono'), 1, 0, 'C', true);
$pdf->Cell(70, 8, pdfText('Correo'), 1, 0, 'C', true);
$pdf->Cell(25, 8, pdfText('Estado'), 1, 0, 'C', true);
$pdf->Cell(18, 8, pdfText('Edad'), 1, 1, 'C', true);

/* =========================================================
   FILAS
========================================================= */

$pdf->SetFont('Arial', '', 8);

$numero = 1;

foreach ($pacientes as $paciente) {

    $nombre =
        $paciente['nombre_paciente'] .
        ' ' .
        $paciente['apellido_paciente'];

    $sexo = '';

    if ($paciente['sexo_paciente'] === 'M') {
        $sexo = 'Masculino';
    } elseif ($paciente['sexo_paciente'] === 'F') {
        $sexo = 'Femenino';
    }

    $estadoPaciente =
        intval($paciente['estado_paciente']) === 1
            ? 'Activo'
            : 'Inactivo';

    /* EDAD */

    $edad = '';

    if (!empty($paciente['fecha_nacimiento'])) {

        $nacimiento =
            new DateTime(
                $paciente['fecha_nacimiento']
            );

        $hoy = new DateTime();

        $edad =
            $hoy->diff($nacimiento)->y;
    }

    $pdf->Cell(
        15,
        8,
        $numero,
        1,
        0,
        'C'
    );

    $pdf->Cell(
        30,
        8,
        pdfText($paciente['cedula_paciente']),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        65,
        8,
        pdfText($nombre),
        1,
        0
    );

    $pdf->Cell(
        22,
        8,
        pdfText($sexo),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        32,
        8,
        pdfText(
            $paciente['telefono_paciente'] ?? ''
        ),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        70,
        8,
        pdfText(
            $paciente['correo_paciente'] ?? ''
        ),
        1,
        0
    );

    $pdf->Cell(
        25,
        8,
        pdfText($estadoPaciente),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        18,
        8,
        $edad,
        1,
        1,
        'C'
    );

    $numero++;
}

/* =========================================================
   SIN REGISTROS
========================================================= */

if (count($pacientes) === 0) {

    $pdf->SetFont('Arial', 'I', 9);

    $pdf->Cell(
        277,
        10,
        pdfText(
            'No existen pacientes para el filtro seleccionado.'
        ),
        1,
        1,
        'C'
    );
}

/* =========================================================
   SALIDA
========================================================= */

$pdf->Output(
    'I',
    'reporte_pacientes.pdf'
);