<?php
require_once 'global.php';
class Cls_DataConection{
    public function Fn_getConnect(){
        if(!($conexion1 = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME))){
            echo "Error: No se pudo conectar a la Base de Datos";
            exit();
        }
        return $conexion1;
    }
}
?>