<?php
session_start();
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

// CREAR ATENCIÓN
    case "crear":
    if (!isset($_SESSION["id_usuario"])) {
        echo json_encode(["status" => false,"message" => "Sesión no válida"]);
        exit;
    }
    $id_cita = isset($_POST["id_cita"])? (int) $_POST["id_cita"]: 0;
    if ($id_cita <= 0) {
        echo json_encode(["status" => false,"message" => "Cita no válida"]);
        exit;
    }
    $id_usuario = (int) $_SESSION["id_usuario"];
    $rspta = $atencion->crear($id_cita,$id_usuario);
    if ($rspta) {
        echo json_encode([
            "status" => true,
            "id_atencion" => $rspta["id_atencion"],
            "resultado" => $rspta["resultado"]
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "No se pudo crear la atención"
        ]);
    }
    break;

// FINALIZAR ATENCIÓN
    case "finalizar":
        // Validar que haya una sesión activa
        if(!isset($_SESSION["id_usuario"])) {
            echo json_encode(["status" => false,"message" => "Sesión no válida"]);
            exit;
        }

    // Recibimos el JSON que enviamos desde atencion.js
        $datosJSON = $_POST["datos"] ?? "";
        //Validamos si es que llega o no los datos
        if($datosJSON === "") {
            echo json_encode(["status" => false,"message" => "No se recibieron los datos de la atención"]);
            exit;
        }

    // Convertimos el JSON para obtener IDs
        $datos = json_decode($datosJSON,true);

    // Verificamos nuestro JSON para enviar
        if(json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["status" => false,"message" => "JSON de atención no válido"]);
            exit;
        }

    // Obtenemos IDs
        $id_atencion =intval($datos["id_atencion"] ?? 0);
        $id_cita =intval($datos["id_cita"] ?? 0);
        $id_usuario =intval($_SESSION["id_usuario"]);

    // Validamos atención
        if($id_atencion <= 0) {
            echo json_encode(["status" => false,"message" => "Atención no válida"]);
            exit;
        }

    // Validar cita
        if($id_cita <= 0) {
            echo json_encode(["status" => false,"message" => "Cita no válida"]);
            exit;
        }

    // Enviamos todo el JSON al modelo
        $rspta = $atencion->finalizar($id_atencion,$id_cita,$id_usuario,$datosJSON);
        if ($rspta) {
            echo json_encode(["status" => true,"id_atencion" =>$rspta["id_atencion"],"resultado" =>$rspta["resultado"]]);
        } else {
            echo json_encode(["status" => false,"message" =>"No se pudo finalizar la atención"
            ]);
        }
    break;
} 