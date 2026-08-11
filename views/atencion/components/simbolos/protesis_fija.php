<!-- Prótesis fija -->
<?php
$numero = $numero ?? 0;
?>

<!-- =========================================
     PRÓTESIS FIJA INDICADA
     ■────────■
     ROJO
========================================= -->

<template x-if="hasProtesis(<?= $numero ?>,'protesis_fija_indicada')">

    <div class="absolute inset-0 pointer-events-none">

        <!-- Línea que atraviesa las piezas -->
        <div
            class="absolute top-1/2 left-0
                   w-full h-0.5 bg-red-600">
        </div>

        <!-- Cuadrado de inicio -->
        <div
            x-show="esInicioProtesis(<?= $numero ?>,'protesis_fija_indicada')"
            class="absolute
                   top-1/2 left-0
                   -translate-y-1/2
                   w-3 h-3
                   bg-red-600">
        </div>

        <!-- Cuadrado final -->
        <div
            x-show="esFinProtesis(<?= $numero ?>,'protesis_fija_indicada')"
            class="absolute
                   top-1/2 right-0
                   -translate-y-1/2
                   w-3 h-3
                   bg-red-600">
        </div>

    </div>

</template>


<!-- =========================================
     PRÓTESIS FIJA REALIZADA
     ■────────■
     AZUL
========================================= -->

<template x-if="hasProtesis(<?= $numero ?>,'protesis_fija_realizada')">

    <div class="absolute inset-0 pointer-events-none">

        <!-- Línea -->
        <div
            class="absolute top-1/2 left-0
                   w-full h-0.5 bg-blue-600">
        </div>

        <!-- Cuadrado de inicio -->
        <div
            x-show="esInicioProtesis(<?= $numero ?>,'protesis_fija_realizada')"
            class="absolute
                   top-1/2 left-0
                   -translate-y-1/2
                   w-3 h-3
                   bg-blue-600">
        </div>

        <!-- Cuadrado final -->
        <div
            x-show="esFinProtesis(<?= $numero ?>,'protesis_fija_realizada')"
            class="absolute
                   top-1/2 right-0
                   -translate-y-1/2
                   w-3 h-3
                   bg-blue-600">
        </div>

    </div>

</template>