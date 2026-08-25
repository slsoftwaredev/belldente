<div class="p-6">

    <!-- TITULO -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Dashboard
        </h1>
        <p class="text-sm text-slate-500">
            Bienvenido al Sistema de Gestión Clínica y Control de Pagos
        </p>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100">
            <p class="text-slate-500 text-sm">Citas Hoy</p>
            <h2 id="totalCitasHoy" class="text-3xl font-bold mt-2">0</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100">
            <p class="text-slate-500 text-sm">Pendientes Hoy</p>
            <h2 id="totalPendientesHoy" class="text-3xl font-bold mt-2">0</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100">
            <p class="text-slate-500 text-sm">Atendidos</p>
            <h2 class="text-3xl font-bold mt-2">0</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100">
            <p class="text-slate-500 text-sm">Cobrado Hoy</p>
            <h2 class="text-3xl font-bold mt-2">$0.00</h2>
        </div>
    </div>
    <!-- INPUT PARA VALIDAR CEDULA -->
<div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100 mb-6">

    <div class="flex flex-col md:flex-row md:items-end gap-4">

        <div class="flex-1">
            <label for="cedula" class="block text-sm font-medium text-slate-700 mb-2">
                Validar Cédula
            </label>

            <input id="cedula"name="cedula"type="text"maxlength="10"inputmode="numeric"placeholder="Ingrese la cédula para validar"class="w-full border border-slate-300 rounded-xl px-4 py-3">
        </div>

        <div>
            <button id="btnValidarCedula" type="button" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition">Validar</button>
        </div>

    </div>

</div>

    <!-- CONTENIDO -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- AGENDA -->
        <div class="xl:col-span-2 bg-white rounded-xl shadow-sm p-5">

            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-slate-700">
                    Agenda de Hoy
                </h3>
            </div>

            <!-- DESKTOP -->
<div class="hidden md:block overflow-x-auto">

    <table class="w-full">

        <thead>
            <tr class="border-b">
                <th class="text-left py-3">Paciente</th>
                <th class="text-left py-3">Fecha</th>
                <th class="text-left py-3">Estado</th>
                <th class="text-center py-3">Acciones</th>
            </tr>
        </thead>

        <tbody id="tblCitasHoy">
            <!-- JS -->
        </tbody>

    </table>

</div>

<!-- MÓVIL -->
<div
    id="cardCitasHoy"
    class="md:hidden space-y-3">

    <!-- JS -->

</div>

        </div>

        <!-- LATERAL -->
        <div class="space-y-6">

            <!-- ACCESOS RAPIDOS -->
            <div class="bg-white rounded-xl shadow-sm p-5">

                <h3 class="font-semibold mb-4">
                    Accesos Rápidos
                </h3>

                <div class="grid grid-cols-2 gap-3">

                    <button class="bg-blue-100 p-4 rounded-lg">
                        👤 Paciente
                    </button>

                    <button class="bg-green-100 p-4 rounded-lg">
                        📅 Cita
                    </button>

                    <button class="bg-purple-100 p-4 rounded-lg">
                        🦷 Atención
                    </button>

                    <button class="bg-orange-100 p-4 rounded-lg">
                        💰 Pago
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="/public/js/dashboard.js"></script>