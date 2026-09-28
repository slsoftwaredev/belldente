<?php

require_once "../model/Cita.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$cita = new Cita();

$op = $_GET["op"] ?? "";

switch ($op) {

    /* =====================================================
       LISTAR CITAS
    ===================================================== */
    case "listar":

        $rspta = $cita->listar();

        $data = [];

        while ($reg = $rspta->fetch_assoc()) {

            switch ((int)$reg["id_estado_cita"]) {
                case 1:
                    $colorEstado = "bg-blue-100 text-blue-700";
                    break;

                case 2:
                    $colorEstado = "bg-yellow-100 text-yellow-700";
                    break;

                case 3:
                    $colorEstado = "bg-purple-100 text-purple-700";
                    break;

                case 4:
                    $colorEstado = "bg-green-100 text-green-700";
                    break;

                case 5:
                    $colorEstado = "bg-gray-100 text-gray-700";
                    break;

                case 6:
                    $colorEstado = "bg-red-100 text-red-700";
                    break;

                default:
                    $colorEstado = "bg-gray-100 text-gray-700";
                    break;
            }

            if (!empty($reg["hora_cita"])) {

    $hora = '
        <span class="font-medium text-slate-700">
            '.date("H:i", strtotime($reg["hora_cita"])).'
        </span>
    ';

} elseif (
    (int)$reg["id_estado_cita"] === 1 ||
    (int)$reg["id_estado_cita"] === 2
) {

    $hora = '
        <button
            onclick="confirmarHoraCita('.$reg["id_cita"].')"
            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg">
            Confirmar hora
        </button>
    ';

} else {

    $hora = '
        <span class="text-slate-500">
            Pendiente
        </span>
    ';
}

            $dentista = !empty($reg["dentista"])
                ? $reg["dentista"]
                : "Sin asignar";

            $motivo = !empty($reg["motivo_cita"])
                ? $reg["motivo_cita"]
                : "Sin motivo";

            $estado = '
                <span class="px-2 py-1 rounded-full text-xs font-semibold '.$colorEstado.'">
                    '.$reg["nombre_estado"].'
                </span>
            ';

            $acciones = '';

if (
    (int)$reg["id_estado_cita"] === 1 ||
    (int)$reg["id_estado_cita"] === 2
) {

    $acciones = '
        <div class="flex gap-2 justify-center">

            <button
                onclick="editarCita('.$reg["id_cita"].')"
                class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded-lg">
                Reagendar
            </button>

            <button
                onclick="atenderCita('.$reg["id_cita"].')"
                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg">
                Atender
            </button>

            <button
                onclick="cancelarCita('.$reg["id_cita"].')"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">
                Cancelar
            </button>

        </div>
    ';
}

            $data[] = [
                "id_cita"       => $reg["id_cita"],
                "paciente"      => $reg["paciente"],
                "dentista"      => $dentista,
                "fecha_cita"    => $reg["fecha_cita"],
                "hora_cita"     => $hora,
                "motivo_cita"   => $motivo,
                "estado"        => $estado,
                "estado_id"     => $reg["id_estado_cita"],
                "acciones"      => $acciones
            ];
        }

        echo json_encode([
            "status" => true,
            "data"   => $data
        ]);

        break;


    /* =====================================================
       GUARDAR CITA
    ===================================================== */
    case "guardar":

        $paciente_id = $_POST["paciente_id"] ?? 0;
        $dentista_id = $_POST["dentista_id"] ?? 0;
        $fecha_cita  = $_POST["fecha_cita"] ?? "";
        $motivo_cita = trim($_POST["motivo_cita"] ?? "");

        if (
            empty($paciente_id) ||
            empty($dentista_id) ||
            empty($fecha_cita) ||
            empty($motivo_cita)
        ) {
            echo json_encode([
                "status"  => false,
                "message" => "Complete todos los datos de la cita."
            ]);
            break;
        }

        $rspta = $cita->guardar(
            $paciente_id,
            $dentista_id,
            $fecha_cita,
            $motivo_cita
        );

        echo json_encode([
            "status"  => (bool)$rspta,
            "message" => $rspta
                ? "Cita registrada correctamente."
                : "No se pudo registrar la cita."
        ]);

        break;


    /* =====================================================
       OBTENER CITA
    ===================================================== */
    case "obtener":

        $id_cita = $_POST["id_cita"] ?? 0;

        $rspta = $cita->obtener($id_cita);

        if ($rspta) {

            echo json_encode([
                "status" => true,

                "data" => [
                    "id_cita"       => $rspta[0],
                    "paciente_id"   => $rspta[1],
                    "dentista_id"   => $rspta[2],
                    "fecha_cita"    => $rspta[3],
                    "hora_cita"     => $rspta[4],
                    "motivo_cita"   => $rspta[5],
                    "estado_cita"   => $rspta[6]
                ]
            ]);

        } else {

            echo json_encode([
                "status"  => false,
                "message" => "No se encontró la cita."
            ]);
        }

        break;


    /* =====================================================
       REAGENDAR
    ===================================================== */
    case "editar":

        $id_cita      = $_POST["id_cita"] ?? 0;
        $paciente_id  = $_POST["paciente_id"] ?? 0;
        $dentista_id  = $_POST["dentista_id"] ?? 0;
        $fecha_cita   = $_POST["fecha_cita"] ?? "";
        $motivo_cita  = trim($_POST["motivo_cita"] ?? "");

        if (
            empty($id_cita) ||
            empty($paciente_id) ||
            empty($dentista_id) ||
            empty($fecha_cita) ||
            empty($motivo_cita)
        ) {
            echo json_encode([
                "status"  => false,
                "message" => "Complete todos los datos de la cita."
            ]);
            break;
        }

        $rspta = $cita->editar(
            $id_cita,
            $paciente_id,
            $dentista_id,
            $fecha_cita,
            $motivo_cita
        );

        echo json_encode([
            "status"  => (bool)$rspta,
            "message" => $rspta
                ? "Cita reagendada correctamente."
                : "No se pudo reagendar la cita."
        ]);

        break;


    /* =====================================================
       CAMBIAR ESTADO
    ===================================================== */
    case "estado":

        $id_cita = $_POST["id_cita"] ?? 0;
        $estado  = $_POST["estado"] ?? 0;

        $rspta = $cita->cambiarEstado(
            $id_cita,
            $estado
        );

        echo json_encode([
            "status" => (bool)$rspta
        ]);

        break;


    /* =====================================================
       LISTAR DENTISTAS
    ===================================================== */
    case "dentistas":

        $rspta = $cita->listarDentistas();

        $data = [];

        while ($reg = $rspta->fetch_assoc()) {

            $data[] = [
                "id_usuario" => $reg["id_usuario"],
                "dentista"   => $reg["dentista"]
            ];
        }

        echo json_encode([
            "status" => true,
            "data"   => $data
        ]);

        break;


    /* =====================================================
       OBTENER HORARIO
    ===================================================== */
    case "horario":

        $fecha_cita = $_POST["fecha_cita"] ?? "";

        if (empty($fecha_cita)) {
            echo json_encode([
                "status"  => false,
                "message" => "Seleccione una fecha."
            ]);
            break;
        }

        $rspta = $cita->obtenerHorario($fecha_cita);

        $data = [];

        while ($reg = $rspta->fetch_assoc()) {

            $data[] = [
                "id_horario"        => $reg["id_horario"],
                "tipo_dia"          => $reg["tipo_dia"],
                "hora_inicio"       => $reg["hora_inicio"],
                "hora_fin"          => $reg["hora_fin"],
                "intervalo_minutos" => $reg["intervalo_minutos"]
            ];
        }

        echo json_encode([
            "status" => true,
            "data"   => $data
        ]);

        break;


    /* =====================================================
       HORAS OCUPADAS
    ===================================================== */
    case "horas_ocupadas":

        $id_cita     = $_POST["id_cita"] ?? 0;
        $dentista_id = $_POST["dentista_id"] ?? 0;
        $fecha_cita  = $_POST["fecha_cita"] ?? "";

        $rspta = $cita->horasOcupadas(
            $id_cita,
            $dentista_id,
            $fecha_cita
        );

        $horas = [];

        while ($reg = $rspta->fetch_assoc()) {
            $horas[] = substr($reg["hora_cita"], 0, 5);
        }

        echo json_encode([
            "status" => true,
            "data"   => $horas
        ]);

        break;


    /* =====================================================
       CONFIRMAR HORA
    ===================================================== */
    case "confirmar_hora":

        $id_cita     = $_POST["id_cita"] ?? 0;
        $dentista_id = $_POST["dentista_id"] ?? 0;
        $fecha_cita  = $_POST["fecha_cita"] ?? "";
        $hora_cita   = $_POST["hora_cita"] ?? "";

        if (
            empty($id_cita) ||
            empty($dentista_id) ||
            empty($fecha_cita) ||
            empty($hora_cita)
        ) {
            echo json_encode([
                "status"  => false,
                "message" => "Seleccione una hora."
            ]);
            break;
        }

        try {

            $rspta = $cita->confirmarHora(
                $id_cita,
                $dentista_id,
                $fecha_cita,
                $hora_cita
            );

            echo json_encode([
                "status"  => (bool)$rspta,
                "message" => $rspta
                    ? "Hora confirmada correctamente."
                    : "No se pudo confirmar la hora."
            ]);

        } catch (Throwable $e) {

            echo json_encode([
                "status"  => false,
                "message" => $e->getMessage()
            ]);
        }

        break;


    /* =====================================================
       CITAS DE HOY
    ===================================================== */
    case "citas_hoy":

        $rspta = $cita->citasHoy();

        $data = [];

        while ($reg = $rspta->fetch_assoc()) {
            $data[] = [
            "id_cita" => $reg["id_cita"],
            "paciente" => $reg["paciente"],
            "fecha_cita" => $reg["fecha_cita"],
            "hora_cita" => $reg["hora_cita"],
            "estado_cita" => $reg["estado_cita"]
            ];
        }

        echo json_encode([
            "status" => true,
            "total"  => count($data),
            "data"   => $data
        ]);

        break;


    /* =====================================================
       CITAS ATRASADAS
    ===================================================== */
    case "citas_atrasadas":

        $rspta = $cita->citasAtrasadas();

        echo json_encode([
            "status" => true,
            "total"  => $rspta->num_rows
        ]);

        break;


    /* =====================================================
       PENDIENTES HOY
    ===================================================== */
    case "pendientes_hoy":

        $rspta = $cita->pendientesHoy();

        echo json_encode([
            "status" => true,
            "total"  => $rspta->num_rows
        ]);

        break;


    default:

        echo json_encode([
            "status"  => false,
            "message" => "Operación no válida."
        ]);

        break;
}