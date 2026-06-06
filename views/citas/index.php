<div class="space-y-6">
<!-- Encabezado -->
<div class="bg-white rounded-2xl shadow-sm p-6">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Citas
            </h1>

            <p class="text-slate-500 mt-1">
                Administración de citas del sistema BellDente
            </p>

        </div>

        <button
            id="btnNuevaCita"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-medium transition">

            + Nueva Cita

        </button>

    </div>

</div>

<!-- Tarjetas Resumen -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <div class="bg-white rounded-2xl shadow-sm p-5">

        <p class="text-slate-500 text-sm">
            Citas del Día
        </p>

        <h2
            id="lblCitasHoy"
            class="text-3xl font-bold text-blue-600 mt-2">

            0

        </h2>

    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5">

        <p class="text-slate-500 text-sm">
            Citas Atrasadas
        </p>

        <h2
            id="lblCitasAtrasadas"
            class="text-3xl font-bold text-red-500 mt-2">

            0

        </h2>

    </div>

</div>

<!-- Buscador -->
<div class="bg-white rounded-2xl shadow-sm p-5">

    <input
        type="text"
        id="txtBuscar"
        placeholder="Buscar cita..."
        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">

</div>

<!-- Tabla Desktop -->
<div class="hidden lg:block bg-white rounded-2xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-blue-600 text-white">

                <tr>

                    <th class="px-6 py-4 text-left font-semibold">
                        ID
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Paciente
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Fecha
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Estado
                    </th>

                    <th class="px-6 py-4 text-center font-semibold">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody id="tblCitas">

            </tbody>

        </table>

    </div>

</div>

<!-- Vista móvil -->
<div
    id="cardCitas"
    class="grid gap-4 lg:hidden">

</div>


</div>

<!-- Modal Cita -->

<div
    id="modalCita"
    class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50">


<div
    class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

    <!-- Header -->

    <div
        class="px-6 py-5 flex items-center justify-between bg-blue-600">

        <div>

            <h2
                id="tituloModal"
                class="text-xl font-bold text-white">

                Nueva Cita

            </h2>

            <p class="text-sm text-white">

                Complete la información de la cita

            </p>

        </div>

        <button
            type="button"
            id="btnCerrarModal"
            class="text-3xl text-white hover:text-red-500">

            ×

        </button>

    </div>

    <!-- Formulario -->

    <form
        id="formCita"
        class="p-6 space-y-5">

        <input
            type="hidden"
            id="id_cita"
            name="id_cita"
            value="0">

        <div>

            <label class="block text-sm mb-2 font-medium">
                Paciente
            </label>

            <select
                id="paciente_id"
                name="paciente_id"
                class="w-full border border-slate-300 rounded-xl px-4 py-3">

                <option value="">
                    Seleccione un paciente
                </option>

            </select>

        </div>

        <div>

            <label class="block text-sm mb-2 font-medium">
                Fecha de la cita
            </label>

            <input
                type="date"
                id="fecha_cita"
                name="fecha_cita"
                class="w-full border border-slate-300 rounded-xl px-4 py-3">

        </div>

    </form>

    <!-- Footer -->

    <div
        class="px-6 py-5 flex flex-col md:flex-row justify-end gap-3">

        <button
            type="button"
            id="btnCancelar"
            class="border border-slate-300 px-5 py-3 rounded-xl hover:bg-slate-100">

            Cancelar

        </button>

        <button
            type="submit"
            form="formCita"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

            Guardar Cita

        </button>

    </div>

</div>
</div>

<script src="/public/js/cita.js"></script>
