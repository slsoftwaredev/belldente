<div class="bg-white rounded-xl shadow">

    <!-- Encabezado -->

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b">

        <div>

            <h2 class="text-2xl font-bold text-slate-800">

                Catálogo Tratamientos

            </h2>

            <p class="text-slate-500">

                Administración de tratamientos clínicos.

            </p>

        </div>

        <button
            id="btnNuevo"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

            + Nuevo

        </button>

    </div>

    <!-- Buscador -->

    <div class="p-6">

        <input
            type="text"
            id="buscar"
            placeholder="Buscar tratamiento..."
            class="w-full md:w-80 border rounded-lg px-4 py-2">

    </div>

    <!-- Tabla -->

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-blue-600 text-white">

                <tr>

                    <th class="px-4 py-3 text-left">
                        Tratamiento
                    </th>

                    <th class="px-4 py-3 text-left">
                        Descripción
                    </th>

                    <th class="px-4 py-3 text-center">
                        Valor
                    </th>
                    <th class="px-4 py-3 text-center">
                        Estado
                    </th>
                    <th class="px-4 py-3 text-center">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody id="tbllistado">

            </tbody>

        </table>

    </div>

</div>

<?php require "modal.php"; ?>