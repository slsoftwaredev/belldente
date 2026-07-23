<!-- Modal Procedimientos -->

<div
    id="modalProcedimiento"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl mx-4">

        <!-- Encabezado -->

        <div class="flex items-center justify-between border-b px-6 py-4">

            <h2
                id="tituloModalProcedimiento"
                class="text-xl font-bold text-slate-800">

                Nuevo Tratamiento

            </h2>

            <button
                type="button"
                id="btnCerrarModalProcedimiento"
                class="text-2xl text-slate-500 hover:text-red-600">

                &times;

            </button>

        </div>

        <!-- Formulario -->

        <form id="formProcedimiento">

            <input
                type="hidden"
                id="id_procedimiento"
                name="id_procedimiento">

            <div class="p-6 space-y-4">

                <!-- Nombre -->

                <div>

                    <label
                        for="nombre"
                        class="block mb-1 font-medium text-sm">

                        Nombre del tratamiento <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        autocomplete="off"
                        class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- Descripción -->

                <div>

                    <label
                        for="descripcion_procedimiento"
                        class="block mb-1 font-medium text-sm">

                        Descripción

                    </label>

                    <textarea
                        id="descripcion_procedimiento"
                        name="descripcion"
                        rows="4"
                        class="w-full rounded-lg border px-4 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

                </div>

                <!-- Valor -->

                <div>

                    <label
                        for="valor"
                        class="block mb-1 font-medium text-sm">

                        Valor ($) <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="number"
                        id="valor"
                        name="valor"
                        min="0"
                        step="0.01"
                        class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

            </div>

            <!-- Botones -->

            <div class="flex justify-end gap-3 border-t px-6 py-4">

                <button
                    type="button"
                    id="btnCancelarProcedimiento"
                    class="px-4 py-2 rounded-lg border hover:bg-slate-100">

                    Cancelar

                </button>

                <button
                    type="submit"
                    class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">

                    Guardar

                </button>

            </div>

        </form>

    </div>

</div>