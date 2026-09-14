<?php

require_once __DIR__ . "/../config/conexion.php";

class Reporte
{

    /* ==========================================
       RESUMEN GENERAL
    ========================================== */
    public function resumen()
    {
        $sql = "CALL sp_reporte(
            'resumen',
            NULL,
            NULL,
            NULL,
            NULL
        )";

        return ejecutarConsultaSimpleFilaAssoc($sql);
    }


    /* ==========================================
       ESTADOS DE CITAS
    ========================================== */
    public function listarEstadosCitas()
{
    global $conexion;

    $sql = "CALL sp_reporte(
        'estados_citas',
        NULL,
        NULL,
        NULL,
        NULL
    )";

    $query = $conexion->query($sql);

    if (!$query) {
        throw new Exception(
            "Error al listar estados de citas: " . $conexion->error
        );
    }

    $datos = [];

    while ($row = $query->fetch_assoc()) {
        $datos[] = $row;
    }

    $query->free();

    // Limpiamos resultados pendientes del CALL
    while ($conexion->more_results()) {

        $conexion->next_result();

        if ($resultado = $conexion->store_result()) {
            $resultado->free();
        }
    }

    return $datos;
}


    /* ==========================================
       FORMAS DE PAGO
    ========================================== */
    public function listarFormasPago()
{
    global $conexion;

    $sql = "CALL sp_reporte(
        'formas_pago',
        NULL,
        NULL,
        NULL,
        NULL
    )";

    $query = $conexion->query($sql);

    if (!$query) {
        throw new Exception(
            "Error al listar formas de pago: " . $conexion->error
        );
    }

    $datos = [];

    while ($row = $query->fetch_assoc()) {
        $datos[] = $row;
    }

    $query->free();

    // Limpiamos resultados pendientes del CALL
    while ($conexion->more_results()) {

        $conexion->next_result();

        if ($resultado = $conexion->store_result()) {
            $resultado->free();
        }
    }

    return $datos;
}


    /* ==========================================
       PACIENTES
    ========================================== */
    public function pacientes($estado = -1)
    {
        $estado = intval($estado);

        $sql = "CALL sp_reporte(
            'pacientes',
            NULL,
            NULL,
            '$estado',
            NULL
        )";

        return ejecutarConsulta($sql);
    }


    /* ==========================================
       CITAS
    ========================================== */
    public function citas($desde, $hasta, $estado = 0)
    {
        $desde = limpiarCadena($desde);
        $hasta = limpiarCadena($hasta);
        $estado = intval($estado);

        $fechaDesde = $desde !== "" ? "'$desde'" : "NULL";
        $fechaHasta = $hasta !== "" ? "'$hasta'" : "NULL";

        $sql = "CALL sp_reporte(
            'citas',
            $fechaDesde,
            $fechaHasta,
            '$estado',
            NULL
        )";

        return ejecutarConsulta($sql);
    }


    /* ==========================================
       ATENCIONES
    ========================================== */
    public function atenciones($desde, $hasta)
    {
        $desde = limpiarCadena($desde);
        $hasta = limpiarCadena($hasta);

        $fechaDesde = $desde !== "" ? "'$desde'" : "NULL";
        $fechaHasta = $hasta !== "" ? "'$hasta'" : "NULL";

        $sql = "CALL sp_reporte(
            'atenciones',
            $fechaDesde,
            $fechaHasta,
            NULL,
            NULL
        )";

        return ejecutarConsulta($sql);
    }


    /* ==========================================
       MOVIMIENTOS DE PAGO
    ========================================== */
    public function movimientosPago($desde, $hasta, $formaPago = 0)
    {
        $desde = limpiarCadena($desde);
        $hasta = limpiarCadena($hasta);
        $formaPago = intval($formaPago);

        $fechaDesde = $desde !== "" ? "'$desde'" : "NULL";
        $fechaHasta = $hasta !== "" ? "'$hasta'" : "NULL";

        $sql = "CALL sp_reporte(
            'movimientos_pago',
            $fechaDesde,
            $fechaHasta,
            NULL,
            '$formaPago'
        )";

        return ejecutarConsulta($sql);
    }


    /* ==========================================
       CUENTAS POR COBRAR
    ========================================== */
    public function cuentasCobrar()
    {
        $sql = "CALL sp_reporte(
            'cuentas_cobrar',
            NULL,
            NULL,
            NULL,
            NULL
        )";

        return ejecutarConsulta($sql);
    }
}