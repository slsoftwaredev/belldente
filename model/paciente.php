<?php
require_once "../config/conexion.php";
class Paciente{
    // Metodo para listar los pacientes
    public function listar()
{
    $sql = "CALL sp_paciente('listar',0,'','','',NULL,'','','','',0)";
    return ejecutarConsultaSP($sql);
}
// Metodo para obtener los datos de un paciente para mostrarlos en el formulario y editarlos
public function obtener($id)
{
    $sql = "CALL sp_paciente('obtener',$id,'','','',NULL,'','','','',0)";
    return ejecutarConsultaSimpleFila($sql);
}
// Metodo para cambiar el estado del paciente: activar o desactivar
public function cambiarEstado($id,$estado)
{
    $sql = "CALL sp_paciente('estado',$id,'','','',NULL,'','','','',$estado)";
    return ejecutarConsultaSP($sql);
}
// Metodo para insertar un nuevo paciente
public function insertar($nombre,$apellido,$cedula,$fechaNacimiento,$sexo,$telefono,$correo,$direccion){
    $sql = "CALL sp_paciente('guardar',0,'$nombre','$apellido','$cedula','$fechaNacimiento','$sexo','$telefono','$correo','$direccion',1)";
    return ejecutarConsultaSP($sql);
}
// Metodo para editar un paciente
public function editar($id,$nombre,$apellido,$cedula,$fechaNacimiento,$sexo,$telefono,$correo,$direccion){
    $sql = "CALL sp_paciente('editar','$id','$nombre','$apellido','$cedula','$fechaNacimiento','$sexo','$telefono','$correo','$direccion',0)";
    return ejecutarConsultaSP($sql);
}
// Metodo para listar los pacientes activos en un combo
public function combo(){
    $sql = "CALL sp_paciente('combo',0,'','','',NULL,'','','','',0)";
    return ejecutarConsultaSP($sql);
}
// Método para buscar un paciente por cédula
public function buscarCedula($cedula){
    $sql = "CALL sp_paciente('buscar_cedula',0,'','','$cedula',NULL,'','','','',0)";
    return ejecutarConsultaSP($sql);
}
}
