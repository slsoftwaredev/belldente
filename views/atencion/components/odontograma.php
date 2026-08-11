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

            Dentición Permanente

        </button>

        <button
            @click="denticion='temporal'"
            :class="denticion==='temporal'
                ? 'bg-blue-600 text-white'
                : 'bg-white text-slate-700 hover:bg-slate-100'"
            class="px-5 py-2 font-medium border-l border-slate-300 transition">

            Dentición Temporal

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


<!-- ==========================================
     ÍNDICES CPOD / ceod
=========================================== -->

<div class="border border-slate-300 rounded-lg overflow-hidden">

    <div class="bg-slate-100 px-4 py-3 border-b border-slate-300">

        <h3 class="font-semibold text-slate-800">
            Índices de Caries
        </h3>

    </div>

    <div class="p-4 grid grid-cols-1 lg:grid-cols-2 gap-6 bg-slate-200">

        <!-- CPOD -->
        <div>

            <h4 class="font-semibold text-slate-700 mb-3">
                Dentición Permanente - CPOD
            </h4>

            <div class="grid grid-cols-4 gap-2 text-center">

                <div class="border rounded-lg p-3">
                    <p class="text-xs text-slate-500">Cariados</p>

                    <p
                        class="text-xl font-bold"
                        x-text="calcularCPOD().C">
                    </p>

                    <span class="text-xs font-semibold">C</span>
                </div>

                <div class="border rounded-lg p-3">
                    <p class="text-xs text-slate-500">Perdidos</p>

                    <p
                        class="text-xl font-bold"
                        x-text="calcularCPOD().P">
                    </p>

                    <span class="text-xs font-semibold">P</span>
                </div>

                <div class="border rounded-lg p-3">
                    <p class="text-xs text-slate-500">Obturados</p>

                    <p
                        class="text-xl font-bold"
                        x-text="calcularCPOD().O">
                    </p>

                    <span class="text-xs font-semibold">O</span>
                </div>

                <div class="border rounded-lg p-3 bg-blue-50">
                    <p class="text-xs text-slate-500">Total</p>

                    <p
                        class="text-xl font-bold text-blue-700"
                        x-text="calcularCPOD().total">
                    </p>

                    <span class="text-xs font-semibold">CPOD</span>
                </div>

            </div>

        </div>


        <!-- ceod -->
        <div>

            <h4 class="font-semibold text-slate-700 mb-3">
                Dentición Temporal - ceod
            </h4>

            <div class="grid grid-cols-4 gap-2 text-center">

                <div class="border rounded-lg p-3">
                    <p class="text-xs text-slate-500">Cariados</p>

                    <p
                        class="text-xl font-bold"
                        x-text="calcularCEOD().c">
                    </p>

                    <span class="text-xs font-semibold">c</span>
                </div>

                <div class="border rounded-lg p-3">
                    <p class="text-xs text-slate-500">Extracción</p>

                    <p
                        class="text-xl font-bold"
                        x-text="calcularCEOD().e">
                    </p>

                    <span class="text-xs font-semibold">e</span>
                </div>

                <div class="border rounded-lg p-3">
                    <p class="text-xs text-slate-500">Obturados</p>

                    <p
                        class="text-xl font-bold"
                        x-text="calcularCEOD().o">
                    </p>

                    <span class="text-xs font-semibold">o</span>
                </div>

                <div class="border rounded-lg p-3 bg-blue-50">
                    <p class="text-xs text-slate-500">Total</p>

                    <p
                        class="text-xl font-bold text-blue-700"
                        x-text="calcularCEOD().total">
                    </p>

                    <span class="text-xs font-semibold">ceod</span>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- Procedimientos -->
<?php require __DIR__ . '/procedimientos.php'; ?>