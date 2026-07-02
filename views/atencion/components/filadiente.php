<?php 
$grupo = $grupo ?? []; // Aseguramos que $grupo sea un array, incluso si no está definido
foreach($grupo as $numero): ?>

    <?php include "diente.php"; ?>

<?php endforeach; ?>