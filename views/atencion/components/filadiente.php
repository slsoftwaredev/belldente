<?php 
$grupo = $grupo ?? []; // Aseguramos que $grupo sea un array, incluso si no está definido
?>
<div class="flex gap-3">
<?php foreach($grupo as $numero): ?>

    <?php include "diente.php"; ?>

<?php endforeach; ?>
</div>