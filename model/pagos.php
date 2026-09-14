<?php
require_once __DIR__ . "/../config/conexion.php";
class Pago{
//Listamos las ordenes de pago
    public function listar(){
            $sql = "CALL sp_pago('listar',0,0,0,0,NULL)";
            return ejecutarConsulta($sql);
    }
//Obtener orden
    public function obtener($id_orden_pago){
        $id_orden_pago = intval($id_orden_pago);
        $sql = "CALL sp_pago('obtener','$id_orden_pago',0,0,0,NULL)";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }

//Detalle de la orden de pago
    public function detalle($id_orden_pago){
        $id_orden_pago = intval($id_orden_pago);
        $sql = "CALL sp_pago('detalle','$id_orden_pago',0,0,0,NULL)";
        return ejecutarConsulta($sql);
    }

//Formas de pago
    public function listarFormasPago(){
        $sql = "CALL sp_pago('formas_pago',0,0,0,0,NULL)";
        return ejecutarConsulta($sql);
    }

//Registrar abonos
    public function registrarAbono($id_orden_pago,$forma_pago_id,$valor_abono,$observacion) {
        $id_orden_pago = intval($id_orden_pago);
        $forma_pago_id = intval($forma_pago_id);
        $valor_abono = floatval($valor_abono);
        $observacion = limpiarCadena($observacion);
        $sql = "CALL sp_pago('registrar_abono','$id_orden_pago',0,'$forma_pago_id','$valor_abono','$observacion')";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }

//Historial de abonos
    public function listarAbonos($id_orden_pago){
        $id_orden_pago = intval($id_orden_pago);
        $sql = "CALL sp_pago('listar_abonos','$id_orden_pago',0,0,0,NULL)";
        return ejecutarConsulta($sql);
    }

//Datos para generar comprobante
    public function comprobante($id_abono){

    global $conexion;

    $id_abono = intval($id_abono);

    $sql = "CALL sp_pago(
        'comprobante',
        0,
        '$id_abono',
        0,
        0,
        NULL
    )";

    $query = $conexion->query($sql);

    if (!$query) {
        return false;
    }

    $row = $query->fetch_assoc();

    $query->free();

    //Limpiamos únicamente los resultados de este CALL
    while ($conexion->more_results()) {

        $conexion->next_result();

        if ($resultado = $conexion->store_result()) {
            $resultado->free();
        }
    }

    return $row;
}
}