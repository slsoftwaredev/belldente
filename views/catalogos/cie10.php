<div class="space-y-6">

    <!-- Encabezado -->
<div class="bg-white rounded-2xl shadow-sm p-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Catálogo CIE-10

            </h1>

            <p class="text-slate-500 mt-1">

                Administración de diagnósticos clínicos.

            </p>

        </div>

        <button
            id="btnNuevo"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

            + Nuevo

        </button>

    </div>
</div>

    <!-- Buscador -->

    <div class="bg-white rounded-2xl shadow-sm p-5">

        <input
            type="text"
            id="buscar"
            placeholder="Buscar diagnóstico..."
            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">

    </div>

    <!-- Tabla desktop-->
<div class="hidden lg:block bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-blue-600 text-white">

                <tr>

                    <th class="px-6 py-4 text-left font-semibold">
                        Código
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Descripción
                    </th>

                    <th class="px-6 py-4 text-center font-semibold">
                        Estado
                    </th>

                    <th class="px-6 py-4 text-center font-semibold">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody id="tbllistado">

            </tbody>

        </table>

    </div>

  </div>
</div>
