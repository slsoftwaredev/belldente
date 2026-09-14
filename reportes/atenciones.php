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

$desde = isset($_GET['desde'])
    ? trim($_GET['desde'])
    : '';

$hasta = isset($_GET['hasta'])
    ? trim($_GET['hasta'])
    : '';

/* =========================================================
   OBTENER ATENCIONES
========================================================= */

$reporteModel = new Reporte();

$atenciones = $reporteModel->atenciones(
    $desde,
    $hasta
);

/* =========================================================
   TEXTO DEL PERÍODO
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

class PDFReporteAtenciones extends FPDF
{
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
            pdfText('REPORTE DE ATENCIONES'),
            0,
            1,
            'C'
        );

        $this->Ln(4);
    }

    function Footer()
    {
        $this->SetY(-25);

        $this->SetFillColor(
            0,
            0,
            0
        );

        $this->Rect(
            0,
            $this->GetY(),
            297,
            25,
            'F'
        );

        $this->SetTextColor(
            255,
            255,
            255
        );

        $this->SetFont(
            'Arial',
            '',
            8
        );

        $y = $this->GetY() + 5;

        /* TELÉFONOS */

        $this->SetXY(
            20,
            $y
        );

        $this->MultiCell(
            70,
            4,
            pdfText(
                "0939836297\n0980822876"
            ),
            0,
            'C'
        );

        /* CORREOS */

        $this->SetXY(
            110,
            $y
        );

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

        /* DIRECCIÓN */

        $this->SetXY(
            205,
            $y
        );

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

        $this->SetTextColor(
            0,
            0,
            0
        );
    }
}

/* =========================================================
   CREAR PDF
========================================================= */

$pdf = new PDFReporteAtenciones(
    'L',
    'mm',
    'A4'
);

$pdf->SetMargins(
    10,
    10,
    10
);

$pdf->SetAutoPageBreak(
    true,
    30
);

$pdf->AddPage();

$pdf->SetY(56);

/* =========================================================
   INFORMACIÓN DEL REPORTE
========================================================= */

$pdf->SetFont(
    'Arial',
    '',
    10
);

$pdf->Cell(
    150,
    7,
    pdfText(
        'Período: ' . $periodo
    ),
    0,
    0
);

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
        'Total de atenciones: ' .
        count($atenciones)
    ),
    0,
    1
);

$pdf->Ln(5);

/* =========================================================
   CABECERA
========================================================= */

$pdf->SetFillColor(
    235,
    235,
    235
);

$pdf->SetFont(
    'Arial',
    'B',
    8
);

$pdf->Cell(
    15,
    8,
    'Nro.',
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    28,
    8,
    pdfText('Fecha'),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    30,
    8,
    pdfText('Cédula'),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    65,
    8,
    pdfText('Paciente'),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    32,
    8,
    pdfText('Hora inicio'),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    32,
    8,
    pdfText('Hora fin'),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    30,
    8,
    pdfText('Estado'),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    45,
    8,
    pdfText('Profesional'),
    1,
    1,
    'C',
    true
);

/* =========================================================
   FILAS
========================================================= */

$pdf->SetFont(
    'Arial',
    '',
    8
);

$numero = 1;

foreach ($atenciones as $atencion) {

    $paciente =
        $atencion['nombre_paciente'] .
        ' ' .
        $atencion['apellido_paciente'];

    $profesional =
        $atencion['nombre_usuario'] .
        ' ' .
        $atencion['apellido_usuario'];

    /* FECHA E INICIO */

    $fecha = '';
    $horaInicio = '';

    if (!empty($atencion['fecha_inicio'])) {

        $timestampInicio =
            strtotime(
                $atencion['fecha_inicio']
            );

        $fecha =
            date(
                'd/m/Y',
                $timestampInicio
            );

        $horaInicio =
            date(
                'H:i',
                $timestampInicio
            );
    }

    /* HORA FIN */

    $horaFin = '---';

    if (!empty($atencion['fecha_fin'])) {

        $horaFin =
            date(
                'H:i',
                strtotime(
                    $atencion['fecha_fin']
                )
            );
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
        28,
        8,
        $fecha,
        1,
        0,
        'C'
    );

    $pdf->Cell(
        30,
        8,
        pdfText(
            $atencion['cedula_paciente']
        ),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        65,
        8,
        pdfText($paciente),
        1,
        0
    );

    $pdf->Cell(
        32,
        8,
        $horaInicio,
        1,
        0,
        'C'
    );

    $pdf->Cell(
        32,
        8,
        $horaFin,
        1,
        0,
        'C'
    );

    $pdf->Cell(
        30,
        8,
        pdfText(
            $atencion[
                'nombre_estado_atencion'
            ]
        ),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        45,
        8,
        pdfText($profesional),
        1,
        1
    );

    $numero++;
}

/* =========================================================
   SIN REGISTROS
========================================================= */

if (count($atenciones) === 0) {

    $pdf->SetFont(
        'Arial',
        'I',
        9
    );

    $pdf->Cell(
        277,
        10,
        pdfText(
            'No existen atenciones para el período seleccionado.'
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
    'reporte_atenciones.pdf'
);