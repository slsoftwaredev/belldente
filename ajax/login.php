<?php

session_start();

require_once "../model/usuario.php";

$usuarioModel = new Usuario();

$usuario = isset($_POST["usuario"])
    ? limpiarCadena($_POST["usuario"])
    : "";

$password = isset($_POST["password"])
    ? limpiarCadena($_POST["password"])
    : "";

// Ejecutamos consulta
$result = $usuarioModel->verificar($usuario);
//Convertimos en objeto
$datos = $result->fetch_object();

// Verificar si existe
if($datos){

    // Verificar password, $password debe apuntar al campo de la base de datos: pass_usuario que tenemos en la tabla usuario
    if(password_verify($password, $datos->pass_usuario)){
       

        $_SESSION["id_usuario"] = $datos->id_usuario;

        $_SESSION["nombre_usuario"] =
            $datos->nombre_usuario . " " .
            $datos->apellido_usuario;

        $_SESSION["usuario"] = $datos->usu_usuario;

        $_SESSION["rol"] = $datos->nombre_rol;

        $_SESSION["id_rol"] = $datos->id_rol;

        echo json_encode([
            "status" => true,
            "message" => "Login correcto"
        ]);

    }else{

        echo json_encode([
            "status" => false,
            "message" => "Contraseña incorrecta"
        ]);
    }

}else{

    echo json_encode([
        "status" => false,
        "message" => "Usuario no encontrado"
    ]);
}