<?php
$numero = $numero ?? 0;
?>

<!-- =========================================
     PRÓTESIS TOTAL INDICADA
     =
     ROJO
========================================= -->

<template x-if="hasProtesis(<?= $numero ?>,'protesis_total_indicada')">

    <div class="absolute inset-0 pointer-events-none">

        <!-- Primera línea -->
        <div
            class="absolute top-[44%] left-0
                   w-full h-0.5 bg-red-600">
        </div>

        <!-- Segunda línea -->
        <div
            class="absolute top-[56%] left-0
                   w-full h-0.5 bg-red-600">
        </div>

    </div>

</template>


<!-- =========================================
     PRÓTESIS TOTAL REALIZADA
     =
     AZUL
========================================= -->

<template x-if="hasProtesis(<?= $numero ?>,'protesis_total_realizada')">

    <div class="absolute inset-0 pointer-events-none">

        <!-- Primera línea -->
        <div
            class="absolute top-[44%] left-0
                   w-full h-0.5 bg-blue-600">
        </div>

        <!-- Segunda línea -->
        <div
            class="absolute top-[56%] left-0
                   w-full h-0.5 bg-blue-600">
        </div>

    </div>

</template>