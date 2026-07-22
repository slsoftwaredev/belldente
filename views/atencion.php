<?php
//Iniciamos la sesión para controlar el acceso a la página
session_start();
//Si no existe la variable de sesión id_usuario, redireccionamos al login
if(!isset($_SESSION["id_usuario"])){

    header("Location: login.php");
    exit();
}
//Obtenemos el id_cita de la URL, si no existe redireccionamos a citas.php
$id_cita = isset($_GET["id_cita"]) ? intval($_GET["id_cita"]) : 0;
//Si el id_cita es menor o igual a 0, redireccionamos a citas.php
if ($id_cita <= 0) {
    header("Location: citas.php?mensaje=seleccione_cita");
    exit;
}

//Controlamos a donde vamos a direccionar la vista y que se marque el menú lateral dependiendo de la página en la que nos encontremos
$contenido = "atencion/index.php";
$pagina = "atencion";
$titulo = "Atención al paciente";

//Incluimos las partes de la plantilla
require "layouts/header.php";
require "layouts/main.php";
require "layouts/footer.php";