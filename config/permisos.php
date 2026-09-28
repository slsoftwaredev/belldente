<?php

// Verifica si el usuario tiene permiso para acceder a un módulo
function tienePermiso($modulo){

    $permisos = $_SESSION["permisos"] ?? [];

    return in_array($modulo, $permisos, true);
}


// Protege el acceso directo a los módulos
function verificarPermiso($modulo){

    if(!tienePermiso($modulo)){

        http_response_code(403);

        echo "
        <div style='
            font-family: Arial, sans-serif;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            background:#f8fafc;
        '>
            <div style='text-align:center;'>
                <h1 style='font-size:48px;margin:0;color:#dc2626;'>
                    403
                </h1>

                <h2>Acceso denegado</h2>

                <p>No tiene permisos para acceder a este módulo.</p>

                <a href='escritorio.php'>
                    Volver al sistema
                </a>
            </div>
        </div>
        ";

        exit();
    }
}