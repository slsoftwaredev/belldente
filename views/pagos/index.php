<div class="space-y-6">
    <!-- Encabezado -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-3xl font-bold text-slate-800">
            Control de Pagos
        </h2>
        <p class="text-slate-500 mt-1">
            Administra los pagos y abonos de los tratamientos realizados.
        </p>
    </div>

    <!-- Tarjetas Resumen -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-slate-500 text-sm">
                Órdenes Generadas
            </p>
            <h2 id="totalOrdenes" class="text-3xl font-bold text-slate-800 mt-2">
                0
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-slate-500 text-sm">
                Pendientes
            </p>
            <h2 id="totalPendientes" class="text-3xl font-bold text-yellow-600 mt-2">
                0
            </h2>

        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-slate-500 text-sm">
                Pagadas
            </p>
            <h2 id="totalPagadas"class="text-3xl font-bold text-green-600 mt-2">
                0
            </h2>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-slate-500 text-sm">
                Total por Cobrar
            </p>
            <h2 id="totalCobrar" class="text-3xl font-bold text-red-600 mt-2">
                $0.00
            </h2>
        </div>
    </div>
    <!-- Buscador -->

    <div class="bg-white rounded-2xl shadow-sm p-5">
        <input type="text"id="buscarPago"placeholder="Buscar por paciente, cédula o número de orden..."class="w-full px-4 py-3 border border-slate-300 rounded-xlfocus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Filtros -->
<div class="flex flex-wrap gap-3">

    <button
        type="button"
        data-filtro="Todos"
        class="filtro-pago px-5 py-2 rounded-xl
               bg-blue-600 hover:bg-blue-700 text-white
               ring-2 ring-offset-2 ring-slate-400"
    >
        Todos
    </button>

    <button
        type="button"
        data-filtro="Pendiente"
        class="filtro-pago px-5 py-2 rounded-xl
               bg-yellow-500 hover:bg-yellow-600 text-white"
    >
        Pendientes
    </button>

    <button
        type="button"
        data-filtro="Abonado"
        class="filtro-pago px-5 py-2 rounded-xl
               bg-orange-500 hover:bg-orange-600 text-white"
    >
        Abonadas
    </button>

    <button
        type="button"
        data-filtro="Pagado"
        class="filtro-pago px-5 py-2 rounded-xl
               bg-green-600 hover:bg-green-700 text-white"
    >
        Pagadas
    </button>

</div>

    <!-- Tabla Desktop -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            Orden
                        </th>
                        <th class="px-6 py-4 text-left">
                            Paciente
                        </th>
                        <th class="px-6 py-4 text-center">
                            Fecha
                        </th>
                        <th class="px-6 py-4 text-center">
                            Total
                        </th>
                        <th class="px-6 py-4 text-center">
                            Abonado
                        </th>
                        <th class="px-6 py-4 text-center">
                            Saldo
                        </th>
                        <th class="px-6 py-4 text-center">
                            Estado
                        </th>
                        <th class="px-6 py-4 text-center">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody id="tbllistadoPagos">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cards Mobile -->
    <div id="cardsPagos" class="grid gap-4 lg:hidden">
    </div>
</div>

<!-- =========================================================
     MODAL DETALLE DE PAGO
========================================================= -->
<div id="modalDetallePago" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-xl max-h-[90vh] overflow-y-auto">
        <!-- ENCABEZADO -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Detalle de la Orden
                </h2>

                <p id="detalleNumeroOrden" class="text-sm text-slate-500 mt-1">
                    Orden #-
                </p>
            </div>

            <button type="button" onclick="cerrarDetallePago()" class="text-slate-400 hover:text-slate-700 text-2xl leading-none">
                &times;
            </button>
        </div>
        <div class="p-6 space-y-6">

            <!-- =============================================
                 DATOS DEL PACIENTE
            ============================================== -->
            <div class="bg-slate-50 rounded-xl p-5">
                <h3 class="font-semibold text-slate-800 mb-4">
                    Información del Paciente
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-slate-500">
                            Paciente
                        </p>

                        <p id="detallePaciente" class="font-medium text-slate-800 mt-1">
                            -
                        </p>
                    </div>


                    <div>
                        <p class="text-slate-500">
                            Cédula
                        </p>

                        <p id="detalleCedula" class="font-medium text-slate-800 mt-1">
                            -
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">
                            Fecha de atención
                        </p>

                        <p id="detalleFecha" class="font-medium text-slate-800 mt-1">
                            -
                        </p>
                    </div>
                </div>
            </div>

            <!-- =============================================
                 RESUMEN DE LA ORDEN
            ============================================== -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

                <div class="border border-slate-200 rounded-xl p-4">

                    <p class="text-sm text-slate-500">
                        Total
                    </p>

                    <p
                        id="detalleTotal"
                        class="text-xl font-bold text-slate-800 mt-1"
                    >
                        $0.00
                    </p>

                </div>


                <div class="border border-slate-200 rounded-xl p-4">

                    <p class="text-sm text-slate-500">
                        Abonado
                    </p>

                    <p
                        id="detalleAbonado"
                        class="text-xl font-bold text-blue-600 mt-1"
                    >
                        $0.00
                    </p>

                </div>


                <div class="border border-slate-200 rounded-xl p-4">

                    <p class="text-sm text-slate-500">
                        Saldo
                    </p>

                    <p
                        id="detalleSaldo"
                        class="text-xl font-bold text-red-600 mt-1"
                    >
                        $0.00
                    </p>

                </div>


                <div class="border border-slate-200 rounded-xl p-4">

                    <p class="text-sm text-slate-500">
                        Estado
                    </p>

                    <div class="mt-2">
                        <span
                            id="detalleEstado"
                            class="inline-flex px-3 py-1
                                   rounded-full text-xs font-semibold"
                        >
                            -
                        </span>
                    </div>

                </div>

            </div>


            <!-- =============================================
                 TRATAMIENTOS
            ============================================== -->

            <div>

                <h3 class="font-semibold text-slate-800 mb-4">
                    Tratamientos
                </h3>

                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-100 text-slate-600">
                                <tr>
                                    <th class="px-4 py-3 text-left">
                                        Procedimiento
                                    </th>

                                    <th class="px-4 py-3 text-center">
                                        Cantidad
                                    </th>

                                    <th class="px-4 py-3 text-right">
                                        Precio
                                    </th>

                                    <th class="px-4 py-3 text-right">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="detalleTratamientos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- =============================================
                 HISTORIAL DE PAGOS
            ============================================== -->
            <div>
                <h3 class="font-semibold text-slate-800 mb-4">
                    Historial de Pagos
                </h3>

                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-100 text-slate-600">
                                <tr>
                                    <th class="px-4 py-3 text-left">
                                        Fecha
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Forma de pago
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Observación
                                    </th>

                                    <th class="px-4 py-3 text-right">
                                        Valor
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="detalleAbonos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- PIE -->
        <div class="flex justify-end px-6 py-4 border-t border-slate-200">
            <button type="button" onclick="cerrarDetallePago()" class="px-5 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium">
                Cerrar
            </button>
        </div>
    </div>
</div>

<!-- =========================================================
     MODAL REGISTRAR PAGO
========================================================= -->
<div id="modalRegistrarPago" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl">
        <!-- ENCABEZADO -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Registrar Pago
                </h2>

                <p id="pagoNumeroOrden" class="text-sm text-slate-500 mt-1">
                    Orden #-
                </p>
            </div>

            <button type="button" onclick="cerrarPago()" class="text-slate-400 hover:text-slate-700 text-2xl leading-none">
                &times;
            </button>
        </div>

        <form id="formRegistrarPago">
            <div class="p-6 space-y-6">
                <!-- ID ORDEN -->
                <input type="hidden" id="pagoIdOrden"name="id_orden_pago">

                <!-- PACIENTE -->
                <div class="bg-slate-50 rounded-xl p-5">
                    <p class="text-sm text-slate-500">
                        Paciente
                    </p>

                    <p id="pagoPaciente" class="font-semibold text-slate-800 mt-1">
                        -
                    </p>

                    <p id="pagoCedula" class="text-sm text-slate-500 mt-1">
                        -
                    </p>
                </div>

                <!-- RESUMEN -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="border border-slate-200 rounded-xl p-4">
                        <p class="text-sm text-slate-500">
                            Total
                        </p>

                        <p id="pagoTotal" class="text-xl font-bold text-slate-800 mt-1">
                            $0.00
                        </p>
                    </div>

                    <div class="border border-slate-200 rounded-xl p-4">
                        <p class="text-sm text-slate-500">
                            Abonado
                        </p>

                        <p id="pagoAbonado"class="text-xl font-bold text-blue-600 mt-1">
                            $0.00
                        </p>
                    </div>

                    <div class="border border-slate-200 rounded-xl p-4">
                        <p class="text-sm text-slate-500">
                            Saldo pendiente
                        </p>

                        <p id="pagoSaldo"class="text-xl font-bold text-red-600 mt-1">
                            $0.00
                        </p>
                    </div>
                </div>

                <!-- DATOS DEL PAGO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="pagoFormaPago" class="block text-sm font-medium text-slate-700 mb-2">
                            Forma de pago
                        </label>

                        <select id="pagoFormaPago" name="forma_pago_id" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">
                                Seleccione...
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="pagoValor" class="block text-sm font-medium text-slate-700 mb-2">
                            Valor a pagar
                        </label>

                        <input type="number" id="pagoValor" name="valor_abono" min="0.01" step="0.01" required placeholder="0.00" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <p id="pagoSaldoDisponible" class="text-xs text-slate-500 mt-2">
                        </p>
                    </div>
                </div>

                <!-- OBSERVACIÓN -->
                <div>
                    <label for="pagoObservacion" class="block text-sm font-medium text-slate-700 mb-2" >
                        Observación
                    </label>

                    <textarea id="pagoObservacion" name="observacion" rows="3" placeholder="Observación opcional..." class="w-full px-4 py-3 border border-slate-300 rounded-xl resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>
            <!-- PIE -->
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-200">
                <button type="button" onclick="cerrarPago()" class="px-5 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium">
                    Cancelar
                </button>

                <button type="submit" id="btnGuardarPago" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium">
                    Registrar pago
                </button>
            </div>
        </form>
    </div>
</div>
<script src="/public/js/pagos.js"></script>