<?php
//Iniciamos la sesión para controlar el acceso a la página
session_start();
//Si no existe la variable de sesión id_usuario, redireccionamos al login
if(!isset($_SESSION["id_usuario"])){

    header("Location: login.php");
    exit();
}
//CONTROL DE VISTA
$id_paciente = isset($_GET["id_paciente"]) ? intval($_GET["id_paciente"]) : 0;
// Si recibimos un paciente, mostramos su historia.
// Si no, mostramos el listado general.
if ($id_paciente > 0) {
    $contenido = "historias/historia.php";
    $titulo = "Historia Clínica";
} else {
    $contenido = "historias/index.php";
    $titulo = "Historias Clínicas";
}
//Controlamos a donde vamos a direccionar la vista y que se marque el menú lateral dependiendo de la página en la que nos encontremos
$contenido = "historias/index.php";
$pagina = "historias";
$titulo = "Historias Clínicas";
//Incluimos las partes de la plantilla
require "layouts/header.php";
require "layouts/main.php";
require "layouts/footer.php";