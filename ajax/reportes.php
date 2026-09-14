<?php
session_start();
require_once "../model/reportes.php";
header("Content-Type: application/json; charset=utf-8");
if (!isset($_SESSION["id_usuario"])) {
    echo json_encode([
        "status" => false,
        "message" => "Sesión no válida."
    ]);
    exit;
}

$reporte = new Reporte();
$op = isset($_GET["op"]) ? $_GET["op"] : "";

/* ==========================================
   RESUMEN
========================================== */
if ($op === "resumen") {
    $datos = $reporte->resumen();
    if ($datos) {
        echo json_encode([
            "status" => true,
            "datos" => $datos
        ]);

    } else {

        echo json_encode([
            "status" => false,
            "message" => "No se pudo obtener el resumen."
        ]);
    }
    exit;
}

/* ==========================================
   ESTADOS DE CITAS
========================================== */

if ($op === "estados_citas") {

    $datos = $reporte->listarEstadosCitas();

    echo json_encode([
        "status" => true,
        "datos" => $datos
    ]);

    exit;
}


/* ==========================================
   FORMAS DE PAGO
========================================== */
if ($op === "formas_pago") {

    $datos = $reporte->listarFormasPago();

    echo json_encode([
        "status" => true,
        "datos" => $datos
    ]);

    exit;
}