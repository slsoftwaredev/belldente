<!-- Prótesis removible -->
<?php
$numero = $numero ?? 0;
?>

<!-- =========================================
     PRÓTESIS REMOVIBLE INDICADA
     (────────)
     ROJO
========================================= -->

<template x-if="hasProtesis(<?= $numero ?>,'protesis_removible_indicada')">

    <div class="absolute inset-0 pointer-events-none">

        <!-- Línea -->
        <div
            class="absolute top-1/2 left-0
                   w-full h-0.5 bg-red-600">
        </div>

        <!-- Paréntesis de inicio -->
        <span
            x-show="esInicioProtesis(<?= $numero ?>,'protesis_removible_indicada')"
            class="absolute left-0 top-1/2
                   -translate-y-1/2
                   text-red-600 text-3xl font-bold leading-none">
            (
        </span>

        <!-- Paréntesis final -->
        <span
            x-show="esFinProtesis(<?= $numero ?>,'protesis_removible_indicada')"
            class="absolute right-0 top-1/2
                   -translate-y-1/2
                   text-red-600 text-3xl font-bold leading-none">
            )
        </span>

    </div>

</template>


<!-- =========================================
     PRÓTESIS REMOVIBLE REALIZADA
     (────────)
     AZUL
========================================= -->

<template x-if="hasProtesis(<?= $numero ?>,'protesis_removible_realizada')">

    <div class="absolute inset-0 pointer-events-none">

        <!-- Línea -->
        <div
            class="absolute top-1/2 left-0
                   w-full h-0.5 bg-blue-600">
        </div>

        <!-- Paréntesis de inicio -->
        <span
            x-show="esInicioProtesis(<?= $numero ?>,'protesis_removible_realizada')"
            class="absolute left-0 top-1/2
                   -translate-y-1/2
                   text-blue-600 text-3xl font-bold leading-none">
            (
        </span>

        <!-- Paréntesis final -->
        <span
            x-show="esFinProtesis(<?= $numero ?>,'protesis_removible_realizada')"
            class="absolute right-0 top-1/2
                   -translate-y-1/2
                   text-blue-600 text-3xl font-bold leading-none">
            )
        </span>

    </div>

</template>