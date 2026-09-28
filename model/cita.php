<?php

require_once "../config/conexion.php";

class Cita
{
    /* =====================================================
       LISTAR CITAS
    ===================================================== */
    public function listar()
{
    $sql = "CALL sp_cita(
        'listar',
        0,
        0,
        0,
        NULL,
        NULL,
        '',
        0
    )";

    return ejecutarConsultaSP($sql);
}


    /* =====================================================
       GUARDAR CITA
       La hora queda pendiente
    ===================================================== */
    public function guardar(
        $paciente_id,
        $dentista_id,
        $fecha_cita,
        $motivo_cita
    ) {
        $sql = "CALL sp_cita(
            'guardar',
            0,
            '$paciente_id',
            '$dentista_id',
            '$fecha_cita',
            NULL,
            '$motivo_cita',
            1
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       OBTENER CITA
    ===================================================== */
    public function obtener($id_cita)
    {
        $sql = "CALL sp_cita(
            'obtener',
            '$id_cita',
            0,
            0,
            NULL,
            NULL,
            '',
            0
        )";

        return ejecutarConsultaSimpleFila($sql);
    }


    /* =====================================================
       REAGENDAR CITA
    ===================================================== */
    public function editar(
        $id_cita,
        $paciente_id,
        $dentista_id,
        $fecha_cita,
        $motivo_cita
    ) {
        $sql = "CALL sp_cita(
            'editar',
            '$id_cita',
            '$paciente_id',
            '$dentista_id',
            '$fecha_cita',
            NULL,
            '$motivo_cita',
            2
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       CAMBIAR ESTADO
    ===================================================== */
    public function cambiarEstado($id_cita, $estado)
    {
        $sql = "CALL sp_cita(
            'estado',
            '$id_cita',
            0,
            0,
            NULL,
            NULL,
            '',
            '$estado'
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       LISTAR DENTISTAS
    ===================================================== */
    public function listarDentistas()
    {
        $sql = "CALL sp_cita(
            'dentistas',
            0,
            0,
            0,
            NULL,
            NULL,
            '',
            0
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       OBTENER HORARIO DEL CONSULTORIO SEGÚN FECHA
    ===================================================== */
    public function obtenerHorario($fecha_cita)
    {
        $sql = "CALL sp_cita(
            'horario',
            0,
            0,
            0,
            '$fecha_cita',
            NULL,
            '',
            0
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       OBTENER HORAS OCUPADAS
    ===================================================== */
    public function horasOcupadas(
        $id_cita,
        $dentista_id,
        $fecha_cita
    ) {
        $sql = "CALL sp_cita(
            'horas_ocupadas',
            '$id_cita',
            0,
            '$dentista_id',
            '$fecha_cita',
            NULL,
            '',
            0
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       CONFIRMAR HORA
    ===================================================== */
    public function confirmarHora(
        $id_cita,
        $dentista_id,
        $fecha_cita,
        $hora_cita
    ) {
        $sql = "CALL sp_cita(
            'confirmar_hora',
            '$id_cita',
            0,
            '$dentista_id',
            '$fecha_cita',
            '$hora_cita',
            '',
            0
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       CITAS DE HOY
    ===================================================== */
    public function citasHoy()
    {
        $sql = "CALL sp_cita(
            'citas_hoy',
            0,
            0,
            0,
            NULL,
            NULL,
            '',
            0
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       CITAS ATRASADAS
    ===================================================== */
    public function citasAtrasadas()
    {
        $sql = "CALL sp_cita(
            'citas_atrasadas',
            0,
            0,
            0,
            NULL,
            NULL,
            '',
            0
        )";

        return ejecutarConsultaSP($sql);
    }


    /* =====================================================
       PENDIENTES DE HOY
    ===================================================== */
    public function pendientesHoy()
    {
        $sql = "CALL sp_cita(
            'pendientes_hoy',
            0,
            0,
            0,
            NULL,
            NULL,
            '',
            0
        )";

        return ejecutarConsultaSP($sql);
    }
}