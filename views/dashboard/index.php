<div class="p-6">

    <!-- TITULO -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Dashboard
        </h1>
        <p class="text-sm text-slate-500">
            Bienvenido a BellDente
        </p>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100">
            <p class="text-slate-500 text-sm">Citas Hoy</p>
            <h2 class="text-3xl font-bold mt-2">12</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100">
            <p class="text-slate-500 text-sm">En Espera</p>
            <h2 class="text-3xl font-bold mt-2">3</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100">
            <p class="text-slate-500 text-sm">Atendidos</p>
            <h2 class="text-3xl font-bold mt-2">8</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-slate-100">
            <p class="text-slate-500 text-sm">Cobrado Hoy</p>
            <h2 class="text-3xl font-bold mt-2">$350.00</h2>
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

                <button
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm">
                    Nueva Cita
                </button>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3">Hora</th>
                            <th class="text-left py-3">Paciente</th>
                            <th class="text-left py-3">Motivo</th>
                            <th class="text-left py-3">Estado</th>
                            <th class="text-center py-3">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr class="border-b">
                            <td class="py-3">08:00</td>
                            <td>Juan Pérez</td>
                            <td>Limpieza</td>
                            <td>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Confirmada
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="text-blue-600">
                                    Ver
                                </button>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="py-3">09:00</td>
                            <td>María López</td>
                            <td>Control</td>
                            <td>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                    En Espera
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="text-blue-600">
                                    Ver
                                </button>
                            </td>
                        </tr>

                    </tbody>

                </table>

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