<?php

session_start();

if(!isset($_SESSION["id_usuario"])){

    header("Location: login.php");

    exit();
}

 $_SESSION["nombre_usuario"]; ?>
<?php

$contenido = "dashboard/index.php";
$pagina = "dashboard";
$titulo = "Escritorio";

require "layouts/header.php";
require "layouts/main.php";
require "layouts/footer.php";

?>