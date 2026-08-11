<!-- Sellante -->
<?php
    $numero = $numero ?? 0;
?>

<!-- Sellante necesario -->
<template x-if="hasSymbol(<?= $numero ?>,'sellante_necesario')">

    <div class="absolute inset-0 flex items-center justify-center">

        <span class="text-red-600 text-2xl font-bold leading-none">
            *
        </span>

    </div>

</template>


<!-- Sellante realizado -->
<template x-if="hasSymbol(<?= $numero ?>,'sellante_realizado')">

    <div class="absolute inset-0 flex items-center justify-center">

        <span class="text-blue-600 text-2xl font-bold leading-none">
            *
        </span>

    </div>

</template>