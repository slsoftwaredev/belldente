<?php

require_once "../config/conexion.php";

class Usuario{
// Metodo para verificar el acceso al sistema
    public function verificar($usuario){
        $usuario = limpiarCadena($usuario);
        $sql = "CALL sp_login_usuario('$usuario')";
        return ejecutarConsultaSP($sql);
    }

    // Metodo para listar los usuarios
    public function listar(){
        $sql = "CALL sp_usuario(
            'listar',0,'','','','','','','','',0,0)";
        return ejecutarConsultaSP($sql);
}
// Metodo para guardar un nuevo usuario
    public function guardar($nombre,$apellido,$correo,$cedula,$usuario,$password,$domicilio,$telefono,$rol){
        $sql = "CALL sp_usuario('guardar',0,'$nombre','$apellido','$correo','$cedula','$usuario','$password','$domicilio','$telefono','$rol',0)";
        return ejecutarConsultaSP($sql);
}
// Listamos los roles que vamos a asignar a los usuarios
public function listarRoles(){
    $sql = "CALL sp_usuario('roles',0,'','','','','','','','',0,0)";
    return ejecutarConsultaSP($sql);
}

}