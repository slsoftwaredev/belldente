<?php
//Iniciamos la sesión para controlar el acceso a la página
session_start();
//Si no existe la variable de sesión id_usuario, redireccionamos al login
if(!isset($_SESSION["id_usuario"])){

    header("Location: login.php");
    exit();
}

// recibimos el mensaje de la URL, si no existe lo dejamos vacío
$mensaje = $_GET["mensaje"] ?? "";
//Controlamos a donde vamos a direccionar la vista y que se marque el menú lateral dependiendo de la página en la que nos encontremos
$contenido = "citas/index.php";
$pagina = "citas";
$titulo = "Citas";
//Incluimos las partes de la plantilla
require "layouts/header.php";
require "layouts/main.php";
require "layouts/footer.php";