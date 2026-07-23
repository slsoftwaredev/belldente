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
    //Método para listar el examen estomatognático de un paciente
    public function listarEstomatognatico(){
    $sql = "CALL sp_atencion('listar_estomatognatico',NULL,NULL,NULL)";
    return ejecutarConsulta($sql);
    }
    //Método para listar los indicadores de salud bucal de un paciente
    public function listarIndicadores(){
    $sql = "CALL sp_atencion('listar_indicadores',NULL,NULL,NULL)";
    return ejecutarConsulta($sql);
    }
}