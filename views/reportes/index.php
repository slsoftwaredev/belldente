<div class="space-y-6">

    <!-- =========================================
         ENCABEZADO
    ========================================== -->
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="text-3xl font-bold text-slate-800">
            Reportes
        </h2>

        <p class="text-slate-500 mt-1">
            Consulta y genera reportes del sistema BellDente.
        </p>

    </div>


    <!-- =========================================
         TARJETAS RESUMEN
    ========================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Pacientes -->
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <p class="text-slate-500 text-sm">
                Pacientes
            </p>

            <h2
                id="totalPacientes"
                class="text-3xl font-bold text-blue-600 mt-2">
                0
            </h2>

        </div>


        <!-- Atenciones -->
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <p class="text-slate-500 text-sm">
                Atenciones
            </p>

            <h2
                id="totalAtenciones"
                class="text-3xl font-bold text-green-600 mt-2">
                0
            </h2>

        </div>


        <!-- Cobrado -->
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <p class="text-slate-500 text-sm">
                Cobrado
            </p>

            <h2
                id="totalCobrado"
                class="text-3xl font-bold text-emerald-600 mt-2">
                $0.00
            </h2>

        </div>


        <!-- Pendiente -->
        <div class="bg-white rounded-2xl shadow-sm p-6">

            <p class="text-slate-500 text-sm">
                Pendiente
            </p>

            <h2
                id="totalPendiente"
                class="text-3xl font-bold text-red-600 mt-2">
                $0.00
            </h2>

        </div>

    </div>


    <!-- =========================================
         TIPOS DE REPORTES
    ========================================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- Pacientes -->
        <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col">

            <div class="text-5xl mb-4">
                👥
            </div>

            <h3 class="text-xl font-semibold text-slate-800">
                Pacientes
            </h3>

            <p class="text-slate-500 mt-2 flex-1">
                Genera el listado de pacientes registrados.
            </p>

            <button
                type="button"
                onclick="abrirReportePacientes()"
                class="w-full mt-6 bg-blue-600 hover:bg-blue-700
                       text-white py-3 rounded-xl transition">

                Generar Reporte

            </button>

        </div>


        <!-- Citas -->
        <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col">

            <div class="text-5xl mb-4">
                📅
            </div>

            <h3 class="text-xl font-semibold text-slate-800">
                Citas
            </h3>

            <p class="text-slate-500 mt-2 flex-1">
                Consulta las citas registradas por fecha y estado.
            </p>

            <button
                type="button"
                onclick="abrirReporteCitas()"
                class="w-full mt-6 bg-blue-600 hover:bg-blue-700
                       text-white py-3 rounded-xl transition">

                Generar Reporte

            </button>

        </div>


        <!-- Atenciones -->
        <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col">

            <div class="text-5xl mb-4">
                🦷
            </div>

            <h3 class="text-xl font-semibold text-slate-800">
                Atenciones
            </h3>

            <p class="text-slate-500 mt-2 flex-1">
                Reporte de las atenciones clínicas realizadas.
            </p>

            <button
                type="button"
                onclick="abrirReporteAtenciones()"
                class="w-full mt-6 bg-blue-600 hover:bg-blue-700
                       text-white py-3 rounded-xl transition">

                Generar Reporte

            </button>

        </div>


        <!-- Pagos -->
        <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col">

            <div class="text-5xl mb-4">
                💰
            </div>

            <h3 class="text-xl font-semibold text-slate-800">
                Pagos
            </h3>

            <p class="text-slate-500 mt-2 flex-1">
                Reporte de pagos, abonos y saldos pendientes.
            </p>

            <button
                type="button"
                onclick="abrirReportePagos()"
                class="w-full mt-6 bg-blue-600 hover:bg-blue-700
                       text-white py-3 rounded-xl transition">

                Generar Reporte

            </button>

        </div>

    </div>


    <!-- =========================================
         MODAL PACIENTES
    ========================================== -->
    <div
        id="modalReportePacientes"
        class="fixed inset-0 z-50 hidden items-center justify-center
               bg-black/50 p-4">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

            <div class="flex justify-between items-center mb-6">

                <h3 class="text-xl font-bold text-slate-800">
                    Reporte de Pacientes
                </h3>

                <button
                    type="button"
                    onclick="cerrarModalReporte('modalReportePacientes')"
                    class="text-slate-400 hover:text-slate-700 text-2xl">
                    &times;
                </button>

            </div>

            <div>

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Estado
                </label>

                <select
                    id="reportePacienteEstado"
                    class="w-full border border-slate-300 rounded-xl
                           px-4 py-3 focus:outline-none focus:ring-2
                           focus:ring-blue-500">

                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>

                </select>

            </div>

            <div class="flex justify-end gap-3 mt-6">

                <button
                    type="button"
                    onclick="cerrarModalReporte('modalReportePacientes')"
                    class="px-5 py-3 bg-slate-200 hover:bg-slate-300
                           text-slate-700 rounded-xl">

                    Cancelar

                </button>

                <button
                    type="button"
                    onclick="generarReportePacientes()"
                    class="px-5 py-3 bg-blue-600 hover:bg-blue-700
                           text-white rounded-xl">

                    Generar PDF

                </button>

            </div>

        </div>

    </div>


    <!-- =========================================
         MODAL CITAS
    ========================================== -->
    <div
        id="modalReporteCitas"
        class="fixed inset-0 z-50 hidden items-center justify-center
               bg-black/50 p-4">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">

            <div class="flex justify-between items-center mb-6">

                <h3 class="text-xl font-bold text-slate-800">
                    Reporte de Citas
                </h3>

                <button
                    type="button"
                    onclick="cerrarModalReporte('modalReporteCitas')"
                    class="text-slate-400 hover:text-slate-700 text-2xl">
                    &times;
                </button>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Desde
                    </label>

                    <input
                        type="date"
                        id="reporteCitaDesde"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Hasta
                    </label>

                    <input
                        type="date"
                        id="reporteCitaHasta"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

            </div>


            <div class="mt-4">

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Estado
                </label>

                <select
                    id="reporteCitaEstado"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    <option value="">Todos</option>

                </select>

            </div>


            <div class="flex justify-end gap-3 mt-6">

                <button
                    type="button"
                    onclick="cerrarModalReporte('modalReporteCitas')"
                    class="px-5 py-3 bg-slate-200 hover:bg-slate-300
                           text-slate-700 rounded-xl">

                    Cancelar

                </button>

                <button
                    type="button"
                    onclick="generarReporteCitas()"
                    class="px-5 py-3 bg-blue-600 hover:bg-blue-700
                           text-white rounded-xl">

                    Generar PDF

                </button>

            </div>

        </div>

    </div>


    <!-- =========================================
         MODAL ATENCIONES
    ========================================== -->
    <div
        id="modalReporteAtenciones"
        class="fixed inset-0 z-50 hidden items-center justify-center
               bg-black/50 p-4">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">

            <div class="flex justify-between items-center mb-6">

                <h3 class="text-xl font-bold text-slate-800">
                    Reporte de Atenciones
                </h3>

                <button
                    type="button"
                    onclick="cerrarModalReporte('modalReporteAtenciones')"
                    class="text-slate-400 hover:text-slate-700 text-2xl">
                    &times;
                </button>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Desde
                    </label>

                    <input
                        type="date"
                        id="reporteAtencionDesde"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Hasta
                    </label>

                    <input
                        type="date"
                        id="reporteAtencionHasta"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

            </div>


            <div class="flex justify-end gap-3 mt-6">

                <button
                    type="button"
                    onclick="cerrarModalReporte('modalReporteAtenciones')"
                    class="px-5 py-3 bg-slate-200 hover:bg-slate-300
                           text-slate-700 rounded-xl">

                    Cancelar

                </button>

                <button
                    type="button"
                    onclick="generarReporteAtenciones()"
                    class="px-5 py-3 bg-blue-600 hover:bg-blue-700
                           text-white rounded-xl">

                    Generar PDF

                </button>

            </div>

        </div>

    </div>


    <!-- =========================================
         MODAL PAGOS
    ========================================== -->
    <div
        id="modalReportePagos"
        class="fixed inset-0 z-50 hidden items-center justify-center
               bg-black/50 p-4">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">

            <div class="flex justify-between items-center mb-6">

                <h3 class="text-xl font-bold text-slate-800">
                    Reporte de Pagos
                </h3>

                <button
                    type="button"
                    onclick="cerrarModalReporte('modalReportePagos')"
                    class="text-slate-400 hover:text-slate-700 text-2xl">
                    &times;
                </button>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Desde
                    </label>

                    <input
                        type="date"
                        id="reportePagoDesde"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>


                <div>

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Hasta
                    </label>

                    <input
                        type="date"
                        id="reportePagoHasta"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

            </div>


            <div class="mt-4">

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Tipo de reporte
                </label>

                <select
                    id="reportePagoTipo"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    <option value="movimientos">
                        Pagos y abonos realizados
                    </option>

                    <option value="pendientes">
                        Cuentas por cobrar
                    </option>

                </select>

            </div>


            <div
                id="contenedorFormaPago"
                class="mt-4">

                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Forma de pago
                </label>

                <select
                    id="reporteFormaPago"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    <option value="">Todas</option>

                </select>

            </div>


            <div class="flex justify-end gap-3 mt-6">

                <button
                    type="button"
                    onclick="cerrarModalReporte('modalReportePagos')"
                    class="px-5 py-3 bg-slate-200 hover:bg-slate-300
                           text-slate-700 rounded-xl">

                    Cancelar

                </button>

                <button
                    type="button"
                    onclick="generarReportePagos()"
                    class="px-5 py-3 bg-blue-600 hover:bg-blue-700
                           text-white rounded-xl">
                    Generar PDF

                </button>
            </div>
        </div>
    </div>
</div>

<script src="/public/js/reportes.js"></script>