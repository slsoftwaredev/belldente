<?php
$numero = $numero ?? 0; // Aseguramos que $numero tenga un valor predeterminado si no está definido
?>
<div class="flex flex-col items-center">

    <span class="text-xs font-semibold mb-1">
        <?= $numero ?>
    </span>

    <div class="w-8 h-8 border border-slate-700 bg-white">

    </div>

</div>