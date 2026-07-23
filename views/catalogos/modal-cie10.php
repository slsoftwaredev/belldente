<!-- Modal CIE-10 -->

<div
    id="modalCIE10"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4">

        <!-- Encabezado -->

        <div class="flex items-center justify-between border-b px-6 py-4">

            <h2
                id="tituloModalCIE10"
                class="text-xl font-bold text-slate-800">

                Nuevo Diagnóstico CIE-10

            </h2>

            <button
                type="button"
                id="btnCerrarModalCIE10"
                class="text-2xl text-slate-500 hover:text-red-600">

                &times;

            </button>

        </div>

        <!-- Formulario -->

        <form id="formCIE10">

            <input
                type="hidden"
                id="id_cie10"
                name="id_cie10">

            <div class="p-6 space-y-4">

                <!-- Código -->

                <div>

                    <label
                        for="codigo"
                        class="block mb-1 font-medium text-sm">

                        Código <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        id="codigo"
                        name="codigo"
                        maxlength="10"
                        autocomplete="off"
                        class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <!-- Descripción -->

                <div>

                    <label
                        for="descripcion"
                        class="block mb-1 font-medium text-sm">

                        Descripción <span class="text-red-500">*</span>

                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="4"
                        class="w-full rounded-lg border px-4 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

                </div>

            </div>

            <!-- Botones -->

            <div class="flex justify-end gap-3 border-t px-6 py-4">

                <button
                    type="button"
                    id="btnCancelarCIE10"
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

<script src="/public/js/catalogos.js"></script>