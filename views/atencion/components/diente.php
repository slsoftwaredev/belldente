<?php
$numero = $numero ?? 0;
?>

<div class="flex flex-col items-center select-none">

    <!-- Número de pieza -->
    <span class="text-xs font-semibold text-slate-700 mb-1">
        <?= $numero ?>
    </span>

    <!-- Diente -->
    <div class="relative w-12 h-12">

        <!-- Cara superior -->
        <div
            @click="paint(<?= $numero ?>,'superior')"
            :class="surfaceClass(<?= $numero ?>,'superior')"
            class="absolute top-0 left-1/2 -translate-x-1/2
                   w-6 h-3 border border-slate-500 rounded-t
                   cursor-pointer transition hover:scale-110">
        </div>

        <!-- Cara izquierda -->
        <div
            @click="paint(<?= $numero ?>,'izquierda')"
            :class="surfaceClass(<?= $numero ?>,'izquierda')"
            class="absolute top-3 left-0
                   w-3 h-6 border border-slate-500 rounded-l
                   cursor-pointer transition hover:scale-110">
        </div>

        <!-- Cara central -->
        <div
            @click="paint(<?= $numero ?>,'oclusal')"
            :class="surfaceClass(<?= $numero ?>,'oclusal')"
            class="absolute top-3 left-3
                   w-6 h-6 border border-slate-500
                   cursor-pointer transition hover:scale-110">
        </div>

        <!-- Cara derecha -->
        <div
            @click="paint(<?= $numero ?>,'derecha')"
            :class="surfaceClass(<?= $numero ?>,'derecha')"
            class="absolute top-3 right-0
                   w-3 h-6 border border-slate-500 rounded-r
                   cursor-pointer transition hover:scale-110">
        </div>

        <!-- Cara inferior -->
        <div
            @click="paint(<?= $numero ?>,'inferior')"
            :class="surfaceClass(<?= $numero ?>,'inferior')"
            class="absolute bottom-0 left-1/2 -translate-x-1/2
                   w-6 h-3 border border-slate-500 rounded-b
                   cursor-pointer transition hover:scale-110">
        </div>
        <?php require 'simbolos.php'; ?>
    </div>

</div>