<?php

require_once "../model/Tratamiento.php";

$tratamiento = new Tratamiento();

switch ($_GET["op"]) {

    // Listar tratamientos
    case 'listar':

        $rspta = $tratamiento->listar();

        $data = array();

        while ($reg = $rspta->fetch_object()) {

            $estado = $reg->estado_procedimiento == 1

                ? '<span class="text-green-600 font-medium">Activo</span>'

                : '<span class="text-red-600 font-medium">Inactivo</span>';

            $btnEstado = $reg->estado_procedimiento == 1

                ?

                '<button
                    onclick="cambiarEstado('.$reg->id_procedimiento.',0)"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">

                    Inactivar

                </button>'

                :

                '<button
                    onclick="cambiarEstado('.$reg->id_procedimiento.',1)"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg">

                    Activar

                </button>';

            $data[] = array(

                "0" => $reg->nombre_procedimiento,

                "1" => "$ ".number_format($reg->costo_procedimiento,2),

                "2" => $estado,

                "3" => '

                    <div class="flex gap-2 justify-center">

                        <button
                            onclick="editarTratamiento('.$reg->id_procedimiento.')"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded-lg">

                            Editar

                        </button>

                        '.$btnEstado.'

                    </div>

                '

            );

        }

        echo json_encode($data);

    break;

    // Guardar tratamiento
    case 'guardar':

        $nombre = limpiarCadena($_POST["nombre"]);
        $valor = limpiarCadena($_POST["valor"]);

        $rspta = $tratamiento->insertar(

            $nombre,
            $valor

        );

        echo json_encode([

            "status" => $rspta ? true : false

        ]);

    break;

    // Obtener tratamiento
    case 'obtener':

        $rspta = $tratamiento->obtener(

            $_POST["id_procedimiento"]

        );

        echo json_encode($rspta);

    break;

    // Editar tratamiento
    case 'editar':

        $id = limpiarCadena($_POST["id_procedimiento"]);

        $nombre = limpiarCadena($_POST["nombre"]);

        $valor = limpiarCadena($_POST["valor"]);

        $rspta = $tratamiento->editar(

            $id,
            $nombre,
            $valor

        );

        echo json_encode([

            "status" => $rspta ? true : false

        ]);

    break;

    // Cambiar estado
    case 'estado':

        $id = limpiarCadena($_POST["id_procedimiento"]);

        $estado = limpiarCadena($_POST["estado"]);

        $rspta = $tratamiento->cambiarEstado(

            $id,
            $estado

        );

        echo json_encode([

            "status" => $rspta ? true : false

        ]);

    break;

}