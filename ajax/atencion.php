<?php
require_once "../model/Atencion.php";

$atencion = new Atencion();

switch ($_GET["op"]) {

    case "obtener_cita":

        $rspta = $atencion->obtenerCita($_POST["id_cita"]);

        echo json_encode($rspta);

    break;
}