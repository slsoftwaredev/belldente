<?php
// Iniciamos la sesión para controlar el acceso a la página
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

// CONTROL DE VISTA
$id_paciente = isset($_GET["id_paciente"]) ? intval($_GET["id_paciente"]) : 0;

// Página activa del sidebar
$pagina = "historias";

// Si recibimos un paciente,
// mostramos su historia clínica
if ($id_paciente > 0) {
    $contenido = "historias/historia.php";
    $titulo = "Historia Clínica";
} else {
    $contenido = "historias/index.php";
    $titulo = "Historias Clínicas";
}

// PLANTILLA
require "layouts/header.php";
require "layouts/main.php";
require "layouts/footer.php";