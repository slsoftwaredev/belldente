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

            

        </h2>

    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5">

        <p class="text-slate-500 text-sm">
            Citas Atrasadas
        </p>

        <h2
            id="lblCitasAtrasadas"
            class="text-3xl font-bold text-red-500 mt-2">

            

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
                        Dentista
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Fecha
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Hora
                    </th>

                    <th class="px-6 py-4 text-left font-semibold">
                        Motivo
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
        Dentista
    </label>

    <select
        id="dentista_id"
        name="dentista_id"
        class="w-full border border-slate-300 rounded-xl px-4 py-3">

        <option value="">
            Seleccione un dentista
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

<div>

    <label class="block text-sm mb-2 font-medium">
        Motivo de la cita
    </label>

    <input
        id="motivo_cita"
        name="motivo_cita"
        class="w-full border border-slate-300 rounded-xl px-4 py-3"
        placeholder="Ingrese el motivo de la cita">

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

<!-- Modal Confirmar Hora -->
<div
    id="modalConfirmarHora"
    class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50">

    <div
        class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

        <!-- Header -->
        <div
            class="px-6 py-5 flex items-center justify-between bg-blue-600">

            <div>

                <h2
                    class="text-xl font-bold text-white">
                    Confirmar Hora
                </h2>

                <p class="text-sm text-white">
                    Seleccione una hora disponible para la cita
                </p>

            </div>

            <button
                type="button"
                id="btnCerrarModalHora"
                class="text-3xl text-white hover:text-red-500">

                ×

            </button>

        </div>

        <!-- Contenido -->
        <div class="p-6 space-y-5">

            <input
                type="hidden"
                id="id_cita_hora">

            <div>

                <label
                    class="block text-sm mb-2 font-medium">
                    Hora disponible
                </label>

                <select
                    id="hora_cita_confirmar"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    <option value="">
                        Seleccione una hora
                    </option>

                </select>

            </div>

        </div>

        <!-- Footer -->
        <div
            class="px-6 py-5 flex flex-col md:flex-row justify-end gap-3">

            <button
                type="button"
                id="btnCancelarHora"
                class="border border-slate-300 px-5 py-3 rounded-xl hover:bg-slate-100">

                Cancelar

            </button>

            <button
                type="button"
                id="btnGuardarHora"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

                Confirmar Hora

            </button>

        </div>

    </div>

</div>
<!-- Modal de mensajes y confirmaciones -->
<div
    id="modalSistema"
    class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-[60]">

    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md overflow-hidden">

        <!-- Header -->
        <div
            id="modalSistemaHeader"
            class="px-6 py-5 flex items-center gap-4 bg-blue-600">

            <div
                id="modalSistemaIcono"
                class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-white">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-7 h-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"/>
                </svg>

            </div>

            <div>
                <h2
                    id="modalSistemaTitulo"
                    class="text-xl font-bold text-white">
                    Información
                </h2>

                <p
                    id="modalSistemaSubtitulo"
                    class="text-sm text-white/80">
                    BellDente
                </p>
            </div>

        </div>

        <!-- Contenido -->
        <div class="p-6">

            <p
                id="modalSistemaMensaje"
                class="text-slate-600 leading-relaxed">
            </p>

        </div>

        <!-- Footer -->
        <div class="px-6 pb-6 flex justify-end gap-3">

            <button
                type="button"
                id="btnModalSistemaCancelar"
                class="hidden border border-slate-300 px-5 py-3 rounded-xl hover:bg-slate-100 transition">

                Volver

            </button>

            <button
                type="button"
                id="btnModalSistemaAceptar"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl transition">

                Aceptar

            </button>

        </div>

    </div>

</div>
<!-- Modal Mensaje -->

<?php if (isset($mensaje) && $mensaje === "seleccione_cita"): ?>

<div
    id="modalMensaje"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

        <div class="flex items-center gap-3 mb-4">

            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-7 h-7 text-amber-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v2m0 4h.01M10.29 3.86l-8 14A1 1 0 003.17 19h17.66a1 1 0 00.88-1.5l-8-14a1 1 0 00-1.76 0z"/>

                </svg>

            </div>

            <div>

                <h2 class="text-lg font-semibold">
                    Atención Clínica
                </h2>

                <p class="text-sm text-slate-500">
                    Debe seleccionar una cita antes de iniciar una atención clínica.
                </p>

            </div>

        </div>

        <div class="flex justify-end">

            <button
                onclick="cerrarModalMensaje()"
                class="px-5 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700">

                Aceptar

            </button>

        </div>

    </div>

</div>

<?php endif; ?>

<script src="/public/js/cita.js"></script>
