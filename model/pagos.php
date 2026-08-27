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
}