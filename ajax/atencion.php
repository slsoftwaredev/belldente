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

    //GUARDAMOS LAS FOTOGRAFÍAS DE MANERA FÍSICA
        $fotografiasGuardadas=[];
        //Observaciones que vienen del JSON
        $fotografiasMetadata = $datos["fotografias"]??[];
        //Temporal para ver errores
            error_log("FILES RECIBIDOS:");
            error_log(print_r($_FILES, true));
        if(isset($_FILES["fotografias"]) && isset($_FILES["fotografias"]["name"]) && is_array($_FILES["fotografias"]["name"])){
            //Carpeta física
            $directorio = "../uploads/fotografias/";
            //Creamos la carpeta si no existe
            if(!is_dir($directorio)){
                if(!mkdir($directorio,0775,true)){
                    echo json_encode(["status"=>false,"message"=>"No se pudo crear la carpeta fotografías"]);
                    exit;
                }
            }
            $totalArchivos = count($_FILES["fotografias"]["name"]);
            for($i = 0; $i < $totalArchivos; $i++){
                $nombreOriginal = $_FILES["fotografias"]["name"][$i];
                $tmp = $_FILES["fotografias"]["tmp_name"][$i];
                $error = $_FILES["fotografias"]["error"][$i];
                //Temporal para ver errores
                error_log("ARCHIVO: " . $nombreOriginal);
                error_log("TMP: " . $tmp);
                error_log("ERROR UPLOAD: " . $error);
                if ($error !== UPLOAD_ERR_OK) {
                    continue;
                }
                //Validamos la extensión del archivo
                $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
                $extensionesPermitidas = ["jpg","jpeg","png","webp"];
                if (!in_array($extension,$extensionesPermitidas)) {
                    continue;
                }
                //Creamos un nombre único al archivo
                $nombreNuevo = "atencion_" . $id_atencion . "_". uniqid(). ".". $extension;
                $rutaFisica = $directorio . $nombreNuevo;
                //Ruta que guardaremos en la BDD
                $rutaBDD = "uploads/fotografias/".$nombreNuevo;
                //Movemos el archivo al directorio
                if (move_uploaded_file($tmp,$rutaFisica)) {
                    //Temporal
                    error_log("FOTO MOVIDA CORRECTAMENTE: " . $rutaFisica);
                    $observacion = "";
                    if (isset($fotografiasMetadata[$i]["observacion"])) {
                        $observacion = trim($fotografiasMetadata[$i]["observacion"]);
                    }
                    $fotografiasGuardadas[] = [
                        "nombre_archivo" => $nombreOriginal,
                        "ruta_archivo" => $rutaBDD,
                        "observacion" => $observacion
                    ];
                    //else temporal
                }else{
                    error_log("ERROR AL MOVER FOTO: " . $rutaFisica);
                }
            }
        }
        // REEMPLAZAMOS FOTOGRAFIAS DEL JSON
        $datos["fotografias"] = $fotografiasGuardadas;
        //Convertimos nuevamente todo a JSON
        $datosJSON = json_encode($datos,JSON_UNESCAPED_UNICODE);

    // Enviamos todo el JSON al modelo SP
        $rspta = $atencion->finalizar($id_atencion,$id_cita,$id_usuario,$datosJSON);
        if ($rspta) {
            echo json_encode(["status" => true,"id_atencion" =>$rspta["id_atencion"],"resultado" =>$rspta["resultado"], "fotografias" => $fotografiasGuardadas, "files_recibidos"=>$_FILES]);
        } else {
            echo json_encode(["status" => false,"message" =>"No se pudo finalizar la atención"
            ]);
        }
    break;


//OBTENER DATOS PARA CONSENTIMIENTO INFORMADO
    case "obtener_consentimiento":
        // Validamos que exista una sesión activa
        if (!isset($_SESSION["id_usuario"])) {
            echo json_encode(["status" => false,"message" => "Sesión no válida"]);
            exit;
        }
        // Recibimos el ID de la atención
        $id_atencion = isset($_POST["id_atencion"]) ? intval($_POST["id_atencion"]) : 0;
        // Validamos el ID
        if ($id_atencion <= 0) {
            echo json_encode(["status" => false, "message" => "Atención no válida"]);
            exit;
        }
        // Consultamos los datos
        $rspta = $atencion->obtenerConsentimiento($id_atencion);

        // Verificamos que exista la atención
        if ($rspta) {
            echo json_encode(["status" => true,"datos" => $rspta]);
        } else {
            echo json_encode(["status" => false,"message" => "No se encontraron datos para el consentimiento"]);
        }
    break;

//Listar historias clínicas
    case 'listar_historias':
    $rspta = $atencion->listarHistorias();
    $data = [];
    while ($reg = $rspta->fetch_object()) {
        $data[] = [
            "id_paciente"      => $reg->id_paciente,
            "cedula"           => $reg->cedula_paciente,
            "nombre"           => $reg->nombre_paciente,
            "apellido"         => $reg->apellido_paciente,
            "total_atenciones" => $reg->total_atenciones,
            "ultima_atencion"  => $reg->ultima_atencion
        ];
    }
    echo json_encode([
        "status" => true,
        "data"   => $data
    ]);
    break;

// Listar atenciones finalizadas de un paciente
case 'listar_atenciones_paciente':
    $id_paciente = isset($_POST["id_paciente"]) ? intval($_POST["id_paciente"]) : 0;
    if ($id_paciente <= 0) {
        echo json_encode([
            "status" => false,
            "message" => "ID de paciente no válido"
        ]);
        break;
    }
    $rspta = $atencion->listarAtencionesPaciente($id_paciente);
    $data = [];
    while ($reg = $rspta->fetch_object()) {
        $data[] = [
            "id_atencion" => $reg->id_atencion,
            "id_cita" => $reg->id_cita,

            "id_paciente" => $reg->id_paciente,
            "cedula" => $reg->cedula_paciente,
            "nombre" => $reg->nombre_paciente,
            "apellido" => $reg->apellido_paciente,

            "fecha_nacimiento" => $reg->fecha_nacimiento,
            "edad_atencion" => $reg->edad_atencion,
            "sexo" => $reg->sexo_paciente,
            "telefono" => $reg->telefono_paciente,
            "correo" => $reg->correo_paciente,
            "direccion" => $reg->direccion_paciente,

            "fecha_inicio" => $reg->fecha_inicio,
            "fecha_fin" => $reg->fecha_fin,

            "nombre_profesional" => $reg->nombre_profesional,
            "apellido_profesional" => $reg->apellido_profesional,
            "rol_profesional" => $reg->nombre_rol
        ];
    }
    echo json_encode([
        "status" => true,
        "data" => $data
    ]);
    break;

// Obtenemos la historia completa
    case 'obtener_historia_completa':
    $id_atencion = isset($_POST["id_atencion"]) ? intval($_POST["id_atencion"]) : 0;
    if ($id_atencion <= 0) {
        echo json_encode([
            "status" => false,
            "message" => "ID de atención no válido"
        ]);
        break;
    }
    try {
        $historia = $atencion->obtenerHistoriaCompleta($id_atencion);
        if (empty($historia["cabecera"])) {
            echo json_encode([
                "status" => false,
                "message" => "No se encontró la atención finalizada"
            ]);
            break;
        }
        echo json_encode([
            "status" => true,
            "data" => $historia
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "status" => false,
            "message" => $e->getMessage()
        ]);
    }
    break;
} 