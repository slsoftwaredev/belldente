<?php

require_once "../config/conexion.php";

class Cita{
    // listamos todas las citas
    public function listar(){
        return ejecutarConsultaSP(
            "CALL sp_cita('listar',0,0,NULL,0)");
    }

    // Agendamos una nueva cita
    public function guardar($paciente_id,$fecha_cita){
        return ejecutarConsultaSP(
            "CALL sp_cita('guardar',0,'$paciente_id','$fecha_cita',1)");
    }

    // Obtenemos los datos de una cita
    public function obtener($id_cita){
        return ejecutarConsultaSP(
            "CALL sp_cita('obtener','$id_cita',0,NULL,0)");
    }

    // Editamos una cita
    public function editar($id_cita,$paciente_id,$fecha_cita,$estado){
        return ejecutarConsultaSP(
            "CALL sp_cita('editar','$id_cita','$paciente_id','$fecha_cita','$estado')");
    }

    // Actualizamos el estado de una cita
    public function estado($id_cita,$estado){
        return ejecutarConsultaSP(
            "CALL sp_cita('estado','$id_cita',0,NULL,'$estado')");
    }

    // Listamos las citas del día
    public function citasHoy(){
        return ejecutarConsultaSP(
            "CALL sp_cita('citas_hoy',0,0,NULL,0)");
    }
    
    // Listamos las citas atrasadas
    public function citasAtrasadas(){
        return ejecutarConsultaSP(
            "CALL sp_cita('citas_atrasadas',0,0,NULL,0)");
    }
}