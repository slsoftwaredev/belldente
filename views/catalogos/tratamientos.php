<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm p-6">

    <!-- Encabezado -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">
                Catálogo de Tratamientos
            </h2>

            <p class="text-slate-500 mt-1">
                Administración de tratamientos clínicos.
            </p>

        </div>

        <!-- Solo visible en móvil -->
        <button
            id="btnNuevo"
            class="lg:hidden bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

            + Nuevo

        </button>
</div>

    <!-- ===========================
            FORMULARIO
    ============================ -->

    <!-- FORMULARIO TRATAMIENTO -->
    <div
    id="formTratamiento" class="hidden lg:block">

    <form
        id="formProcedimiento" class="p-6">

        <input
            type="hidden"
            id="id_procedimiento"
            name="id_procedimiento">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Nombre -->

            <div>

                <label
                    for="nombre"
                    class="block mb-2 font-medium text-sm">

                    Nombre del tratamiento
                    <span class="text-red-500">*</span>

                </label>

                <input
                    type="text"
                    placeholder="Ejemplo: Blanqueamiento dental" 
                    id="nombre"
                    name="nombre"
                    autocomplete="off"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3">

            </div>

            <!-- Valor -->

            <div>

                <label
                    for="valor"
                    class="block mb-2 font-medium text-sm">

                    Valor ($)
                    <span class="text-red-500">*</span>

                </label>

                <input
                    type="number"
                    placeholder="Ejemplo: 20.00"
                    id="valor"
                    name="valor"
                    min="0"
                    step="0.01"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3">

            </div>

        </div>

        <div class="flex justify-start gap-4 mt-6">

            <button
                type="button"
                id="btnCancelar"
                class="px-5 py-3 rounded-lg border border-slate-300 hover:bg-slate-100 lg:hidden">

                Cancelar

            </button>

            <button
                type="submit"
                id="btnGuardar"
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
            id="buscar"
            placeholder="Buscar tratamiento..."
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
                            Tratamiento
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Descripción
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Valor
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
    <!-- Vista móvil -->
    <div
        id="cardsTratamientos"
        class="grid gap-4 lg:hidden">

    </div>
</div>

<script src="/public/js/tratamientos.js"></script>