<div class="space-y-6">
    <!-- Encabezado -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-3xl font-bold text-slate-800">
            Historias Clínicas
        </h2>

        <p class="text-slate-500 mt-1">
            Consulta el historial clínico de los pacientes.
        </p>
    </div>

    <!-- Buscador -->
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <input type="text" id="buscarHistoria" placeholder="Buscar paciente por nombre o cédula..." class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Tabla Desktop -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            Paciente
                        </th>

                        <th class="px-6 py-4 text-left">
                            Cédula
                        </th>

                        <th class="px-6 py-4 text-center">
                            Atenciones
                        </th>

                        <th class="px-6 py-4 text-center">
                            Última Atención
                        </th>

                        <th class="px-6 py-4 text-center">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody id="tbllistadoHistorias">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cards Mobile -->
    <div id="cardsHistorias" class="grid gap-4 lg:hidden">
    </div>
</div>

<script src="/public/js/historias.js"></script>