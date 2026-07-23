<div class="bg-white rounded-xl shadow">

    <?php

    if(!isset($_GET["modulo"])){

        require "inicio.php";

    }else{

        switch($_GET["modulo"]){

            case "cie10":
                require "cie10.php";
                break;

            case "procedimientos":
                require "procedimientos.php";
                break;

            default:
                require "inicio.php";
                break;
        }

    }

    ?>

</div>