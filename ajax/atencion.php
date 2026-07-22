<?php
require_once "../model/Atencion.php";

$atencion = new Atencion();

switch ($_GET["op"]) {
// Obtener la información de una cita específica
    case "obtener_cita":

        $rspta = $atencion->obtenerCita($_POST["id_cita"]);

        echo json_encode($rspta);

    break;
//Listamos los antecedentes
case "listar_antecedentes":
    $rspta = $atencion->listarAntecedentes();
    $data = [];
    while($reg = $rspta->fetch_object()){
        $data[] = $reg;
    }
    echo json_encode($data);

break;
}