<?php 
$id_cita = isset($_GET["id_cita"]) ? intval($_GET["id_cita"]) : 0;
?>
<input type="hidden" id="id_cita" value="<?= $id_cita ?>">
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
                <button id="btnGenerarConsentimiento" class="px-5 py-3 rounded-xl bg-orange-600 hover:bg-orange-700 text-white">
                            Generar Consentimiento
                </button>

                <button id="btnCancelar" class="px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">
                            Cancelar
                </button>

                <button id="btnFinalizar" class="px-5 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white">
                            Finalizar
                </button>
        </div>
    </div>
</div>

    <!-- PESTAÑAS -->
<div class="bg-white rounded-2xl shadow-sm p-2 overflow-x-auto">
    <div class="flex flex-col sm:flex-row gap-2 min-w-max">
        <button @click="tab='datos'":class="tab==='datos' ? 'bg-blue-600 text-white' : 'hover:bg-slate-100'" class="px-4 py-2 rounded-xl">
            Datos
        </button>

        <button @click="tab='antecedentes'" :class="tab==='antecedentes' ? 'bg-blue-600 text-white': 'hover:bg-slate-100'" class="px-4 py-2 rounded-xl">
            Antecedentes
        </button>

        <button @click="tab='examen'" :class="tab==='examen' ? 'bg-blue-600 text-white': 'hover:bg-slate-100'" class="px-4 py-2 rounded-xl">
            Examen
        </button>

        <button @click="tab='indicadores'":class="tab==='indicadores'? 'bg-blue-600 text-white': 'hover:bg-slate-100'" class="px-4 py-2 rounded-xl">
            Indicadores
        </button>

        <button @click="tab='odontograma'":class="tab==='odontograma'? 'bg-blue-600 text-white': 'hover:bg-slate-100'" class="px-4 py-2 rounded-xl">
            Odontograma
        </button>

        <button @click="tab='diagnostico'":class="tab==='diagnostico'? 'bg-blue-600 text-white': 'hover:bg-slate-100'"class="px-4 py-2 rounded-xl">
            Diagnóstico y Tratamiento
        </button>

        <button @click="tab='fotografias'":class="tab==='fotografias'? 'bg-blue-600 text-white': 'hover:bg-slate-100'"class="px-4 py-2 rounded-xl">
            Fotografías Clínicas
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

                <textarea id="observacion_personal" placeholder="Observaciones" class="w-full mt-5 border rounded-xl p-3"></textarea>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="font-semibold mb-5">
                Antecedentes Familiares
            </h2>
                <div class="space-y-3" id="antecedentes_familiares">
                </div>

                <textarea id="observacion_familiar"placeholder="Observaciones"class="w-full mt-5 border rounded-xl p-3"></textarea>
        </div>
    </div>
</div>

<!-- EXAMEN CLÍNICO -->
<div x-show="tab==='examen'" x-transition class="space-y-6">
    <!-- ===========================
         CONSTANTES VITALES
    ============================ -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-semibold mb-2">
            Constantes Vitales
        </h2>

        <p class="text-sm text-slate-500 mb-6">
            Registre los signos vitales del paciente.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
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
                <input type="number" id="pulso" class="w-full mt-2 border border-slate-300 rounded-xl p-3">
            </div>

            <div>
                <label class="text-sm font-medium">
                    Frecuencia Respiratoria (rpm)
                </label>
                <input type="number" id="frecuencia_respiratoria" class="w-full mt-2 border border-slate-300 rounded-xl p-3">
            </div>

            <div>
                <label class="text-sm font-medium">
                    Presión Arterial
                </label>
                <input type="text" placeholder="120/80" id="presion_arterial" class="w-full mt-2 border border-slate-300 rounded-xl p-3">
            </div>
        </div>
    </div>

    <!-- ===========================
         EXAMEN ESTOMATOGNÁTICO
    ============================ -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-semibold mb-2">
            Examen del Sistema Estomatognático
        </h2>

        <p class="text-sm text-slate-500 mb-6">
            Describa las alteraciones encontradas durante el examen.
        </p>

        <div id="examen_estomatognatico" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5"> </div>

    </div>

    <!-- ===========================
         PEDIDO DE EXÁMENES
         COMPLEMENTARIOS
    ============================ -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-semibold mb-2">
            Pedido de Exámenes Complementarios
        </h2>
        <p class="text-sm text-slate-500 mb-4">
            Registre los exámenes complementarios solicitados al paciente.
        </p>
        <textarea id="pedido_examen_complementario" rows="3" placeholder="Describa los exámenes complementarios solicitados..." class="w-full border border-slate-300 rounded-xl p-3 resize-none"></textarea>
    </div>

    <!-- ===========================
         INFORME DE EXÁMENES
    ============================ -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-semibold mb-2">
            Informe de Exámenes
        </h2>

        <p class="text-sm text-slate-500 mb-6">
            Seleccione el tipo de examen y registre los resultados.
        </p>

        <!-- TIPOS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
            <label class="flex items-center gap-3 border border-slate-300 rounded-xl p-4 cursor-pointer">
                <input type="checkbox" value="1" class="tipo-examen rounded border-slate-300">
                <span class="text-sm font-medium">
                    Biometría
                </span>
            </label>

            <label class="flex items-center gap-3 border border-slate-300 rounded-xl p-4 cursor-pointer">
                <input type="checkbox" value="2" class="tipo-examen rounded border-slate-300">
                <span class="text-sm font-medium">
                    Química Sanguínea
                </span>
            </label>

            <label class="flex items-center gap-3 border border-slate-300 rounded-xl p-4 cursor-pointer">
                <input type="checkbox" value="3" class="tipo-examen rounded border-slate-300">
                <span class="text-sm font-medium">
                    Rayos-X
                </span>
            </label>

            <label class="flex items-center gap-3 border border-slate-300 rounded-xl p-4 cursor-pointer">
                <input type="checkbox" value="7" class="tipo-examen rounded border-slate-300">
                <span class="text-sm font-medium">
                    Otros
                </span>
            </label>

        </div>

        <!-- RESULTADO -->
        <div>
            <label class="block text-sm font-medium mb-2">
                Informe / Resultado
            </label>

            <textarea id="informe_examen" rows="4" placeholder="Registre los resultados o informe de los exámenes..." class="w-full border border-slate-300 rounded-xl p-3 resize-none"></textarea>
        </div>
    </div>
</div>

<!-- INDICADORES DE SALUD BUCAL -->
<div x-show="tab==='indicadores'" x-transition>
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-semibold mb-2">
            Indicadores de Salud Bucal
        </h2>
        <p class="text-sm text-slate-500 mb-6">
            Registre la higiene oral simplificada y seleccione el estado
            correspondiente para cada indicador.
        </p>
        <!-- ==========================================
             HIGIENE ORAL SIMPLIFICADA
        =========================================== -->
        <div class="border border-sky-700 rounded-2xl overflow-hidden mb-8">
            <div class="bg-slate-50 px-5 py-4 border-b">
                <h3 class="font-semibold text-slate-800">
                    Higiene Oral Simplificada
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Seleccione la pieza examinada y registre placa, cálculo y gingivitis.
                </p>
            </div>

            <!-- ENCABEZADOS -->
            <div class="hidden md:grid md:grid-cols-12 gap-4 px-5 py-3 bg-slate-100 border-b">
                <div class="col-span-5 text-sm font-semibold">
                    Piezas dentales examinadas
                </div>
                <div class="col-span-2 text-sm font-semibold text-center">
                    Placa
                    <span class="block text-xs font-normal text-slate-500">
                        0 - 1 - 2 - 3
                    </span>
                </div>
                <div class="col-span-2 text-sm font-semibold text-center">
                    Cálculo
                    <span class="block text-xs font-normal text-slate-500">
                        0 - 1 - 2 - 3
                    </span>
                </div>
                <div class="col-span-3 text-sm font-semibold text-center">
                    Gingivitis
                    <span class="block text-xs font-normal text-slate-500">
                        0 - 1
                    </span>
                </div>
            </div>

            <!-- FILAS -->
            <div id="higieneOralSimplificada" class="divide-y">
                <!-- El JS generará las 6 filas -->
            </div>

            <!-- TOTALES -->
            <div class="grid grid-cols-12 gap-4 px-5 py-4 bg-slate-100">
                <div class="col-span-5 font-semibold">
                    Promedio
                </div>
                <div
                    id="promedioPlaca"
                    class="col-span-2 text-center font-semibold">
                    0.00
                </div>
                <div
                    id="promedioCalculo"
                    class="col-span-2 text-center font-semibold">
                    0.00
                </div>
                <div
                    id="promedioGingivitis"
                    class="col-span-3 text-center font-semibold">
                    0.00
                </div>
            </div>
        </div>
        <!-- ==========================================
             OTROS INDICADORES
        =========================================== -->
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
        <!-- Cargamos los diagnosticos del JS -->
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
                <!-- Se listan los tratamientos obtenidos en el JS -->
                <div id="listaTratamientos" class="space-y-4">
                </div>
    </div>
 <!-- ===========================
                COMPLICACIONES
    ============================ -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-semibold">Complicaciones</h2>
                        <p class="text-sm text-slate-500">Registre las complicaciones presentadas durante la atención.</p>
                    </div>
                    <button type="button" id="btnAgregarComplicacion" class=" bg-orange-600 hover:bg-orange-700 text-white px-5 py-3 rounded-xl"> + Agregar Complicación</button>
                </div>
                <div id="listaComplicaciones" class="space-y-4">
                    <div class=" complicacion border rounded-2xl p-5 border-sky-700 bg-slate-50">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                            <div class="lg:col-span-10">
                                <label class="block text-sm font-medium mb-2">Complicación</label>
                                <input placeholder="Ingrese la complicación" type="text" name="complicacion[]" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                            </div>
                            <div class="lg:col-span-2">
                            <button type="button" class="btnEliminarComplicacion w-full bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-xl">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!-- ===========================
        PRESCRIPCIÓN
=========================== -->
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
            <div class="medicamento border border-sky-700 rounded-2xl p-5 bg-slate-50">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                    <div class="lg:col-span-3">
                        <label class="block text-sm font-medium mb-2">
                            Medicamento
                        </label>
                        <input type="text" name="medicamento[]" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium mb-2">
                            Dosis
                        </label>

                        <input type="text" name="dosis[]" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium mb-2">
                            Frecuencia
                        </label>

                        <input type="text" name="frecuencia[]" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium mb-2">
                            Duración
                        </label>

                        <input type="text" name="duracion[]" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div class="lg:col-span-3">
                        <label class="block text-sm font-medium mb-2">
                            Indicaciones
                        </label>

                        <input type="text" name="indicaciones[]"class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>
                </div>

                <div class="mt-5">
                    <button type="button" class="btnEliminarMedicamento bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl">
                        Eliminar
                    </button>
                </div> <!-- Fin Boton eliminar -->
            </div> <!-- Fin medicamento -->
        </div> <!-- Fin lista medicamento -->
    </div> <!-- Fin BG.WHITE -->
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
            <button type="button" id="btnAgregarFotografia" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl">
                + Agregar Fotografía
            </button>

        </div>
        <!-- AQUÍ SE LISTAN LAS FOTOGRAFÍAS -->
        <div id="listaFotografias" class="space-y-5">
            <div class="fotografia border border-sky-700 rounded-2xl p-5 bg-slate-50">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                    <!-- OBSERVACIÓN -->
                    <div class="lg:col-span-6">
                        <label class="block text-sm font-medium mb-2">
                            Observación
                        </label>
                        <input type="text" name="observacion_fotografia[]" placeholder="Ej. Estado inicial de la pieza 16" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>
                    <!-- ARCHIVO -->
                    <div class="lg:col-span-6">
                        <label class="block text-sm font-medium mb-2">
                            Fotografía
                        </label>
                        <input type="file" name="fotografia[]" accept="image/*" class="w-full border border-slate-300 rounded-xl px-4 py-3">
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
</div> <!-- FIN X-DATA -->

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
</div> <!-- FIN Modal resumen -->

<!--
Modal para datos adicionales de Consentimiento informao
-->
<div id="modalConsentimiento" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="bg-white w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-xl">
        <!-- HEADER -->
        <div class="flex items-center justify-between px-6 py-4 border-b bg-blue-600">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    Generar Consentimiento Informado
                </h2>

                <p class="text-sm text-white mt-1">
                    Complete la información correspondiente al procedimiento.
                </p>
            </div>
            <button type="button" id="btnCerrarConsentimiento"class="text-gray-400 hover:text-red-600 text-2xl">
                &times;
            </button>
        </div>

        <!-- BODY -->
        <div class="p-6 space-y-6">
            <!-- DURACIÓN -->
            <div>
                <label for="consentimientoDuracion" class="block text-sm font-medium text-gray-700 mb-2">
                    Duración del procedimiento
                </label>
                <input type="text" id="consentimientoDuracion" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ej. 60 minutos">
            </div>

            <!-- BENEFICIOS -->
            <div>
                <label for="consentimientoBeneficios" class="block text-sm font-medium text-gray-700 mb-2">
                    Beneficios del procedimiento
                </label>

                <textarea id="consentimientoBeneficios" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describa los beneficios esperados del procedimiento...">
                </textarea>
            </div>

            <!-- RIESGOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="consentimientoRiesgosFrecuentes" class="block text-sm font-medium text-gray-700 mb-2">
                        Riesgos frecuentes y poco graves
                    </label>

                    <textarea id="consentimientoRiesgosFrecuentes" rows="4" class="w-full rounded-xl border border-gray-300 px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describa los riesgos frecuentes...">
                    </textarea>
                </div>

                <div>
                    <label for="consentimientoRiesgosGraves" class="block text-sm font-medium text-gray-700 mb-2">
                        Riesgos poco frecuentes y graves
                    </label>

                    <textarea id="consentimientoRiesgosGraves" rows="4" class="w-full rounded-xl border border-gray-300 px-4 py-3
                               focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describa los riesgos graves...">
                    </textarea>
                </div>
            </div>

            <!-- OTROS RIESGOS -->
            <div>
                <label for="consentimientoOtrosRiesgos" class="block text-sm font-medium text-gray-700 mb-2">
                    Otros riesgos
                </label>

                <textarea id="consentimientoOtrosRiesgos" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Indique otros riesgos, si existen...">
                </textarea>
            </div>

            <!-- ALTERNATIVAS -->
            <div>
                <label for="consentimientoAlternativas" class="block text-sm font-medium text-gray-700 mb-2">
                    Alternativas al procedimiento
                </label>

                <textarea id="consentimientoAlternativas" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describa las alternativas disponibles...">
                </textarea>
            </div>

            <!-- MANEJO POSTERIOR -->
            <div>
                <label for="consentimientoManejoPosterior" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción del manejo posterior al procedimiento
                </label>

                <textarea id="consentimientoManejoPosterior" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Indique los cuidados y manejo posterior...">
                </textarea>
            </div>

            <!-- CONSECUENCIAS -->
            <div>
                <label for="consentimientoConsecuencias" class="block text-sm font-medium text-gray-700 mb-2">
                    Consecuencias posibles si no se realiza el procedimiento
                </label>

                <textarea id="consentimientoConsecuencias" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describa las posibles consecuencias...">
                </textarea>
            </div>

            <!-- =====================================================
                 REPRESENTANTE LEGAL
            ====================================================== -->
            <div class="border-t pt-6">
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-800">
                        Representante legal
                    </h3>

                    <p class="text-sm text-gray-500">
                        Complete estos datos únicamente cuando corresponda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- NOMBRE -->
                    <div>
                        <label for="consentimientoRepresentante" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre completo
                        </label>

                        <input type="text" id="consentimientoRepresentante" class="w-full rounded-xl border border-gray-300 px-4 py-2.5
                                   focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nombre del representante">
                    </div>

                    <!-- PARENTESCO -->
                    <div>
                        <label for="consentimientoParentesco" class="block text-sm font-medium text-gray-700 mb-2">
                            Parentesco
                        </label>

                        <input type="text" id="consentimientoParentesco" class="w-full rounded-xl border border-gray-300 px-4 py-2.5
                                   focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ej. Padre, madre...">
                    </div>


                    <!-- CÉDULA -->
                    <div>
                        <label for="consentimientoCedulaRepresentante" class="block text-sm font-medium text-gray-700 mb-2">
                            C.I.
                        </label>

                        <input type="text" id="consentimientoCedulaRepresentante" maxlength="10" class="w-full rounded-xl border border-gray-300 px-4 py-2.5
                                   focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cédula">
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50 rounded-b-2xl">
            <button type="button" id="btnCancelarConsentimiento" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100">
                Cancelar
            </button>

            <button type="button" id="btnGenerarPdfConsentimiento" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                Generar Consentimiento
            </button>
        </div>
    </div>
</div> <!--FIN MODAL  -->

<script src="/public/js/odontograma.js"></script>
<script src="/public/js/atencion.js"></script>