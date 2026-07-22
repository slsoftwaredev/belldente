<?php

require_once "../config/conexion.php";

class Atencion
{
    // Método para obtener la información de una cita específica
    public function obtenerCita($id_cita)
    {
        $sql = "CALL sp_cita(
            'obtener',
            '$id_cita',
            NULL,
            NULL,
            NULL
        )";

        return ejecutarConsultaSimpleFilaAssoc($sql);
    }
}