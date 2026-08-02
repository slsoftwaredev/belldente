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
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg lg:hidden">

                + Nuevo

            </button>

        </div>
    <!-- ===========================
            FORMULARIO
    ============================ -->

    <!-- FORMULARIO CIE-10 -->
     <div id="formCIE" class="hidden lg:block">

    <form id="formCIE10" class="p-6">

            <input
                type="hidden"
                id="id_cie10"
                name="id_cie10">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Código -->

                <div>

                    <label
                        for="codigo"
                        class="block mb-2 font-medium text-sm">

                        Código <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        placeholder="Ejemplo: K02.3"
                        id="codigo"
                        name="codigo"
                        maxlength="10"
                        autocomplete="off"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">

                </div>

                <!-- Descripción -->

                <div>

                    <label
                        for="descripcion"
                        class="block mb-2 font-medium text-sm">

                        Nombre <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        placeholder="Ejemplo: Caries detenida"
                        id="descripcion"
                        name="descripcion"
                        autocomplete="off"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3">
                </div>

            </div>

            <!-- Botones -->

            <div class="flex justify-start gap-4 mt-6">

                <button
                    type="button"
                    id="btnCancelar"
                    class="px-5 py-3 rounded-lg border border-slate-300 hover:bg-slate-100 lg:hidden">

                    Cancelar

                </button>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700">

                    Guardar

                </button>

            </div>

        </form>
    </div>
</div>

     <!-- ===========================
            BUSCADOR
    ============================ -->

    <div class="bg-white rounded-2xl shadow-sm p-5">

        <input
            type="text"
            id="buscarCIE10"
            placeholder="Buscar diagnóstico..."
            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">

    </div>

    <!-- ===========================
            TABLA
    ============================ -->
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

            <tbody id="tbllistadoCie10">

            </tbody>

        </table>

    </div>

  </div>
  <!-- Vista móvil -->
    <div
        id="cardsCie10"
        class="grid gap-4 lg:hidden">

    </div>
</div>

<script src="/public/js/cie10.js"></script>