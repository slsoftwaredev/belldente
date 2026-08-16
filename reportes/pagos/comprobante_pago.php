<?php
date_default_timezone_set('America/Guayaquil');
require_once __DIR__ . '/../../libs/fpdf.php';
function pdfText($texto){
    return iconv('UTF-8','windows-1252//TRANSLIT',$texto);
}

/* =========================================================
   DATOS DE PRUEBA
   Después vendrán de la BDD
========================================================= */
$numeroComprobante = 'PAG-000001';

$fecha = date('d/m/Y');
$hora  = date('H:i');

$nombrePaciente = 'MARIA FANNY BONILLA LECHÓN';
$cedulaPaciente = '1714820063';
$historiaClinica = '1714820063';

$detalles = [
    [
        'descripcion' => 'Exodoncia pieza dental #17',
        'valor' => 40.00
    ],
    [
        'descripcion' => 'Radiografía',
        'valor' => 10.00
    ]
];

$totalAtencion = 50.00;
$abonadoAnterior = 20.00;
$pagoRecibido = 30.00;
$saldoPendiente = 0.00;

$formaPago = 'Efectivo';

$responsable = 'Nombre del responsable';

/* =========================================================
   PDF
========================================================= */
class PDFComprobantePago extends FPDF{
    function Header(){
        $rutaLogo =__DIR__.'/../../public/assets/img/documentos/Logo_certificado.jpg';
        if (file_exists($rutaLogo)) {
            $this->Image($rutaLogo,55,8,100);
        }
        $this->SetY(40);
        $this->SetFont('Arial','B',16);
        $this->Cell(0,8,pdfText('COMPROBANTE DE PAGO'),0,1,'C');
        $this->Ln(4);
    }

    function Footer(){
        $this->SetFillColor(0, 0, 0);
        $this->Rect(0,277,210,20,'F');
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','',8);

        // TELÉFONOS
        $this->SetXY(12, 281);
        $this->MultiCell(55,4,pdfText("0939836297\n0980822876"),0,'C');

        // CORREOS
        $this->SetXY(72, 281);
        $this->MultiCell(65,4,pdfText("nahui.lema@hotmail.com\n"."dtr.lema@hotmail.it"),0,'C');

        // DIRECCIONES
        $this->SetXY(140, 281);
        $this->MultiCell(65,4,pdfText("Calle Sucre y Quiroga - Otavalo\n"."Plaza de los Ponchos"),0,'C');
        $this->SetTextColor(0,0,0);
    }
}

/* =========================================================
   CREAR DOCUMENTO
========================================================= */
$pdf = new PDFComprobantePago('P','mm','A4');
$pdf->SetMargins(15,10,15);
$pdf->SetAutoPageBreak(true,25);
$pdf->AddPage();
$pdf->SetY(58);

/* =========================================================
   NÚMERO / FECHA / HORA
========================================================= */
$pdf->SetFont('Arial','B',10);
$pdf->Cell(90,7,pdfText('Comprobante: ' . $numeroComprobante),0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(90,7,pdfText('Fecha: '.$fecha . '    Hora: '. $hora),0,1,'R');
$pdf->Ln(5);

/* =========================================================
   PACIENTE
========================================================= */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,pdfText('DATOS DEL PACIENTE'),0,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,pdfText('Paciente: '.$nombrePaciente),0,1);
$pdf->Cell(0,6,pdfText('C.I.: '.$cedulaPaciente),0,1);
$pdf->Cell(0,6,pdfText('Historia Clínica: '.$historiaClinica),0,1);
$pdf->Ln(7);

/* =========================================================
   DETALLE
========================================================= */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,pdfText('DETALLE'),0,1);
$pdf->Ln(2);

/* CABECERA */
$pdf->SetFillColor(235,235,235);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(145,8,pdfText('PROCEDIMIENTO / TRATAMIENTO'),1,0,'L',true);
$pdf->Cell(35,8,pdfText('VALOR'),1,1,'C',true);

/* FILAS */
$pdf->SetFont('Arial','',9);
foreach ($detalles as $detalle) {
    $pdf->Cell(145,8,pdfText($detalle['descripcion']),1,0);
    $pdf->Cell(35,8,'$ '.number_format($detalle['valor'],2),1,1,'R');
}
$pdf->Ln(7);

/* =========================================================
   RESUMEN DEL PAGO
========================================================= */
$pdf->SetFont('Arial','',10);
$pdf->Cell(130,7,pdfText('Total de la atención:'),0,0,'R');
$pdf->Cell(50,7,'$ '.number_format($totalAtencion,2),0,1,'R');
$pdf->Cell(130,7,pdfText('Abonado anteriormente:'),0,0,'R');
$pdf->Cell(50,7,'$ '.number_format($abonadoAnterior,2),0,1,'R');

/* PAGO RECIBIDO */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(130,8,pdfText('PAGO RECIBIDO:'),0,0,'R');
$pdf->Cell(50,8,'$ '.number_format($pagoRecibido,2),0,1,'R');

/* SALDO */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(130,8,pdfText('SALDO PENDIENTE:'),0,0,'R');
$pdf->Cell(50,8,'$ '.number_format($saldoPendiente,2),0,1,'R');
$pdf->Ln(7);

/* =========================================================
   FORMA DE PAGO
========================================================= */
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,pdfText('Forma de pago: '.$formaPago),0,1);
$pdf->Ln(12);

/* =========================================================
   ESTADO
========================================================= */
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,pdfText('PAGO COMPLETO'),1,1,'C');
$pdf->Ln(18);

/* =========================================================
   RESPONSABLE
========================================================= */
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,pdfText($responsable),0,1,'C');
$pdf->Cell(0,5,pdfText('Responsable del cobro'),0,1,'C');

/* =========================================================
   SALIDA
========================================================= */
$pdf->Output('I','comprobante_pago.pdf');