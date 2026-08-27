<?php
session_start();
require_once "../model/pagos.php";
$pago = new Pago();
if (!isset($_SESSION["id_usuario"])) {
    echo json_encode(["status" => false,"message" => "Sesión no válida"]);
    exit;
}

//Operacion que vamos a hacer
$op = isset($_GET["op"]) ? $_GET["op"] : "";
switch ($op) {
//Listar ordenes de pago
    case "listar":
        $rspta = $pago->listar();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "id_orden_pago"   => $reg->id_orden_pago,
                "atencion_id"     => $reg->atencion_id,

                "id_paciente"     => $reg->id_paciente,
                "cedula"          => $reg->cedula_paciente,
                "nombre"          => $reg->nombre_paciente,
                "apellido"        => $reg->apellido_paciente,

                "fecha_atencion"  => $reg->fecha_atencion,

                "total"           => $reg->total,
                "abonado"         => $reg->abonado,
                "saldo"           => $reg->saldo,
                "estado_pago"     => $reg->estado_pago,

                "fecha_registro"  => $reg->fecha_registro
            ];
        }

        echo json_encode([
            "status" => true,
            "data" => $data
        ]);

    break;

//Obtenemos una orden de pago
    case "obtener":
        $id_orden_pago = isset($_POST["id_orden_pago"]) ? intval($_POST["id_orden_pago"]) : 0;
        if ($id_orden_pago <= 0) {
            echo json_encode([
                "status" => false,
                "message" => "Orden de pago no válida"
            ]);
            exit;
        }
        $rspta = $pago->obtener($id_orden_pago);
        if ($rspta) {
            echo json_encode([
                "status" => true,
                "datos" => $rspta
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "No se encontró la orden de pago"
            ]);
        }
    break;

//Detalle de la orden de pago
    case "detalle":
        $id_orden_pago = isset($_POST["id_orden_pago"]) ? intval($_POST["id_orden_pago"]) : 0;
        if ($id_orden_pago <= 0) {
            echo json_encode([
                "status" => false,
                "message" => "Orden de pago no válida"
            ]);
            exit;
        }
        $rspta = $pago->detalle($id_orden_pago);
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "id_detalle_orden" => $reg->id_detalle_orden,
                "orden_pago_id"    => $reg->orden_pago_id,
                "tratamiento_id"   => $reg->tratamiento_id,

                "procedimiento"    => $reg->nombre_procedimiento,

                "cantidad"         => $reg->cantidad,
                "precio_unitario"  => $reg->precio_unitario,
                "subtotal"         => $reg->subtotal
            ];
        }
        echo json_encode([
            "status" => true,
            "data" => $data
        ]);
    break;

//Traemos las formas de pago que hay
    case "formas_pago":
        $rspta = $pago->listarFormasPago();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "id_forma_pago"     => $reg->id_forma_pago,
                "nombre_forma_pago" => $reg->nombre_forma_pago
            ];
        }
        echo json_encode([
            "status" => true,
            "data" => $data
        ]);
    break;

//Registrar abonos
    case "registrar_abono":
        $id_orden_pago = isset($_POST["id_orden_pago"]) ? intval($_POST["id_orden_pago"]) : 0;
        $forma_pago_id = isset($_POST["forma_pago_id"]) ? intval($_POST["forma_pago_id"]) : 0;
        $valor_abono = isset($_POST["valor_abono"]) ? floatval($_POST["valor_abono"]) : 0;
        $observacion = isset($_POST["observacion"]) ? trim($_POST["observacion"]) : "";

        //Validamos la orden
        if ($id_orden_pago <= 0) {
            echo json_encode([
                "status" => false,
                "message" => "Orden de pago no válida"
            ]);
            exit;
        }
        if ($forma_pago_id <= 0) {
            echo json_encode([
                "status" => false,
                "message" => "Seleccione una forma de pago"
            ]);
            exit;
        }
        if ($valor_abono <= 0) {
            echo json_encode([
                "status" => false,
                "message" => "Ingrese un valor válido"
            ]);
            exit;
        }
        try {
            $rspta = $pago->registrarAbono($id_orden_pago,$forma_pago_id,$valor_abono,$observacion);
            if ($rspta) {
                echo json_encode([
                    "status" => true,
                    "message" => "Pago registrado correctamente",
                    "datos" => $rspta
                ]);
            } else {
                echo json_encode([
                    "status" => false,
                    "message" => "No se pudo registrar el pago"
                ]);
            }
        } catch (Throwable $e) {
            echo json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    break;

//Listamos todos los abonos que se han hecho
    case "listar_abonos":
        $id_orden_pago = isset($_POST["id_orden_pago"]) ? intval($_POST["id_orden_pago"]) : 0;
        if ($id_orden_pago <= 0) {
            echo json_encode([
                "status" => false,
                "message" => "Orden de pago no válida"
            ]);
            exit;
        }
        $rspta = $pago->listarAbonos($id_orden_pago);
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "id_abono"         => $reg->id_abono,
                "orden_pago_id"    => $reg->orden_pago_id,

                "id_forma_pago"    => $reg->id_forma_pago,
                "forma_pago"       => $reg->nombre_forma_pago,

                "valor_abono"      => $reg->valor_abono,
                "observacion"      => $reg->observacion,
                "fecha_abono"      => $reg->fecha_abono
            ];
        }
        echo json_encode([
            "status" => true,
            "data" => $data
        ]);
    break;

    default:
        echo json_encode([
            "status" => false,
            "message" => "Operación no válida"
        ]);
    break;
}