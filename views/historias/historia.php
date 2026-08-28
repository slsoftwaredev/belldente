<div class="space-y-6">

    <!-- ==========================================
         ENCABEZADO
    =========================================== -->
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-3xl font-bold text-slate-800">
                    Historia Clínica
                </h2>

                <p class="text-slate-500 mt-1">
                    Consulta del historial clínico del paciente.
                </p>
            </div>

            <button
                type="button"
                onclick="volverHistorias()"
                class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200
                       text-slate-700 font-medium rounded-xl transition"
            >
                ← Volver
            </button>

        </div>

    </div>


    <!-- ==========================================
         ESTADO DE CARGA
    =========================================== -->
    <div
        id="cargandoHistoria"
        class="bg-white rounded-2xl shadow-sm p-10 text-center"
    >
        <div class="text-slate-500">
            Cargando historia clínica...
        </div>
    </div>


    <!-- ==========================================
         CONTENIDO DE LA HISTORIA
    =========================================== -->
    <div id="contenidoHistoria" class="hidden space-y-6">


        <!-- ==========================================
             DATOS DEL PACIENTE
        =========================================== -->
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">

                <div>

                    <p class="text-sm font-medium text-blue-600">
                        Paciente
                    </p>

                    <h3
                        id="historiaNombrePaciente"
                        class="text-2xl font-bold text-slate-800 mt-1"
                    >
                        -
                    </h3>

                    <p class="text-slate-500 mt-1">
                        H.C.
                        <span
                            id="historiaCedulaPaciente"
                            class="font-semibold text-slate-700"
                        >
                            -
                        </span>
                    </p>

                </div>

                <div
                    id="historiaTotalAtenciones"
                    class="inline-flex px-4 py-2 rounded-xl
                           bg-blue-50 text-blue-700
                           text-sm font-semibold"
                >
                    0 atenciones
                </div>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mt-6 pt-6 border-t border-slate-200">

                <!-- FECHA DE NACIMIENTO -->
                <div>
                    <p class="text-xs uppercase font-semibold text-slate-400">
                        Fecha de nacimiento
                    </p>

                    <p
                        id="historiaFechaNacimiento"
                        class="text-slate-700 font-medium mt-1"
                    >
                        -
                    </p>
                </div>


                <!-- SEXO -->
                <div>
                    <p class="text-xs uppercase font-semibold text-slate-400">
                        Sexo
                    </p>

                    <p
                        id="historiaSexo"
                        class="text-slate-700 font-medium mt-1"
                    >
                        -
                    </p>
                </div>


                <!-- TELÉFONO -->
                <div>
                    <p class="text-xs uppercase font-semibold text-slate-400">
                        Teléfono
                    </p>

                    <p
                        id="historiaTelefono"
                        class="text-slate-700 font-medium mt-1"
                    >
                        -
                    </p>
                </div>


                <!-- CORREO -->
                <div>
                    <p class="text-xs uppercase font-semibold text-slate-400">
                        Correo
                    </p>

                    <p
                        id="historiaCorreo"
                        class="text-slate-700 font-medium mt-1 break-all"
                    >
                        -
                    </p>
                </div>

            </div>


            <!-- DIRECCIÓN -->
            <div class="mt-5">

                <p class="text-xs uppercase font-semibold text-slate-400">
                    Dirección
                </p>

                <p
                    id="historiaDireccion"
                    class="text-slate-700 font-medium mt-1"
                >
                    -
                </p>

            </div>

        </div>


        <!-- ==========================================
             ATENCIONES REALIZADAS
        =========================================== -->
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <div class="mb-5">

                <h3 class="text-xl font-bold text-slate-800">
                    Atenciones realizadas
                </h3>

                <p class="text-slate-500 text-sm mt-1">
                    Seleccione una atención para consultar su información clínica.
                </p>

            </div>


            <div
                id="historiaListaAtenciones"
                class="flex gap-3 overflow-x-auto pb-2"
            >
            </div>

        </div>


        <!-- ==========================================
             DETALLE DE LA ATENCIÓN
        =========================================== -->
        <div
            id="historiaDetalleAtencion"
            class="hidden space-y-6"
        >


            <!-- ==========================================
                 INFORMACIÓN DE LA ATENCIÓN
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                    <div>

                        <p class="text-sm font-medium text-blue-600">
                            Atención seleccionada
                        </p>

                        <h3
                            id="historiaFechaAtencion"
                            class="text-2xl font-bold text-slate-800 mt-1"
                        >
                            -
                        </h3>

                    </div>


                    <div class="lg:text-right">

                        <p class="text-xs uppercase font-semibold text-slate-400">
                            Profesional
                        </p>

                        <p
                            id="historiaProfesional"
                            class="text-slate-700 font-semibold mt-1"
                        >
                            -
                        </p>

                    </div>

                </div>

            </div>


            <!-- ==========================================
                 EXAMEN CLÍNICO
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Examen Clínico
                </h3>


                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                    <!-- TEMPERATURA -->
                    <div class="bg-slate-50 rounded-xl p-4">

                        <p class="text-sm text-slate-500">
                            Temperatura
                        </p>

                        <p
                            id="historiaTemperatura"
                            class="text-lg font-bold text-slate-800 mt-1"
                        >
                            -
                        </p>

                    </div>


                    <!-- PULSO -->
                    <div class="bg-slate-50 rounded-xl p-4">

                        <p class="text-sm text-slate-500">
                            Pulso
                        </p>

                        <p
                            id="historiaPulso"
                            class="text-lg font-bold text-slate-800 mt-1"
                        >
                            -
                        </p>

                    </div>


                    <!-- FRECUENCIA RESPIRATORIA -->
                    <div class="bg-slate-50 rounded-xl p-4">

                        <p class="text-sm text-slate-500">
                            Frecuencia respiratoria
                        </p>

                        <p
                            id="historiaFrecuenciaRespiratoria"
                            class="text-lg font-bold text-slate-800 mt-1"
                        >
                            -
                        </p>

                    </div>


                    <!-- PRESIÓN ARTERIAL -->
                    <div class="bg-slate-50 rounded-xl p-4">

                        <p class="text-sm text-slate-500">
                            Presión arterial
                        </p>

                        <p
                            id="historiaPresionArterial"
                            class="text-lg font-bold text-slate-800 mt-1"
                        >
                            -
                        </p>

                    </div>

                </div>

            </div>


            <!-- ==========================================
                 EXAMEN ESTOMATOGNÁTICO
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Examen Estomatognático
                </h3>

                <div
                    id="historiaEstomatognatico"
                    class="grid grid-cols-1 md:grid-cols-2 gap-4"
                >
                </div>

            </div>


            <!-- ==========================================
                 INDICADORES DE SALUD BUCAL
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Indicadores de Salud Bucal
                </h3>

                <div
                    id="historiaIndicadores"
                    class="space-y-4"
                >
                </div>

            </div>


            <!-- ==========================================
                 HIGIENE ORAL SIMPLIFICADA
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="p-6">

                    <h3 class="text-xl font-bold text-slate-800">
                        Higiene Oral Simplificada
                    </h3>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-blue-600 text-white">

                            <tr>

                                <th class="px-6 py-3 text-left">
                                    Pieza
                                </th>

                                <th class="px-6 py-3 text-center">
                                    Placa
                                </th>

                                <th class="px-6 py-3 text-center">
                                    Cálculo
                                </th>

                                <th class="px-6 py-3 text-center">
                                    Gingivitis
                                </th>

                            </tr>

                        </thead>

                        <tbody
                            id="historiaHigieneOral"
                            class="divide-y divide-slate-100"
                        >
                        </tbody>

                    </table>

                </div>

            </div>


            <!-- ==========================================
                 ODONTOGRAMA
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <div class="mb-5">

                    <h3 class="text-xl font-bold text-slate-800">
                        Odontograma
                    </h3>

                    <p class="text-slate-500 text-sm mt-1">
                        Estado odontológico registrado en esta atención.
                    </p>

                </div>

                <div
                    id="historiaOdontograma"
                    class="overflow-x-auto"
                >
                </div>

            </div>


            <!-- ==========================================
                 DIAGNÓSTICOS
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Diagnósticos
                </h3>

                <div
                    id="historiaDiagnosticos"
                    class="space-y-3"
                >
                </div>

            </div>


            <!-- ==========================================
                 TRATAMIENTOS
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Tratamientos
                </h3>

                <div
                    id="historiaTratamientos"
                    class="space-y-3"
                >
                </div>

            </div>


            <!-- ==========================================
                 EXÁMENES COMPLEMENTARIOS
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Exámenes Complementarios
                </h3>

                <div
                    id="historiaExamenes"
                    class="space-y-3"
                >
                </div>

            </div>


            <!-- ==========================================
                 INFORMES DE EXÁMENES
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Informes de Exámenes
                </h3>

                <div
                    id="historiaInformes"
                    class="space-y-3"
                >
                </div>

            </div>


            <!-- ==========================================
                 COMPLICACIONES
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Complicaciones
                </h3>

                <div id="historiaComplicaciones">
                </div>

            </div>


            <!-- ==========================================
                 PRESCRIPCIÓN MÉDICA
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Prescripción Médica
                </h3>

                <div
                    id="historiaPrescripcion"
                    class="space-y-3"
                >
                </div>

            </div>


            <!-- ==========================================
                 FOTOGRAFÍAS CLÍNICAS
            =========================================== -->
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-xl font-bold text-slate-800 mb-5">
                    Fotografías Clínicas
                </h3>

                <div
                    id="historiaFotografias"
                    class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4"
                >
                </div>

            </div>


        </div>
        <!-- FIN DETALLE ATENCIÓN -->


    </div>
    <!-- FIN CONTENIDO HISTORIA -->

</div>


<!-- ==========================================
     JS DEL MÓDULO HISTORIAS CLÍNICAS
=========================================== -->
<script src="/public/js/historias.js"></script>