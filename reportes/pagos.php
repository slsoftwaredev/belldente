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
   FILTROS
========================================================= */

$tipo = isset($_GET['tipo'])
    ? trim($_GET['tipo'])
    : 'movimientos';

$desde = isset($_GET['desde'])
    ? trim($_GET['desde'])
    : '';

$hasta = isset($_GET['hasta'])
    ? trim($_GET['hasta'])
    : '';

$formaPago = isset($_GET['forma_pago'])
    ? intval($_GET['forma_pago'])
    : 0;

if (!in_array($tipo, ['movimientos', 'pendientes'], true)) {
    $tipo = 'movimientos';
}

/* =========================================================
   MODELO
========================================================= */

$reporteModel = new Reporte();

if ($tipo === 'pendientes') {

    $datos = $reporteModel->cuentasCobrar();

} else {

    $datos = $reporteModel->movimientosPago(
        $desde,
        $hasta,
        $formaPago
    );
}

/* =========================================================
   PERÍODO
========================================================= */

if ($desde !== '' && $hasta !== '') {

    $periodo =
        date('d/m/Y', strtotime($desde)) .
        ' - ' .
        date('d/m/Y', strtotime($hasta));

} elseif ($desde !== '') {

    $periodo =
        'Desde ' .
        date('d/m/Y', strtotime($desde));

} elseif ($hasta !== '') {

    $periodo =
        'Hasta ' .
        date('d/m/Y', strtotime($hasta));

} else {

    $periodo = 'Todas las fechas';
}

/* =========================================================
   PDF
========================================================= */

class PDFReportePagos extends FPDF
{
    public $titulo = '';

    function Header()
    {
        $rutaLogo =
            __DIR__ .
            '/../public/assets/img/documentos/Logo_certificado.jpg';

        if (file_exists($rutaLogo)) {
            $this->Image(
                $rutaLogo,
                98,
                8,
                100
            );
        }

        $this->SetY(40);

        $this->SetFont(
            'Arial',
            'B',
            16
        );

        $this->Cell(
            0,
            8,
            pdfText($this->titulo),
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

        $this->SetXY(20, $y);

        $this->MultiCell(
            70,
            4,
            pdfText("0939836297\n0980822876"),
            0,
            'C'
        );

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
   CREAR PDF
========================================================= */

$pdf = new PDFReportePagos(
    'L',
    'mm',
    'A4'
);

$pdf->titulo = $tipo === 'pendientes'
    ? 'REPORTE DE CUENTAS POR COBRAR'
    : 'REPORTE DE MOVIMIENTOS DE PAGOS';

$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 30);

$pdf->AddPage();

$pdf->SetY(56);

/* =========================================================
   INFORMACIÓN GENERAL
========================================================= */

$pdf->SetFont('Arial', '', 10);

if ($tipo === 'movimientos') {

    $pdf->Cell(
        150,
        7,
        pdfText('Período: ' . $periodo),
        0,
        0
    );

} else {

    $pdf->Cell(
        150,
        7,
        pdfText('Estado: Cuentas con saldo pendiente'),
        0,
        0
    );
}

$pdf->Cell(
    127,
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
    150,
    7,
    pdfText(
        'Total de registros: ' .
        count($datos)
    ),
    0,
    1
);

$pdf->Ln(5);

/* =========================================================
   MOVIMIENTOS DE PAGOS
========================================================= */

if ($tipo === 'movimientos') {

    $pdf->SetFillColor(235, 235, 235);
    $pdf->SetFont('Arial', 'B', 8);

    $pdf->Cell(15, 8, 'Nro.', 1, 0, 'C', true);
    $pdf->Cell(35, 8, 'Fecha', 1, 0, 'C', true);
    $pdf->Cell(30, 8, pdfText('Cédula'), 1, 0, 'C', true);
    $pdf->Cell(70, 8, 'Paciente', 1, 0, 'C', true);
    $pdf->Cell(42, 8, 'Forma de pago', 1, 0, 'C', true);
    $pdf->Cell(35, 8, 'Valor recibido', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Estado', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 8);

    $numero = 1;
    $totalCobrado = 0;

    foreach ($datos as $fila) {

        $paciente =
            $fila['nombre_paciente'] .
            ' ' .
            $fila['apellido_paciente'];

        $fecha = date(
            'd/m/Y H:i',
            strtotime($fila['fecha_abono'])
        );

        $valor =
            (float)$fila['valor_abono'];

        $totalCobrado += $valor;

        $pdf->Cell(
            15,
            8,
            $numero,
            1,
            0,
            'C'
        );

        $pdf->Cell(
            35,
            8,
            $fecha,
            1,
            0,
            'C'
        );

        $pdf->Cell(
            30,
            8,
            pdfText($fila['cedula_paciente']),
            1,
            0,
            'C'
        );

        $pdf->Cell(
            70,
            8,
            pdfText($paciente),
            1,
            0
        );

        $pdf->Cell(
            42,
            8,
            pdfText($fila['nombre_forma_pago']),
            1,
            0,
            'C'
        );

        $pdf->Cell(
            35,
            8,
            '$ ' . number_format($valor, 2),
            1,
            0,
            'R'
        );

        $pdf->Cell(
            30,
            8,
            pdfText($fila['estado_pago']),
            1,
            1,
            'C'
        );

        $numero++;
    }

    if (count($datos) === 0) {

        $pdf->SetFont('Arial', 'I', 9);

        $pdf->Cell(
            257,
            10,
            pdfText(
                'No existen movimientos de pago para los filtros seleccionados.'
            ),
            1,
            1,
            'C'
        );

    } else {

        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(
            222,
            8,
            pdfText('TOTAL COBRADO:'),
            0,
            0,
            'R'
        );

        $pdf->Cell(
            35,
            8,
            '$ ' . number_format($totalCobrado, 2),
            0,
            1,
            'R'
        );
    }
}

/* =========================================================
   CUENTAS POR COBRAR
========================================================= */

else {

    $pdf->SetFillColor(235, 235, 235);
    $pdf->SetFont('Arial', 'B', 8);

    $pdf->Cell(15, 8, 'Nro.', 1, 0, 'C', true);
    $pdf->Cell(30, 8, pdfText('Cédula'), 1, 0, 'C', true);
    $pdf->Cell(70, 8, 'Paciente', 1, 0, 'C', true);
    $pdf->Cell(35, 8, pdfText('Teléfono'), 1, 0, 'C', true);
    $pdf->Cell(32, 8, 'Total', 1, 0, 'C', true);
    $pdf->Cell(32, 8, 'Abonado', 1, 0, 'C', true);
    $pdf->Cell(32, 8, 'Pendiente', 1, 0, 'C', true);
    $pdf->Cell(31, 8, 'Estado', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 8);

    $numero = 1;
    $totalPendiente = 0;

    foreach ($datos as $fila) {

        $paciente =
            $fila['nombre_paciente'] .
            ' ' .
            $fila['apellido_paciente'];

        $total =
            (float)$fila['total'];

        $abonado =
            (float)$fila['abonado'];

        $saldo =
            (float)$fila['saldo'];

        $totalPendiente += $saldo;

        $pdf->Cell(15, 8, $numero, 1, 0, 'C');

        $pdf->Cell(
            30,
            8,
            pdfText($fila['cedula_paciente']),
            1,
            0,
            'C'
        );

        $pdf->Cell(
            70,
            8,
            pdfText($paciente),
            1,
            0
        );

        $pdf->Cell(
            35,
            8,
            pdfText($fila['telefono_paciente']),
            1,
            0,
            'C'
        );

        $pdf->Cell(
            32,
            8,
            '$ ' . number_format($total, 2),
            1,
            0,
            'R'
        );

        $pdf->Cell(
            32,
            8,
            '$ ' . number_format($abonado, 2),
            1,
            0,
            'R'
        );

        $pdf->Cell(
            32,
            8,
            '$ ' . number_format($saldo, 2),
            1,
            0,
            'R'
        );

        $pdf->Cell(
            31,
            8,
            pdfText($fila['estado_pago']),
            1,
            1,
            'C'
        );

        $numero++;
    }

    if (count($datos) === 0) {

        $pdf->SetFont('Arial', 'I', 9);

        $pdf->Cell(
            277,
            10,
            pdfText(
                'No existen cuentas pendientes por cobrar.'
            ),
            1,
            1,
            'C'
        );

    } else {

        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(
            242,
            8,
            pdfText('TOTAL PENDIENTE:'),
            0,
            0,
            'R'
        );

        $pdf->Cell(
            35,
            8,
            '$ ' . number_format($totalPendiente, 2),
            0,
            1,
            'R'
        );
    }
}

/* =========================================================
   SALIDA
========================================================= */

$nombreArchivo = $tipo === 'pendientes'
    ? 'reporte_cuentas_por_cobrar.pdf'
    : 'reporte_movimientos_pagos.pdf';

$pdf->Output(
    'I',
    $nombreArchivo
);