<?php

require_once "../config/conexion.php";

class Usuario{
// Metodo para verificar el acceso al sistema
    public function verificar($usuario){
        $usuario = limpiarCadena($usuario);
        $sql = "CALL sp_login_usuario('$usuario')";
        return ejecutarConsultaSP($sql);
    }
}