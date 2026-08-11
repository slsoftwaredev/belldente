<!-- Endodoncia -->
<?php
    $numero = $numero ?? 0;
?>

<!-- Endodoncia por realizar -->
<template x-if="hasSymbol(<?= $numero ?>,'endodoncia_requerida')">

    <div class="absolute inset-0 flex items-center justify-center">

        <div
            class="w-0 h-0
                border-l-[8px] border-l-transparent
                border-r-[8px] border-r-transparent
                border-b-[14px] border-b-red-600">
        </div>

    </div>

</template>


<!-- Endodoncia realizada -->
<template x-if="hasSymbol(<?= $numero ?>,'endodoncia_realizada')">

    <div class="absolute inset-0 flex items-center justify-center">

        <div
            class="w-0 h-0
                border-l-[8px] border-l-transparent
                border-r-[8px] border-r-transparent
                border-b-[14px] border-b-blue-600">
        </div>

    </div>

</template>