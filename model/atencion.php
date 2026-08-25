<?php

require_once "../config/conexion.php";

class Atencion
{
    // Método para obtener la información de una cita específica
    public function obtenerCita($id_cita){
        $sql = "CALL sp_cita('obtener','$id_cita',NULL,NULL,NULL)";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }
    // Crear u obtener la atención asociada a una cita
    public function crear($id_cita, $id_usuario){
        $id_cita = intval($id_cita);
        $id_usuario = intval($id_usuario);
        $sql = "CALL sp_atencion('crear',0,0,'$id_usuario','$id_cita',NULL)";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }
    // Método para listar los antecedentes de un paciente
    public function listarAntecedentes(){
    $sql = "CALL sp_atencion('listar_antecedentes',NULL,NULL,NULL,NULL,NULL)";
    return ejecutarConsulta($sql);
    }
    //Método para listar el examen estomatognático de un paciente
    public function listarEstomatognatico(){
    $sql = "CALL sp_atencion('listar_estomatognatico',NULL,NULL,NULL,NULL,NULL)";
    return ejecutarConsulta($sql);
    }
    //Método para listar los indicadores de salud bucal de un paciente
    public function listarIndicadores(){
    $sql = "CALL sp_atencion('listar_indicadores',NULL,NULL,NULL,NULL,NULL)";
    return ejecutarConsulta($sql);
    }
    //Combo CIE-10 - Procedimientos o protocolos de atención
    public function comboCIE10(){
    $sql = "CALL sp_atencion('combo_cie10',0,0,0,0,NULL)";
    return ejecutarConsultaSP($sql);

    }
    // Combo de tratamientos
    public function comboTratamientos(){
    $sql = "CALL sp_atencion('combo_tratamientos',0,0,0,0,NULL)";
    return ejecutarConsultaSP($sql);

    }

    // Listar simbologías
    public function listarSimbologias(){
        $sql = "CALL sp_odontograma('simbologias', NULL)";
        return ejecutarConsultaSP($sql);
    }

    // Listar piezas según dentición
    public function listarPiezas($tipo_denticion){
        $tipo_denticion = intval($tipo_denticion);
        $sql = "CALL sp_odontograma('piezas',$tipo_denticion)";

        return ejecutarConsultaSP($sql);
    }

    //Finalizamos la atención
    public function finalizar($id_atencion,$id_cita,$id_usuario,$datos){
        global $conexion;
        $id_atencion = intval($id_atencion);
        $id_cita = intval($id_cita);
        $id_usuario = intval($id_usuario);

        // Escapar JSON para enviarlo completo al SP
        $datos = mysqli_real_escape_string($conexion,$datos);
        $sql = "CALL sp_atencion('finalizar','$id_atencion',0,'$id_usuario','$id_cita','$datos')";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }
    
}