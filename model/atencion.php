<?php

require_once "../config/conexion.php";

class Atencion
{
    // Método para obtener la información de una cita específica
    public function obtenerCita($id_cita){
        $sql = "CALL sp_cita('obtener','$id_cita',NULL,NULL,NULL)";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }
    // Método para listar los antecedentes de un paciente
    public function listarAntecedentes(){
    $sql = "CALL sp_atencion('listar_antecedentes',NULL,NULL,NULL)";
    return ejecutarConsulta($sql);

}
}