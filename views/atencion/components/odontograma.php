<div
    x-data="odontograma()"
    class="space-y-8">
<!-- Barra de herramientas de odontograma -->
    <?php require __DIR__ . '/toolbar.php'; ?>
<!-- Seleccionar odontograma: adulto o niño -->
    <div class="flex justify-center mb-6">
    <div class="inline-flex rounded-lg border border-slate-300 overflow-hidden shadow-sm">

        <button
            @click="denticion='permanente'"
            :class="denticion==='permanente'
                ? 'bg-blue-600 text-white'
                : 'bg-white text-slate-700 hover:bg-slate-100'"
            class="px-5 py-2 font-medium transition">

            Odontograma Adulto

        </button>

        <button
            @click="denticion='temporal'"
            :class="denticion==='temporal'
                ? 'bg-blue-600 text-white'
                : 'bg-white text-slate-700 hover:bg-slate-100'"
            class="px-5 py-2 font-medium border-l border-slate-300 transition">

            OdontogramaInfantil

        </button>

    </div>
</div>
<!-- Odontograma adulto -->
    <div x-show="denticion==='permanente'" class="space-y-8">

        <div class="flex justify-center gap-4">

            <?php

            $grupo=[18,17,16,15,14,13,12,11];
                require __DIR__ . '/filadiente.php';

            ?>

            <div class="w-12"></div>

            <?php

            $grupo=[21,22,23,24,25,26,27,28];
                require __DIR__ . '/filadiente.php';

            ?>
        </div>

        <div class="flex justify-center gap-4">

            <?php

            $grupo=[48,47,46,45,44,43,42,41];

                require __DIR__ . '/filadiente.php';

            ?>

            <div class="w-12"></div>

            <?php

            $grupo=[31,32,33,34,35,36,37,38];
                require __DIR__ . '/filadiente.php';
            ?>

        </div>

    </div>
<!-- Odontograma infantil -->
 <div x-show="denticion==='temporal'" class="space-y-8">

    <div class="flex justify-center gap-4">

        <?php
        $grupo = [55,54,53,52,51];
        require __DIR__ . '/filadiente.php';
        ?>

        <div class="w-12"></div>

        <?php
        $grupo = [61,62,63,64,65];
        require __DIR__ . '/filadiente.php';
        ?>

    </div>

    <div class="flex justify-center gap-4">

        <?php
        $grupo = [85,84,83,82,81];
        require __DIR__ . '/filadiente.php';
        ?>

        <div class="w-12"></div>

        <?php
        $grupo = [71,72,73,74,75];
        require __DIR__ . '/filadiente.php';
        ?>

    </div>
        
    </div>
    <?php require __DIR__ . '/procedimientos.php'; ?>

</div>

