<?php
date_default_timezone_set('America/Guayaquil');

require_once __DIR__ . '/../../libs/fpdf.php';
/* =========================================================
   CONVERSIÓN DE TEXTO PARA FPDF
========================================================= */

function pdfText($texto){
    return iconv('UTF-8', 'windows-1252//TRANSLIT', $texto);
}

/* =========================================================
   DATOS DE PRUEBA

   Posteriormente estos datos vendrán de la BDD.
========================================================= */
$historiaClinica = '';
$cedula = '';
$fecha = date('d/m/Y');
$hora = date('H:i');

$apellidoPaterno = '';
$apellidoMaterno = '';
$nombres = '';
$edad = '';

$tipoAtencion = 'Ambulatoria';

$procedimiento = '';
$duracion = '';

$beneficios = '';
$riesgosFrecuentes = '';
$riesgosGraves = '';
$otrosRiesgos = '';
$alternativas = '';
$manejoPosterior = '';
$consecuencias = '';

$nombreProfesional = '';
$codigoProfesional = '';

/* =========================================================
   CLASE PDF
========================================================= */
class PDFConsentimiento extends FPDF{
    function Header(){
        /*
         * Más adelante podemos colocar aquí el logo
         * oficial de BellDente.
         */

        $this->SetFont('Arial', 'B', 15);

        $this->Cell(0,8,pdfText('CONSENTIMIENTO INFORMADO'),0,1,'C');
        $this->Ln(1);
        $this->Cell(0,9,pdfText('CENTRO ODONTOLÓGICO FAMILIAR BELLDENTE'),0,1,'C');
    }

    function Footer(){
        $this->SetY(-12);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0,5,pdfText('Página ') . $this->PageNo(),0,0,'C');
    }

    /* =====================================================
       TÍTULOS DE SECCIÓN
    ===================================================== */

    function tituloSeccion($titulo){
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(235, 235, 235);
        $this->Cell(0,7,pdfText($titulo),1,1,'L',true);
    }

    /* =====================================================
       CAMPO CON LÍNEAS PARA ESCRIBIR
    ===================================================== */
    function campoTexto($titulo, $contenido = '', $altura = 18){
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0,6,pdfText($titulo),0,1);
        $this->SetFont('Arial', '', 9);
        if (!empty($contenido)) {
            $this->MultiCell(0,5,pdfText($contenido),1,'L');
        } else {
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x,$y,190,$altura);
            $this->Ln($altura);
        }
        $this->Ln(2);
    }

    /* =====================================================
       LÍNEA PARA FIRMA
    ===================================================== */
    function firma($titulo){
        $this->Ln(7);
        $x = $this->GetX();
        $y = $this->GetY();
        $this->Line($x,$y,$x + 75,$y);
        $this->SetFont('Arial', '', 8);
        $this->Cell(75,5,pdfText($titulo),0,0,'C');
    }
}

/* =========================================================
   CREAR DOCUMENTO
========================================================= */
$pdf = new PDFConsentimiento('P','mm','A4');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

/* =========================================================
   DATOS DEL PACIENTE
========================================================= */
$pdf->SetFont('Arial', '', 9);
/* HISTORIA / CÉDULA / FECHA / HORA */
$pdf->Cell(45,6,pdfText('Historia Clínica: ') . pdfText($historiaClinica),1);
$pdf->Cell(55,6,pdfText('Cédula: ') . pdfText($cedula),1);
$pdf->Cell(55,6,pdfText('Fecha: ') . pdfText($fecha),1);
$pdf->Cell(35,6,pdfText('Hora: ') . pdfText($hora),1,1);

/* NOMBRES */
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(47.5,5,pdfText('APELLIDO PATERNO'),1,0,'C');
$pdf->Cell(47.5,5,pdfText('APELLIDO MATERNO'),1,0,'C');
$pdf->Cell(65,5,pdfText('NOMBRES'),1,0,'C');
$pdf->Cell(30,5,pdfText('EDAD'),1,1,'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(47.5,7,pdfText($apellidoPaterno),1,0,'C');
$pdf->Cell(47.5,7,pdfText($apellidoMaterno),1,0,'C');
$pdf->Cell(65,7,pdfText($nombres),1,0,'C');
$pdf->Cell(30,7,pdfText($edad),1,1,'C');

$pdf->Ln(3);

/* TIPO DE ATENCIÓN */
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,6,pdfText('TIPO DE ATENCIÓN:'),0,0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0,6,pdfText($tipoAtencion),0,1);

$pdf->Ln(2);

/* =========================================================
   PROCEDIMIENTO
========================================================= */
$pdf->campoTexto('TIPO Y NOMBRE DEL PROCEDIMIENTO RECOMENDADO',$procedimiento,20);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(55,6,pdfText('DURACIÓN DEL PROCEDIMIENTO:'),0,0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0,6,pdfText($duracion),0,1);

$pdf->Ln(2);

/* =========================================================
   BENEFICIOS
========================================================= */
$pdf->campoTexto('BENEFICIOS DEL PROCEDIMIENTO',$beneficios,18);

/* =========================================================
   RIESGOS
========================================================= */
$pdf->campoTexto('RIESGOS FRECUENTES Y POCO GRAVES',$riesgosFrecuentes,18);
$pdf->campoTexto('RIESGOS POCO FRECUENTES Y GRAVES',$riesgosGraves,18);
$pdf->campoTexto('OTROS RIESGOS',$otrosRiesgos,15);

/* =========================================================
   ALTERNATIVAS
========================================================= */
$pdf->campoTexto('ALTERNATIVAS AL PROCEDIMIENTO',$alternativas,18);

/* =========================================================
   MANEJO POSTERIOR
========================================================= */
$pdf->campoTexto('DESCRIPCIÓN DEL MANEJO POSTERIOR AL PROCEDIMIENTO',$manejoPosterior,18);

/* =========================================================
   CONSECUENCIAS
========================================================= */
$pdf->campoTexto('CONSECUENCIAS POSIBLES SI NO SE REALIZA EL PROCEDIMIENTO',$consecuencias,18);

/* =========================================================
   DECLARACIÓN
========================================================= */
$pdf->Ln(2);
$pdf->tituloSeccion('DECLARACIÓN DE CONSENTIMIENTO INFORMADO');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(95,6,pdfText('Fecha: __________________________'),0,0);
$pdf->Cell(95,6,pdfText('Hora: __________________________'),0,1);
$pdf->Ln(2);
$declaracion =
    'He facilitado la información completa que conozco sobre los antecedentes '
    . 'personales y familiares de mi estado de salud. Soy consciente de que '
    . 'omitir estos datos puede afectar los resultados del tratamiento.'
    . "\n\n"
    . 'Estoy de acuerdo con el procedimiento que se me ha propuesto; he sido '
    . 'informado de las ventajas e inconvenientes del mismo; se me ha explicado '
    . 'de forma clara en qué consiste, los beneficios y posibles riesgos del '
    . 'procedimiento. He escuchado, leído y comprendido la información recibida '
    . 'y se me ha dado la oportunidad de preguntar lo que he necesitado consultar '
    . 'sobre el procedimiento. He tomado consciente y libremente la decisión de '
    . 'autorizar el procedimiento. También conozco que puedo retirar mi '
    . 'consentimiento cuando lo estime oportuno.';

$pdf->MultiCell(0,5,pdfText($declaracion),0,'J');

/* =========================================================
   FIRMAS
========================================================= */
$pdf->Ln(8);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x,$y,$x + 80,$y);
$pdf->Line($x + 110,$y,$x + 190,$y);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(80,5,pdfText('Nombre del paciente'),0,0,'C');
$pdf->Cell(30,5,'',0);
$pdf->Cell(80,5,pdfText('Firma del paciente'),0,1,'C');
$pdf->Ln(10);
$pdf->Line($x,$pdf->GetY(),$x + 80,$pdf->GetY());
$pdf->Line($x + 110,$pdf->GetY(),$x + 190,$pdf->GetY());

$pdf->Cell(80,5,pdfText('Profesional que realiza el procedimiento'),0,0,'C');
$pdf->Cell(30,5,'',0);
$pdf->Cell(80,5,pdfText('Firma y código'),0,1,'C');

/* =========================================================
   REPRESENTANTE LEGAL
========================================================= */
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0,6,pdfText(    'Si el paciente no está en capacidad de firmar el consentimiento informado:'),0,1);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100,6,pdfText('Nombre representante legal: __________________________'),0,0);
$pdf->Cell(90,6,pdfText('Firma: __________________________'),0,1);

$pdf->Cell(100,6,pdfText('Parentesco: _________________________________________'),0,0);
$pdf->Cell(90,6,pdfText('C.I.: ___________________________'),0,1);

/* =========================================================
   NEGATIVA
========================================================= */
$pdf->Ln(5);
$pdf->tituloSeccion('NEGATIVA DEL CONSENTIMIENTO INFORMADO');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0,6,pdfText('Fecha: ______________________________'),0,1);
$negativa =
    'No autorizo y me niego a que se me realice el procedimiento propuesto, '
    . 'asumo la responsabilidad sobre mi salud y deslindo de responsabilidades '
    . 'futuras de cualquier índole al servicio de salud y al profesional '
    . 'sanitario que me atiende, por no realizar el procedimiento sugerido.';

$pdf->MultiCell(0,5,pdfText($negativa),0,'J');

/* FIRMAS NEGATIVA */
$pdf->Ln(8);
$y = $pdf->GetY();
$pdf->Line(10,$y,90,$y);
$pdf->Line(120,$y,200,$y);
$pdf->Cell(80,5,pdfText('Nombre del paciente'),0,0,'C');
$pdf->Cell(30,5,'',0);
$pdf->Cell(80,5,pdfText('Firma del paciente'),0,1,'C');
$pdf->Ln(8);
$y = $pdf->GetY();
$pdf->Line(10,$y,90,$y);
$pdf->Line(120,$y,200,$y);

$pdf->Cell(80,5,pdfText('Profesional que realiza el procedimiento'),0,0,'C');
$pdf->Cell(30,5,'',0);
$pdf->Cell(80,5,pdfText('Firma y código'),0,1,'C');

/* REPRESENTANTE */
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0,6,pdfText(    'Si el paciente no está en capacidad de firmar el consentimiento informado:'),0,'L');

$pdf->Cell(100,6,pdfText('Nombre representante legal: __________________________'),0,0);
$pdf->Cell(90,6,pdfText('Firma: __________________________'),0,1);

$pdf->Cell(100,6,pdfText('Parentesco: _________________________________________'),0,0);
$pdf->Cell(90,6,pdfText('C.I.: ___________________________'),0,1);

/* TESTIGO */
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(0,5,pdfText(    'Si el paciente no acepta el procedimiento sugerido por el profesional '    . 'y se niega a firmar este acápite:'),0,'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(95,6,pdfText('Firma de testigo: __________________________'),0,0);
$pdf->Cell(95,6,pdfText('Nombre de testigo: _________________________'),0,1);
$pdf->Cell(0,6,pdfText('C.I.: ______________________________________'),0,1);

/* =========================================================
   REVOCATORIA
========================================================= */
$pdf->Ln(5);
$pdf->tituloSeccion('REVOCATORIA DE CONSENTIMIENTO INFORMADO');
$pdf->SetFont('Arial', '', 9);
$revocatoria =
    'Revoco el consentimiento informado realizado en fecha '
    . '____________________________ y no deseo proseguir el tratamiento '
    . 'que doy por finalizado en esta fecha ____________________________. '
    . 'Asumo la responsabilidad sobre mi salud y deslindo de '
    . 'responsabilidades futuras de cualquier índole al servicio de salud '
    . 'y al profesional sanitario que me atiende.';

$pdf->MultiCell(0,5,pdfText($revocatoria),0,'J');

/* FIRMA REVOCATORIA */
$pdf->Ln(8);
$y = $pdf->GetY();
$pdf->Line(10,$y,90,$y);
$pdf->Line(120,$y,200,$y);

$pdf->Cell(80,5,pdfText('Nombre del paciente'),0,0,'C');
$pdf->Cell(30,5,'',0);
$pdf->Cell(80,5,pdfText('Firma del paciente'),0,1,'C');

/* REPRESENTANTE REVOCATORIA */
$pdf->Ln(6);
$pdf->MultiCell(0,5,pdfText(    'Si el paciente no está en capacidad de firmar el consentimiento informado:'),0,'L');
$pdf->Cell(100,6,pdfText('Nombre representante legal: __________________________'),0,0);
$pdf->Cell(90,6,pdfText('Firma: __________________________'),0,1);
$pdf->Cell(100,6,pdfText('Parentesco: _________________________________________'),0,0);

$pdf->Cell(90,6,pdfText('C.I.: ___________________________'),0,1);

/* =========================================================
   SALIDA
========================================================= */
$pdf->Output('I','consentimiento_informado.pdf');