<?php 
$id_cita = isset($_GET["id_cita"]) ? intval($_GET["id_cita"]) : 0;
?>

<input
    type="hidden"
    id="id_cita"
    value="<?= $id_cita ?>">

<div
    x-data="{ tab:'datos' }"
    class="w-full max-w-7xl mx-auto space-y-6">

    <!-- CABECERA -->
<div class="bg-white rounded-2xl shadow-sm p-6">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between ">

        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                Atención Clínica
            </h1>

            <p class="text-slate-500">
                Historia clínica odontológica
            </p>

        </div>

        <div class="flex flex-col sm:flex-row gap-3">

            <button
                id="btnCancelar"
                class="px-5 py-3 rounded-xl bg-blue-600 text-white">

                Cancelar

            </button>

            <button
                class="px-5 py-3 rounded-xl bg-green-600 text-white">

                Finalizar

            </button>

        </div>

    </div>

</div>

    <!-- PESTAÑAS -->
<div class="bg-white rounded-2xl shadow-sm p-2 overflow-x-auto">

    <div class="flex flex-col sm:flex-row gap-2 min-w-max">

        <button
            @click="tab='datos'"
            :class="tab==='datos'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Datos

        </button>

        <button
            @click="tab='antecedentes'"
            :class="tab==='antecedentes'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Antecedentes

        </button>

        <button
            @click="tab='examen'"
            :class="tab==='examen'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Examen

        </button>
        <button
            @click="tab='indicadores'"
            :class="tab==='indicadores'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Indicadores

        </button>

        <button
            @click="tab='odontograma'"
            :class="tab==='odontograma'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Odontograma

        </button>

        <button
            @click="tab='diagnostico'"
            :class="tab==='diagnostico'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Diagnóstico

        </button>
    </div>

</div>

    <!-- CONTENIDO DE LAS PESTAÑAS -->
     <!-- DATOS -->
<div x-show="tab==='datos'" x-transition>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold text-slate-700 mb-4">
                Información del Paciente
            </h2>

            <div class="space-y-3 text-sm">

                <p>
                    <span class="font-medium">Paciente:</span>
                    <span id="paciente"></span>
                </p>

                <p>
                    <span class="font-medium">Cédula:</span>
                    <span id="cedula"></span>
                </p>

                <p>
                    <span class="font-medium">Fecha Nacimiento:</span>
                    <span id="fecha_nacimiento"></span>
                </p>

                <p>
                    <span class="font-medium">Edad:</span>
                    <span id="edad"></span> años
                </p>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold text-slate-700 mb-4">
                Contacto
            </h2>

            <div class="space-y-3 text-sm">

                <p>
                    <span class="font-medium">Teléfono:</span>
                    <span id="telefono"></span>
                </p>

                <p>
                    <span class="font-medium">Correo:</span>
                    <span id="correo"></span>
                </p>

                <p>
                    <span class="font-medium">Dirección:</span>
                    <span id="direccion"></span>
                </p>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold text-slate-700 mb-4">
                Atención
            </h2>

            <div class="space-y-3 text-sm">

                <p>
                    <span class="font-medium">Establecimiento:</span>
                    BellDente
                </p>

                <p>
                    <span class="font-medium">Fecha:</span>
                    <span id="fecha_cita"></span>
                </p>

                <p>
                    <span class="font-medium">Estado:</span>
                    <span id="estado_cita"></span>
                </p>

            </div>

        </div>

    </div>

</div>
        <!-- ANTECEDENTES -->
         <div x-show="tab==='antecedentes'" x-transition>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-5">
                Antecedentes Personales
            </h2>

            <div class="space-y-3" id="antecedentes_personales">
            </div>

            <textarea
                id="observacion_personal"
                placeholder="Observaciones"
                class="w-full mt-5 border rounded-xl p-3">
            </textarea>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-5">
                Antecedentes Familiares
            </h2>

            <div class="space-y-3" id="antecedentes_familiares">
            </div>

            <textarea
                id="observacion_familiar"
                placeholder="Observaciones"
                class="w-full mt-5 border rounded-xl p-3">
            </textarea>

        </div>
    </div>
</div>

            <!-- EXAMEN CLÍNICO -->
<div x-show="tab==='examen'" x-transition>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

    <h2 class="font-semibold mb-6">
        Constantes Vitales
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        <div>
            <label class="text-sm font-medium">
                Temperatura (°C)
            </label>

            <input
                type="number"
                step="0.1"
                id="temperatura"
                class="w-full mt-2 border border-slate-300 rounded-xl p-3">
        </div>

        <div>
            <label class="text-sm font-medium">
                Pulso (lpm)
            </label>

            <input
                type="number"
                id="pulso"
                class="w-full mt-2 border border-slate-300 rounded-xl p-3">
        </div>

        <div>
            <label class="text-sm font-medium">
                Frecuencia Respiratoria (rpm)
            </label>

            <input
                type="number"
                id="frecuencia_respiratoria"
                class="w-full mt-2 border border-slate-300 rounded-xl p-3">
        </div>

        <div>
            <label class="text-sm font-medium">
                Presión Arterial
            </label>

            <input
                type="text"
                placeholder="120/80"
                id="presion_arterial"
                class="w-full mt-2 border border-slate-300 rounded-xl p-3">
        </div>

    </div>

    </div>
        <!-- EXAMEN ESTOMATOGNÁTICO -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-6">
                Examen Estomatognático
            </h2>
            <div id="examen_estomatognatico" class="space-y-4">
        </div>
      </div>
   </div>
</div>

<!-- INDICADORES DE SALUD BUCAL -->
<div x-show="tab==='indicadores'" x-transition>

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="font-semibold mb-6">
            Indicadores de Salud Bucal
        </h2>
        <p class="text-sm text-slate-500 mb-6">
        Seleccione el estado correspondiente para cada indicador.
        </p>
        <div
            id="indicadores_salud"
            class="space-y-8">
        </div>

    </div>

</div>

            <!-- ODONTOGRAMA -->
             <div x-show="tab==='odontograma'" x-transition>

    <div class="bg-cyan-100 border-2 border-slate-600">
        <!-- Título -->

        <div class="bg-violet-200 border-b-2 border-slate-600 px-4 py-2">
            <h2 class="font-semibold mb-5">
                ODONTOGRAMA
            </h2>

        </div>
        <!-- Contenido -->
        <div class="p-4">
            <?php include "components/odontograma.php"; ?>  
        </div>
        

    </div>

</div>

<!-- DIAGNÓSTICO -->
<div x-show="tab==='diagnostico'" x-transition>
    <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-4">
                Diagnóstico
            </h2>
            <button class="px-4 py-2 rounded-xl bg-green-600 text-white mb-4">
                Agregar Diagnóstico
            </button>
            <select class="w-full border border-slate-300 rounded-xl px-4 py-3 mb-4">
                <option>Diagnóstico 1</option>
                <option>Diagnóstico 2</option>
                <option>Diagnóstico 3</option>
            </select>

            <label><input type="radio" name="diagnostico"> PREDICTIVO</label>
            <label><input type="radio" name="diagnostico"> DEFINITIVO</label>
</div>
</div>


<script src="/public/js/odontograma.js"></script>
<script src="/public/js/atencion.js"></script>