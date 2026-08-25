<?php
require_once "../model/cita.php";

$cita = new Cita();

switch ($_GET["op"]) {

    case "listar":

        $rspta = $cita->listar();

        $data = [];

        while ($reg = $rspta->fetch_object()) {
            switch($reg->id_estado_cita){
                case 1:
                    $estado = '<span class="text-green-600 font-medium">'.$reg->nombre_estado.'</span>';
                    break;
                case 2:
                    $estado = '<span class="text-amber-600 font-medium">'.$reg->nombre_estado.'</span>';
                    break;
                case 3:
                    $estado = '<span class="text-blue-600 font-medium">'.$reg->nombre_estado.'</span>';
                    break;
                case 4:
                    $estado = '<span class="text-purple-600 font-medium">'.$reg->nombre_estado.'</span>';
                    break;
                case 5:
                    $estado = '<span class="text-red-600 font-medium">'.$reg->nombre_estado.'</span>';
                    break;
                case 6:
                    $estado = '<span class="text-slate-600 font-medium">'.$reg->nombre_estado.'</span>';
                    break;
                default:
                    $estado = '<span class="text-slate-500 font-medium">'.$reg->nombre_estado.'</span>';
            }
            $data[] = [
                "0" => $reg->id_cita,
                "1" => $reg->paciente,
                "2" => $reg->fecha_cita,
                "3" => $estado,
                "4" => '

                <div class="flex gap-2 justify-center">

                    <button
                        onclick="editarCita('.$reg->id_cita.')"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded-lg">

                        Reagendar

                    </button>

                    <button
                        onclick="atenderCita('.$reg->id_cita.')"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg">

                        Atender

                    </button>

                </div>

            '
            ];
        }

        echo json_encode($data);

        break;

    case "guardar":
        $paciente_id = limpiarCadena($_POST["paciente_id"]);
        $fecha_cita = limpiarCadena($_POST["fecha_cita"]);
        $rspta = $cita->guardar(
            $paciente_id,
            $fecha_cita
        );

        echo json_encode([
            "status" => $rspta ? true : false
        ]);

        break;

    case "obtener":

        $rspta = $cita->obtener(
            $_POST["id_cita"]
        );

        echo json_encode($rspta);
        break;

    case "editar":

        $id_cita = limpiarCadena($_POST["id_cita"]);
        $paciente_id = limpiarCadena($_POST["paciente_id"]);
        $fecha_cita = limpiarCadena($_POST["fecha_cita"]);
        $estado_cita = limpiarCadena($_POST["estado_cita"]);

        $rspta = $cita->editar(
            $id_cita,
            $paciente_id,
            $fecha_cita,
            $estado_cita
        );

        echo json_encode([
            "status" => $rspta ? true : false
        ]);

        break;

    case "estado":
        $id_cita = limpiarCadena($_POST["id_cita"]);
        $estado = limpiarCadena($_POST["estado"]);

        $rspta = $cita->estado(
            $id_cita,
            $estado
        );

        echo json_encode([
            "status" => $rspta ? true : false
        ]);

        break;

    case "citas_hoy":

    $rspta = $cita->citasHoy();

    $data = [];

    while ($reg = $rspta->fetch_object()) {

        switch ($reg->estado_cita) {

            case 1:
                $estado = "Agendada";
                break;

            case 2:
                $estado = "Reagendada";
                break;

            case 3:
                $estado = "En atención";
                break;

            case 4:
                $estado = "Atendida";
                break;

            case 5:
                $estado = "No asistió";
                break;

            case 6:
                $estado = "Cancelada";
                break;

            default:
                $estado = "Desconocido";
        }

        $data[] = [
            "id_cita" => $reg->id_cita,
            "paciente" => $reg->paciente,
            "fecha" => $reg->fecha_cita,
            "estado_id" => $reg->estado_cita,
            "estado" => $estado
        ];
    }

    echo json_encode([
        "total" => count($data),
        "citas" => $data
    ]);

    break;

    case "citas_atrasadas":

    $rspta = $cita->citasAtrasadas();

    echo json_encode([
        "total" => $rspta->num_rows
    ]);

    break;
    case "pendientes_hoy":
    $rspta = $cita->pendientesHoy();
    echo json_encode([
        "total" => $rspta->num_rows
    ]);
    break;
}