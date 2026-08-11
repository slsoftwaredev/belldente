<?php
require_once "../model/Atencion.php";

$atencion = new Atencion();

switch ($_GET["op"]) {
// Obtener la información de una cita específica
    case "obtener_cita":

        $rspta = $atencion->obtenerCita($_POST["id_cita"]);

        echo json_encode($rspta);

    break;
//Listamos los antecedentes
case "listar_antecedentes":
    $rspta = $atencion->listarAntecedentes();
    $data = [];
    while($reg = $rspta->fetch_object()){
        $data[] = $reg;
    }
    echo json_encode($data);
    break;
//Listamos el examen estomatognático
    case "listar_estomatognatico":
    $rspta = $atencion->listarEstomatognatico();
    $data = [];
    while($reg = $rspta->fetch_object()){
        $data[] = $reg;
    }
    echo json_encode($data);    
    break;
//Listamos los indicadores de salud bucal
    case "listar_indicadores":
        $rspta = $atencion->listarIndicadores();
        $data = [];
        while($reg = $rspta->fetch_object()){
            $data[] = $reg;
        }
        echo json_encode($data);
    break;
//Combo CIE-10 - Procedimientos o protocolos de atención
    case 'combo_cie10':
        $rspta = $atencion->comboCIE10();
        $data = array();
        while($reg = $rspta->fetch_object()){
            $data[] = $reg;
        }
        echo json_encode($data);

    break;

    case 'combo_tratamientos':
        $rspta = $atencion->comboTratamientos();
        $data = array();
        while($reg = $rspta->fetch_object()){
            $data[] = $reg;
        }
        echo json_encode($data);

    break;

    /* ========================================
       SIMBOLOGÍAS
    ======================================== */
    case "simbologias":

        $rspta = $atencion->listarSimbologias();

        $data = [];

        while ($reg = $rspta->fetch_object()) {

            $data[] = [
                "id_simbologia"     => $reg->id_simbologia,
                "nombre_simbologia" => $reg->nombre_simbologia,
                "color"             => $reg->color,
                "simbolo"           => $reg->simbolo
            ];

        }

        echo json_encode($data);

    break;


    /* ========================================
       PIEZAS
    ======================================== */
    case "piezas":

        $tipo_denticion = $_GET["tipo_denticion"] ?? 1;

        $rspta = $atencion->listarPiezas($tipo_denticion);

        $data = [];

        while ($reg = $rspta->fetch_object()) {

            $data[] = [
                "id_pieza"          => $reg->id_pieza,
                "numero_pieza"      => $reg->numero_pieza,
                "tipo_denticion_id" => $reg->tipo_denticion_id
            ];

        }

        echo json_encode($data);

    break;
} 