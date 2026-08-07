<?php

require_once "../config/conexion.php";

class Cie10{

    // Método para listar los diagnósticos CIE-10
    public function listar(){
        $sql = "CALL sp_cie10('listar',0,'','',0)";
        return ejecutarConsultaSP($sql);

    }

    // Método para obtener un diagnóstico
    public function obtener($id){
        $sql = "CALL sp_cie10('obtener',$id,'','',0)";
        return ejecutarConsultaSimpleFila($sql);

    }

    // Método para cambiar el estado
    public function cambiarEstado($id,$estado){
        $sql = "CALL sp_cie10('estado',$id,'','',$estado)";
        return ejecutarConsultaSP($sql);

    }

    // Método para insertar
    public function insertar($codigo,$descripcion){
        $sql = "CALL sp_cie10('guardar',0,'$codigo','$descripcion',1)";
        return ejecutarConsultaSP($sql);

    }

    // Método para editar
    public function editar($id,$codigo,$descripcion){
        $sql = "CALL sp_cie10('editar',$id,'$codigo','$descripcion',0)";
        return ejecutarConsultaSP($sql);

    }

}