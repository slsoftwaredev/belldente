<?php

require_once "../model/cita.php";

$cita = new Cita();

switch ($_GET["op"]) {

    case "listar":

        $rspta = $cita->listar();

        $data = [];

        while ($reg = $rspta->fetch_object()) {
            $estado = $reg->estado_cita == 1
                ? '<span class="text-green-600 font-medium">Agendada</span>'
                : '<span class="text-red-600 font-medium">Reagendada</span>';
            $data[] = [
                $reg->id_cita,
                $reg->paciente,
                $reg->fecha_cita,
                $estado
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
}