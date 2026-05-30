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

            $data[] = array(
                "0" => $reg->id_usuario,
                "1" => $reg->nombre_completo,
                "2" => $reg->usu_usuario,
                "3" => $reg->nombre_rol,
                "4" => $estado,
                "5" => '<button>Editar</button>'
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
}