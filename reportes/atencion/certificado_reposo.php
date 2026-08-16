<?php
require_once __DIR__ . '/../../libs/fpdf.php';
/* =========================================================
   TEXTO PARA FPDF
========================================================= */
function pdfText($texto){
    return iconv('UTF-8','windows-1252//TRANSLIT',$texto);
}

/* =========================================================
   DATOS DE PRUEBA
   Después vendrán desde la BDD.
========================================================= */
// ODONTÓLOGO
$nombreOdontologo = 'Ñahui Yuyari Lema Maldonado';
$sexoOdontologo = 'F';
$registroProfesional = '1016-2022-2538684';
$cedulaOdontologo = '1002675732';

// PACIENTE
$nombrePaciente = 'MARIA FANNY BONILLA LECHÓN';
$sexoPaciente = 'F';
$cedulaPaciente = '1714820063';
$ciudadResidencia = 'Otavalo';
$direccionPaciente = 'Ciudadela Yanayacu primera etapa';
$telefonoPaciente = '0994823981';
$ocupacion = 'Docente de primaria';
$lugarTrabajo = 'Unidad Educativa del Milenio "Jatun Kuraka"';
$historiaClinica = '1714820063';

// ATENCIÓN
$fechaAtencionTexto ='28 (veintiocho) de Mayo del 2025 (dos mil veinticinco)';
$codigoCIE10 = 'K081';
$diagnostico ='PÉRDIDA DE DIENTES DEBIDO A ACCIDENTE O ENFERMEDAD PERIODONTAL LOCAL';
$procedimiento ='SE REALIZÓ LA EXODONCIA DEL Od. #17';

// REPOSO
$presentaSintomas = true;
$enfermedad ='Pulpitis Irreversible';
$aislamiento = false;
$diasReposo = 3;
$diasReposoTexto = 'tres';
$fechaDesde ='miércoles 28 (veintiocho) de Mayo del 2025 (dos mil veinticinco)';
$fechaHasta ='viernes 30 (treinta) de Mayo del 2025 (dos mil veinticinco)';

// EMISIÓN
$fechaEmision ='28 de Mayo del 2025';
$tipoContingencia ='ENFERMEDAD GENERAL';

/* =========================================================
   RECURSOS
========================================================= */
$logo = __DIR__. '/../../public/assets/img/documentos/Logo_certificado.jpg';
$marcaAgua = __DIR__. '/../../public/assets/img/documentos/marca_agua_belldente.jpg';

/* =========================================================
   PDF
========================================================= */
class PDFCertificado extends FPDF{
    public $logo;
    public $marcaAgua;

    /* =====================================================
       HEADER
    ===================================================== */
    function Header(){
        /*
         * LOGO
         */
        if ($this->logo &&file_exists($this->logo)) {
            $this->Image($this->logo,65,7,80);
        }

        /*
         * TÍTULO
         */
        $this->SetY(38);
        $this->SetFont('Arial','B',17);
        $this->Cell(0,8,pdfText('CERTIFICADO DE REPOSO'),0,1,'C');

        /*
         * MARCA DE AGUA
         */
        if ($this->marcaAgua &&file_exists($this->marcaAgua)) {
            $this->Image($this->marcaAgua,55,70,100);
        }
    }

    /* =====================================================
       FOOTER
    ===================================================== */
    function Footer(){
        /*
         * FRANJA NEGRA
         */
        $this->SetFillColor(0,0,0);
        $this->Rect(0,277,210,20,'F');
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial','',8);

        /*
         * TELÉFONOS
         */
        $this->SetXY(20,281);
        $this->MultiCell(45,4,pdfText("0939836297\n0980822876"),0,'C');

        /*
         * CORREOS
         */
        $this->SetXY(72,281);
        $this->MultiCell(60,4,pdfText("nahui.lema@hotmail.com\n"."dtr.lema@hotmail.it"),0,'C');

        /*
         * DIRECCIONES
         */
        $this->SetXY(137,281);
        $this->MultiCell(65,4,pdfText("Calle Sucre y Quiroga - Otavalo\n"."Plaza de los Ponchos"),0,'C');

        /*
         * RESTAURAR COLOR
         */
        $this->SetTextColor(0,0,0);
    }
}

/* =========================================================
   INSTANCIAR PDF
========================================================= */
$pdf = new PDFCertificado('P','mm','A4');
$pdf->logo = $logo;
$pdf->marcaAgua = $marcaAgua;
$pdf->SetMargins(12,12,12);
$pdf->SetAutoPageBreak(true,25);
$pdf->AddPage();

/* =========================================================
   POSICIÓN INICIAL
========================================================= */
$pdf->SetY(58);
$pdf->SetFont('Arial','',10);

/* =========================================================
   ODONTÓLOGO
========================================================= */
$tratamientoOdontologo =$sexoOdontologo === 'F'? 'Dra.': 'Dr.';
$profesion = $sexoOdontologo === 'F'? 'Odontóloga': 'Odontólogo';
$textoOdontologo ='Yo, '. $tratamientoOdontologo. ' '. $nombreOdontologo. ', '. $profesion. ' con registro profesional Nº'. $registroProfesional. ', certifico que:';
$pdf->MultiCell(0,5,pdfText($textoOdontologo),0,'J');
$pdf->Ln(5);

/* =========================================================
   DATOS DEL PACIENTE
========================================================= */
$articuloPaciente =$sexoPaciente === 'F'? 'La paciente': 'El paciente';
$textoPaciente =$articuloPaciente. ' '. $nombrePaciente. ' con CI: '. $cedulaPaciente. ' residente en '. $ciudadResidencia. '; '. $direccionPaciente. ', con número de celular '. $telefonoPaciente. '.';
$pdf->MultiCell(0,5,pdfText($textoPaciente),0,'J');

/* =========================================================
   OCUPACIÓN
========================================================= */
$textoTrabajo ='Actualmente ocupando el puesto de trabajo de '. $ocupacion. ' en '. $lugarTrabajo. '.';
$pdf->MultiCell(0,5,pdfText($textoTrabajo),0,'J');

/* HISTORIA CLÍNICA */
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,pdfText('Nº H. Clínica: '.$historiaClinica),0,1);
$pdf->Ln(5);

/* =========================================================
   ATENCIÓN
========================================================= */
$pdf->SetFont('Arial','',10);
$textoAtencion ='Ha recibido atención odontológica en esta consulta el día '. $fechaAtencionTexto. ', durante el cual se diagnosticó:';
$pdf->MultiCell(0,5,pdfText($textoAtencion),0,'J');$pdf->Ln(3);

/* =========================================================
   DIAGNÓSTICO
========================================================= */
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(0,5,pdfText($codigoCIE10. ' ('. $diagnostico. ')'),0,'L');
$pdf->Ln(4);

/* =========================================================
   PROCEDIMIENTO
========================================================= */
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(0,5,pdfText($procedimiento),0,'L');
$pdf->Ln(8);

/* =========================================================
   SÍNTOMAS
========================================================= */
$pdf->SetFont('Arial','',10);
$textoSintomas ='Presenta Síntomas: '. ($presentaSintomas? 'X Sí      No': 'Sí      X No');
$pdf->Cell(0,5,pdfText($textoSintomas),0,1);

/* =========================================================
   ENFERMEDAD
========================================================= */
$pdf->Cell(0,5,pdfText('Enfermedad: '. $enfermedad),0,1);

/* =========================================================
   AISLAMIENTO
========================================================= */
$pdf->Cell(0,5,pdfText('Aislamiento: '. ($aislamiento? 'Sí': 'No')),0,1);
$pdf->Ln(7);

/* =========================================================
   REPOSO
========================================================= */
$pdf->SetFont('Arial','B',10);
$textoReposo ='PACIENTE REQUIERE REPOSO MÉDICO DE '. $diasReposo. ' ('. $diasReposoTexto. ') DÍAS';
$pdf->MultiCell(0,5,pdfText($textoReposo),0,'L');
$pdf->Ln(5);

/* =========================================================
   DESDE / HASTA
========================================================= */
$pdf->SetFont('Arial','',10);
$textoFechas ='DESDE: '. $fechaDesde. ' HASTA: '. $fechaHasta;
$pdf->MultiCell(0,5,pdfText($textoFechas),0,'J');
$pdf->Ln(9);

/* =========================================================
   FECHA DE EMISIÓN
========================================================= */
$pdf->Cell(0,5,pdfText('Otavalo, '. $fechaEmision),0,1);

/* =========================================================
   FIRMA
========================================================= */
$pdf->Ln(18);
/*
 * Línea de firma
 */
$centro = 105;
$pdf->Line($centro - 28,$pdf->GetY(),$centro + 28,$pdf->GetY());
$pdf->Ln(2);

/*
 * Nombre
 */
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,4,pdfText($nombreOdontologo),0,1,'C');

/*
 * Profesión
 */
$pdf->Cell(0,4,pdfText($profesion),0,1,'C');

/*
 * Cédula
 */
$pdf->Cell(0,4,pdfText('CI: '. $cedulaOdontologo),0,1,'C');

/* =========================================================
   CONTINGENCIA
========================================================= */
$pdf->SetY(255);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,4,pdfText('Tipo de contingencia:'),0,1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,4,pdfText($tipoContingencia),0,1);

/* =========================================================
   GENERAR
========================================================= */
$pdf->Output('I','certificado_reposo.pdf');