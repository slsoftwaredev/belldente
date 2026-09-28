<?php

session_start();

if(!isset($_SESSION["id_usuario"])){

    header("Location: login.php");

    exit();
}
require_once "../config/permisos.php";
// Verificamos permiso para Dashboard
verificarPermiso("dashboard");

 $_SESSION["nombre_usuario"]; ?>
<?php

$contenido = "dashboard/index.php";
$pagina = "dashboard";
$titulo = "Escritorio";

require "layouts/header.php";
require "layouts/main.php";
require "layouts/footer.php";

?>