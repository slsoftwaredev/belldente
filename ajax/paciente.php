<?php

require_once "../model/Paciente.php";

$paciente = new Paciente();

switch ($_GET["op"]) {

    // Listar pacientes
    case 'listar':

        $rspta = $paciente->listar();

        $data = array();

        while ($reg = $rspta->fetch_object()) {

            $estado = $reg->estado_paciente == 1
                ? '<span class="text-green-600 font-medium">Activo</span>'
                : '<span class="text-red-600 font-medium">Inactivo</span>';

            $btnEstado = $reg->estado_paciente == 1
                ?
                '<button
                    onclick="cambiarEstado('.$reg->id_paciente.',0)"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">
                    Inactivar
                </button>'
                :
                '<button
                    onclick="cambiarEstado('.$reg->id_paciente.',1)"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg">
                    Activar
                </button>';

            $data[] = array(

                "0" => $reg->id_paciente,

                "1" => $reg->nombre_completo,

                "2" => $reg->cedula_paciente,

                "3" => $reg->telefono_paciente,

                "4" => $estado,

                "5" => '<div class="flex gap-2 justify-center">

                    <button
                        onclick="editarPaciente('.$reg->id_paciente.')"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded-lg">

                        Editar

                    </button>

                    '.$btnEstado.'

                </div>'
            );
        }

        echo json_encode($data);

    break;

    // Guardar paciente
    case 'guardar':

        $nombre = limpiarCadena($_POST["nombre"]);
        $apellido = limpiarCadena($_POST["apellido"]);
        $cedula = limpiarCadena($_POST["cedula"]);
        $fechaNacimiento = limpiarCadena($_POST["fecha_nacimiento"]);
        $sexo = limpiarCadena($_POST["sexo"]);
        $telefono = limpiarCadena($_POST["telefono"]);
        $correo = limpiarCadena($_POST["correo"]);
        $direccion = limpiarCadena($_POST["domicilio"]);

        $rspta = $paciente->insertar(
            $nombre,
            $apellido,
            $cedula,
            $fechaNacimiento,
            $sexo,
            $telefono,
            $correo,
            $direccion
        );

        echo json_encode([
            "status" => $rspta ? true : false
        ]);

    break;

    // Obtener paciente
    case 'obtener':

        $rspta = $paciente->obtener(
            $_POST["id_paciente"]
        );

        echo json_encode($rspta);

    break;

    // Editar paciente
    case 'editar':

        $id = limpiarCadena($_POST["id_paciente"]);

        $nombre = limpiarCadena($_POST["nombre"]);
        $apellido = limpiarCadena($_POST["apellido"]);
        $cedula = limpiarCadena($_POST["cedula"]);
        $fechaNacimiento = limpiarCadena($_POST["fecha_nacimiento"]);
        $sexo = limpiarCadena($_POST["sexo"]);
        $telefono = limpiarCadena($_POST["telefono"]);
        $correo = limpiarCadena($_POST["correo"]);
        $direccion = limpiarCadena($_POST["domicilio"]);

        $rspta = $paciente->editar(
            $id,
            $nombre,
            $apellido,
            $cedula,
            $fechaNacimiento,
            $sexo,
            $telefono,
            $correo,
            $direccion
        );

        echo json_encode([
            "status" => $rspta ? true : false
        ]);

    break;

    // Estado
    case 'estado':

        $id = limpiarCadena($_POST["id_paciente"]);
        $estado = limpiarCadena($_POST["estado"]);

        $rspta = $paciente->cambiarEstado(
            $id,
            $estado
        );

        echo json_encode([
            "status" => $rspta ? true : false
        ]);

    break;
}