<?php

require_once "../config/conexion.php";

class Tratamiento{

    // Método para listar los tratamientos
    public function listar(){
        $sql = "CALL sp_tratamiento('listar',0,'',0,0)";
        return ejecutarConsultaSP($sql);

    }

    // Método para obtener un tratamiento
    public function obtener($id){
        $sql = "CALL sp_tratamiento('obtener',$id,'',0,0)";
        return ejecutarConsultaSimpleFila($sql);

    }

    // Método para cambiar el estado
    public function cambiarEstado($id,$estado){
        $sql = "CALL sp_tratamiento('estado',$id,'',0,$estado)";
        return ejecutarConsultaSP($sql);

    }

    // Método para insertar un tratamiento
    public function insertar($nombre,$valor){
        $sql = "CALL sp_tratamiento('guardar',0,'$nombre','$valor',1)";
        return ejecutarConsultaSP($sql);

    }

    // Método para editar un tratamiento
    public function editar($id,$nombre,$valor){
        $sql = "CALL sp_tratamiento('editar',$id,'$nombre','$valor',0)";
        return ejecutarConsultaSP($sql);

    }

}