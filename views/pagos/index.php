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
        <button class="px-5 py-2 rounded-xl bg-blue-600 text-white">
            Todos
        </button>

        <button class="px-5 py-2 rounded-xl bg-yellow-500 text-white">
            Pendientes
        </button>

        <button class="px-5 py-2 rounded-xl bg-green-600 text-white">
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
<script src="/public/js/pagos.js"></script>