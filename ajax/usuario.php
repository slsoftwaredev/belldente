<?php

require_once "../model/Usuario.php";

$usuario = new Usuario();

switch ($_GET["op"]) {
// Listamos los usuarios
    case 'listar':

        $rspta = $usuario->listar();

        $data = array();

        while ($reg = $rspta->fetch_object()) {

            $estado = $reg->estado_usuario == 1
                ? '<span class="text-green-600 font-medium">Activo</span>'
                : '<span class="text-red-600 font-medium">Inactivo</span>';
            $btnEstado = $reg->estado_usuario == 1
                ?
                '<button
                    onclick="cambiarEstado('.$reg->id_usuario.',0)"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">
                    Inactivar
                </button>'
                :
                '<button
                    onclick="cambiarEstado('.$reg->id_usuario.',1)"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg">
                    Activar
                </button>';
            $data[] = array(
                "0" => $reg->id_usuario,
                "1" => $reg->nombre_completo,
                "2" => $reg->usu_usuario,
                "3" => $reg->nombre_rol,
                "4" => $estado,
                "5" => '<div class="flex gap-2 justify-center">

            <button
                onclick="editarUsuario('.$reg->id_usuario.')"
                class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded-lg">

                Editar

            </button>

            '.$btnEstado.'

        </div>'
            );
        }

        echo json_encode($data);

    break;
    // Guardamos un nuevo usuario
    case 'guardar':

    $nombre = limpiarCadena($_POST["nombre"]);
    $apellido = limpiarCadena($_POST["apellido"]);
    $correo = limpiarCadena($_POST["correo"]);
    $cedula = limpiarCadena($_POST["cedula"]);
    $usuarioLogin = limpiarCadena($_POST["usuario"]);
    $domicilio = limpiarCadena($_POST["domicilio"]);
    $telefono = limpiarCadena($_POST["telefono"]);
    $rol = limpiarCadena($_POST["rol"]);

    $password = password_hash(
        $_POST["password"],
        PASSWORD_BCRYPT
    );

    $rspta = $usuario->guardar(
        $nombre,
        $apellido,
        $correo,
        $cedula,
        $usuarioLogin,
        $password,
        $domicilio,
        $telefono,
        $rol
    );

    echo json_encode([
        "status" => $rspta ? true : false
    ]);

    break;
    // Listamos los roles para asignar a los usuarios
    case 'roles':

    $rspta = $usuario->listarRoles();

    $data = array();

    while($reg = $rspta->fetch_object()){

        $data[] = $reg;

    }

    echo json_encode($data);

    break;
// Obtenemos los datos de un usuario para mostrarlos en el formulario y editarlos
    case 'obtener':

    $rspta = $usuario->obtener($_POST["id_usuario"]);

    echo json_encode($rspta);

    break;
// Metodo para editar usuario
    case 'editar':

    $id_usuario = limpiarCadena($_POST["id_usuario"]);
    $nombre = limpiarCadena($_POST["nombre"]);
    $apellido = limpiarCadena($_POST["apellido"]);
    $correo = limpiarCadena($_POST["correo"]);
    $cedula = limpiarCadena($_POST["cedula"]);
    $usuarioLogin = limpiarCadena($_POST["usuario"]);
    $domicilio = limpiarCadena($_POST["domicilio"]);
    $telefono = limpiarCadena($_POST["telefono"]);
    $rol = limpiarCadena($_POST["rol"]);

    $rspta = $usuario->editar($id_usuario,$nombre,$apellido,$correo,$cedula,$usuarioLogin,$domicilio,$telefono,$rol);
        echo json_encode([
        "status" => $rspta ? true : false
    ]);

    break;
// Metodo para cambiar el estado del usuario: activar o desactivar
case 'estado':

    $id_usuario = limpiarCadena($_POST["id_usuario"]);
    $estado = limpiarCadena($_POST["estado"]);

    $rspta = $usuario->cambiarEstado(
        $id_usuario,
        $estado
    );

    echo json_encode([
        "status" => $rspta ? true : false
    ]);

break;
}