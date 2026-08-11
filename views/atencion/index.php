<?php 
$id_cita = isset($_GET["id_cita"]) ? intval($_GET["id_cita"]) : 0;
?>

<input
    type="hidden"
    id="id_cita"
    value="<?= $id_cita ?>">

<div x-data="{ tab:'datos' }" class="w-full max-w-7xl mx-auto space-y-6">
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
                        id="btnFinalizar"
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

            Diagnóstico y Tratamiento

        </button>

        <button
            @click="tab='fotografias'"
            :class="tab==='fotografias'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Fotografías Clínicas

        </button>

        <button
            @click="tab='prescripcion'"
            :class="tab==='prescripcion'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Prescripciones Médicas

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


<!-- ===========================
        DIAGNÓSTICO
=========================== -->

<div x-show="tab==='diagnostico'" x-transition class="space-y-6">
    <!-- ===========================
            DIAGNÓSTICOS
    ============================ -->
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>

                <h2 class="text-xl font-semibold">

                    Diagnósticos CIE-10

                </h2>

                <p class="text-sm text-slate-500">

                    Registre uno o varios diagnósticos para esta atención.

                </p>

            </div>

            <button type="button" id="btnAgregarDiagnostico"class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl">
                + Agregar Diagnóstico
            </button>

        </div>

        <!-- AQUÍ EL JS AGREGARÁ LOS DIAGNÓSTICOS -->

        <div id="listaDiagnosticos" class="space-y-4">
        </div>

    </div>

    <!-- ===========================
                TRATAMIENTOS
    ============================ -->

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                <div>

                    <h2 class="text-xl font-semibold">
                            Tratamientos
                    </h2>
                    <p class="text-sm text-slate-500">
                            Seleccione los tratamientos que se realizarán.
                    </p>
                </div>
                <button type="button" id="btnAgregarTratamiento"class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">
                        + Agregar Tratamiento
                </button>
            </div>
                <!-- AQUÍ EL JS AGREGARÁ LOS TRATAMIENTOS -->
                <div id="listaTratamientos" class="space-y-4">
                </div>
    </div>
</div>

<!-- ===========================
        FOTOGRAFÍAS CLÍNICAS
=========================== -->

<div x-show="tab==='fotografias'" x-transition class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold">
                    Fotografías Clínicas
                </h2>

                <p class="text-sm text-slate-500">
                    Adjunte las fotografías correspondientes a la atención.
                </p>
            </div>

            <button type="button" id="btnAgregarFotografia" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">
                + Agregar Fotografía
            </button>

        </div>
        <!--Aquí se listan las fotografias -->
        <div id="listaFotografias" class="space-y-5">
            <div class="fotografia border rounded-2xl p-5 bg-slate-50">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                    <div class="lg:col-span-3">
                        <label class="block text-sm font-medium mb-2">
                            Tipo
                        </label>
                        <select
                            name="tipo_fotografia[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                            <option value="">Seleccione...</option>
                            <option value="Antes">Antes</option>
                            <option value="Durante">Durante</option>
                            <option value="Después">Después</option>
                            <option value="Radiografía">Radiografía</option>
                            <option value="Intraoral">Intraoral</option>
                            <option value="Extraoral">Extraoral</option>
                            <option value="Control">Control</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="lg:col-span-5">
                        <label class="block text-sm font-medium mb-2">
                            Observación
                        </label>

                        <input
                            type="text"
                            name="observacion_fotografia[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>

                    <div class="lg:col-span-4">
                        <label class="block text-sm font-medium mb-2">
                            Fotografía
                        </label>

                        <input
                            type="file"
                            name="fotografia[]"
                            accept="image/*"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>
                </div>
                <div class="mt-5">

                    <button type="button" class="btnEliminarFotografia bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===========================
        PRESCRIPCIÓN
=========================== -->

<div x-show="tab==='prescripcion'" x-transition class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold">
                    Prescripción Médica
                </h2>

                <p class="text-sm text-slate-500">
                    Registre los medicamentos prescritos.
                </p>
            </div>
            <button type="button" id="btnAgregarMedicamento" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl">
                + Agregar Medicamento
            </button>
        </div>
        <div id="listaMedicamentos" class="space-y-5">
            <div class="medicamento border rounded-2xl p-5 bg-slate-50">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                    <div class="lg:col-span-3">
                        <label class="block text-sm font-medium mb-2">
                            Medicamento
                        </label>

                        <input
                            type="text"
                            name="medicamento[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium mb-2">
                            Dosis
                        </label>

                        <input
                            type="text"
                            name="dosis[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium mb-2">
                            Frecuencia
                        </label>

                        <input
                            type="text"
                            name="frecuencia[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium mb-2">
                            Duración
                        </label>

                        <input
                            type="text"
                            name="duracion[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div class="lg:col-span-3">
                        <label class="block text-sm font-medium mb-2">
                            Indicaciones
                        </label>

                        <input
                            type="text"
                            name="indicaciones[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>
                </div>

                <div class="mt-5">
                    <button type="button" class="btnEliminarMedicamento bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>

</div>
<!-- ==========================================
        MODAL RESUMEN DE ATENCIÓN
========================================== -->

<div id="modalResumen" class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-3xl w-full max-w-5xl max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="bg-blue-600 px-6 py-5 flex justify-between items-center rounded-t-3xl">
            <div>
                <h2 class="text-2xl font-bold text-white">
                    Resumen de la Atención
                </h2>
                <p class="text-blue-100">
                    Revise la información antes de finalizar.
                </p>
            </div>
            <button type="button" id="btnCerrarResumen" class="text-3xl text-white hover:text-red-300">
                ×
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Diagnósticos -->
                <div class="border rounded-2xl p-5">
                    <h3 class="font-semibold text-blue-700 mb-4">
                        Diagnósticos
                    </h3>
                    <div id="resumenDiagnosticos" class="space-y-2">
                    </div>
                </div>

                <!-- Tratamientos -->
                <div class="border rounded-2xl p-5">
                    <h3 class="font-semibold text-green-700 mb-4">
                        Tratamientos
                    </h3>

                    <div id="resumenTratamientos" class="space-y-2">
                    </div>
                </div>

                <!-- Fotografías -->
                <div class="border rounded-2xl p-5">
                    <h3 class="font-semibold text-purple-700 mb-4">
                        Fotografías Clínicas
                    </h3>
                    <div id="resumenFotografias">
                    </div>
                </div>

                <!-- Medicamentos -->
                <div class="border rounded-2xl p-5">
                    <h3 class="font-semibold text-red-700 mb-4">
                        Prescripción Médica
                    </h3>
                    <div id="resumenMedicamentos">
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="border-2 border-green-500 rounded-2xl p-6 bg-green-50">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-semibold">
                        Total Tratamientos
                    </span>

                    <span id="lblTotalTratamientos" class="text-4xl font-bold text-green-700">
                        $0.00
                    </span>
                </div>
            </div>
        </div>

        <!-- Footer -->

        <div class="px-6 py-5 flex justify-end gap-4 border-t">
            <button type="button" id="btnCancelarResumen" class="px-5 py-3 border rounded-xl hover:bg-slate-100">
                Regresar
            </button>

            <button type="button" id="btnConfirmarAtencion" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl">
                Confirmar Atención
            </button>
        </div>
    </div>
</div>

<script src="/public/js/odontograma.js"></script>
<script src="/public/js/atencion.js"></script>