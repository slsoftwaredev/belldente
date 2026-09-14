<?php
date_default_timezone_set('America/Guayaquil');
require_once __DIR__ . '/../../libs/fpdf.php';
function pdfText($texto){
    return iconv('UTF-8','windows-1252//TRANSLIT',$texto);
}

/* =========================================================
   DATOS DEL COMPROBANTE
========================================================= */
require_once __DIR__ . '/../../model/pagos.php';
$id_abono = isset($_GET['id_abono']) ? intval($_GET['id_abono']) : 0;
if ($id_abono <= 0) {
    die('Comprobante no válido.');
}

$pagoModel = new Pago();
$datos = $pagoModel->comprobante($id_abono);
if (!$datos) {
    die('No se encontró información del comprobante.');
}

/* Número de comprobante */
$numeroComprobante = 'ABO-' . str_pad($datos['id_abono'], 6, '0', STR_PAD_LEFT);

/* Fecha y hora reales del abono */
$timestamp = strtotime($datos['fecha_abono']);
$fecha = date('d/m/Y', $timestamp);
$hora  = date('H:i', $timestamp);

/* Paciente */
$nombrePaciente = $datos['nombre_paciente'] . ' ' .$datos['apellido_paciente'];
$cedulaPaciente = $datos['cedula_paciente'];

//Cédula como número de historia clínica
$historiaClinica = $datos['cedula_paciente'];

/* Valores */
$totalAtencion = (float)$datos['total'];
$totalAbonadoAnterior = (float)$datos['abonado_anterior'];
$saldoAnterior = (float)$datos['saldo_anterior'];
$abonoRecibido = (float)$datos['valor_abono'];
$nuevoSaldo = (float)$datos['saldo'];
$formaPago = $datos['nombre_forma_pago'];

/* Responsable */
$responsable = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'Responsable del cobro';

/* =========================================================
   PDF
========================================================= */
class PDFComprobanteAbono extends FPDF{
    function Header(){
        $rutaLogo = __DIR__. '/../../public/assets/img/documentos/Logo_certificado.jpg';
        if (file_exists($rutaLogo)) {
            $this->Image($rutaLogo,55,8,100);
        }
        $this->SetY(40);
        $this->SetFont('Arial','B',16);
        $this->Cell(0,8,pdfText('COMPROBANTE DE ABONO'),0,1,'C');
        $this->Ln(4);
    }
    function Footer(){
        $this->SetFillColor(0,0,0);
        $this->Rect(0,277,210,20,'F');
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','',8);
        $this->SetXY(12,281);
        $this->MultiCell(55,4,pdfText("0939836297\n0980822876"),0,'C');
        $this->SetXY(72,281);
        $this->MultiCell(65,4,pdfText("nahui.lema@hotmail.com\n"."dtr.lema@hotmail.it"),0,'C');
        $this->SetXY(140,281);
        $this->MultiCell(65,4,pdfText("Calle Sucre y Quiroga - Otavalo\n"."Plaza de los Ponchos"),0,'C');
        $this->SetTextColor(0,0,0);
    }
}

/* =========================================================
   CREAR DOCUMENTO
========================================================= */
$pdf = new PDFComprobanteAbono('P','mm','A4');
$pdf->SetMargins(15,10,15);
$pdf->SetAutoPageBreak(
    true,
    25);
$pdf->AddPage();
$pdf->SetY(58);

/* =========================================================
   COMPROBANTE / FECHA
========================================================= */
$pdf->SetFont('Arial','B',10);
$pdf->Cell(90,7,pdfText('Comprobante: '.$numeroComprobante),0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(90,7,pdfText('Fecha: '. $fecha. 'Hora: '. $hora),0,1,'R');
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
$pdf->Ln(8);

/* =========================================================
   DETALLE DE LA CUENTA
========================================================= */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,pdfText('DETALLE DE LA CUENTA'),0,1);
$pdf->Ln(3);
$pdf->SetFont('Arial','',10);

/* TOTAL */
$pdf->Cell(130,8,pdfText('Valor total de la atención:'),0,0,'R');
$pdf->Cell(50,8,'$ '.number_format($totalAtencion,2),0,1,'R');

/* ABONADO ANTES */
$pdf->Cell(130,8,pdfText('Total abonado anteriormente:'),0,0,'R');
$pdf->Cell(50,8,'$ '.number_format($totalAbonadoAnterior,2),0,1,'R');

/* SALDO ANTERIOR */
$pdf->Cell(130,8,pdfText('Saldo anterior:'),0,0,'R');
$pdf->Cell(50,8,'$ '.number_format($saldoAnterior,2),0,1,'R');
$pdf->Ln(10);

/* =========================================================
   ABONO RECIBIDO
========================================================= */
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,7,pdfText('ABONO RECIBIDO'),0,1,'C');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0,13,'$ '.number_format($abonoRecibido,2),0,1,'C');
$pdf->Ln(5);

/* =========================================================
   NUEVO SALDO
========================================================= */
$pdf->SetFont('Arial','B',12);
$pdf->Cell(130,9,pdfText('NUEVO SALDO PENDIENTE:'),1,0,'R');
$pdf->Cell(50,9,'$ '.number_format($nuevoSaldo,2),1,1,'R');
$pdf->Ln(8);

/* =========================================================
   FORMA DE PAGO
========================================================= */
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,pdfText('Forma de pago: '. $formaPago),0,1);
$pdf->Ln(8);

/* =========================================================
   AVISO
========================================================= */
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,6,pdfText(
        'Este comprobante corresponde a un abono parcial. '
        . 'La cuenta mantiene un saldo pendiente de $ '
        . number_format(
            $nuevoSaldo,2). '.'),0,'C');
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
$pdf->Output('I','comprobante_abono.pdf');