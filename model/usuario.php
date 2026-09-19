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
// Listamos los módulos disponibles para asignar permisos
public function listarModulos(){
    $sql = "CALL sp_usuario('modulos',0,'','','','','','','','',0,0)";
    return ejecutarConsultaSP($sql);
}
// Traemos los datos de un usuario para mostrarlos en el formulario y editarlos
public function obtener($id_usuario){
    $sql = "CALL sp_usuario('obtener','$id_usuario','','','','','','','','',0,0)";
    return ejecutarConsultaSimpleFila($sql);
}
// Método para editar usuario
public function editar($id_usuario,$nombre,$apellido,$correo,$cedula,$usuario,$domicilio,$telefono,$rol){
    $sql = "CALL sp_usuario('editar','$id_usuario','$nombre','$apellido','$correo','$cedula','$usuario','','$domicilio','$telefono','$rol',0)";
    return ejecutarConsultaSP($sql);
}
// Metodo para cambiar el estado del usuario: activar o desactivar
public function cambiarEstado($id_usuario, $estado){
    $sql = "CALL sp_usuario('estado','$id_usuario','','','','','','','','',0,'$estado')";
    return ejecutarConsultaSP($sql);
}
// Listamos los permisos asignados al usuario
public function listarPermisos($id_usuario){
    $sql = "CALL sp_usuario('permisos','$id_usuario','','','','','','','','',0,0)";
    return ejecutarConsultaSP($sql);
}
// Eliminamos los permisos actuales
public function eliminarPermisos($id_usuario){
    $sql = "CALL sp_usuario('eliminar_permisos','$id_usuario','','','','','','','','',0,0)";
    return ejecutarConsultaSP($sql);
}
// Asignamos un módulo al usuario
public function asignarPermiso($id_usuario, $id_modulo){
    $sql = "CALL sp_usuario('asignar_permiso','$id_usuario','','','','','','','','','$id_modulo',0)";
    return ejecutarConsultaSP($sql);
}
}