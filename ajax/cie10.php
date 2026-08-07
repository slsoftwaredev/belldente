<?php

require_once "../model/Cie10.php";

$cie10 = new Cie10();

switch ($_GET["op"]) {

    // Listar diagnósticos CIE-10
    case 'listar':

        $rspta = $cie10->listar();

        $data = array();

        while ($reg = $rspta->fetch_object()) {

            $estado = $reg->estado_cie10 == 1

                ? '<span class="text-green-600 font-medium">Activo</span>'

                : '<span class="text-red-600 font-medium">Inactivo</span>';

            $btnEstado = $reg->estado_cie10 == 1

                ?

                '<button
                    onclick="cambiarEstado('.$reg->id_cie10.',0)"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">

                    Inactivar

                </button>'

                :

                '<button
                    onclick="cambiarEstado('.$reg->id_cie10.',1)"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg">

                    Activar

                </button>';

            $data[] = array(

                "0" => $reg->codigo_cie10,

                "1" => $reg->descripcion_cie10,

                "2" => $estado,

                "3" => '

                    <div class="flex gap-2 justify-center">

                        <button

                            onclick="editarCIE10('.$reg->id_cie10.')"

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

    // Guardar
    case 'guardar':

        $codigo = limpiarCadena($_POST["codigo"]);

        $descripcion = limpiarCadena($_POST["descripcion"]);

        $rspta = $cie10->insertar(

            $codigo,

            $descripcion

        );

        echo json_encode([

            "status" => $rspta ? true : false

        ]);

    break;

    // Obtener
    case 'obtener':

        $rspta = $cie10->obtener(

            $_POST["id_cie10"]

        );

        echo json_encode($rspta);

    break;

    // Editar
    case 'editar':

        $id = limpiarCadena($_POST["id_cie10"]);

        $codigo = limpiarCadena($_POST["codigo"]);

        $descripcion = limpiarCadena($_POST["descripcion"]);

        $rspta = $cie10->editar(

            $id,

            $codigo,

            $descripcion

        );

        echo json_encode([

            "status" => $rspta ? true : false

        ]);

    break;

    // Estado
    case 'estado':

        $id = limpiarCadena($_POST["id_cie10"]);

        $estado = limpiarCadena($_POST["estado"]);

        $rspta = $cie10->cambiarEstado(

            $id,

            $estado

        );

        echo json_encode([

            "status" => $rspta ? true : false

        ]);

    break;

}