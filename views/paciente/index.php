<div class="space-y-6">

    <!-- Encabezado -->
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    Pacientes
                </h1>

                <p class="text-slate-500 mt-1">
                    Administración de pacientes del sistema BellDente
                </p>

            </div>

            <button
                id="btnNuevoPaciente"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-medium transition">

                + Nuevo Paciente

            </button>

        </div>

    </div>

    <!-- Buscador -->
    <div class="bg-white rounded-2xl shadow-sm p-5">

        <input
            type="text"
            id="txtBuscar"
            placeholder="Buscar paciente..."
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
                            Nombre Completo
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Cedula
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Telefono
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody id="tblPacientes">

                </tbody>

            </table>

        </div>

    </div>

    <!-- Vista móvil -->
    <div
        id="cardPacientes"
        class="grid gap-4 lg:hidden">

    </div>

</div>

<!-- Modal Paciente -->

<div
    id="modalPaciente"
    class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50">

    <div
        class="bg-white rounded-3xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">

        <!-- Header del formulario-->

        <div
            class="px-6 py-5 flex items-center justify-between bg-blue-600">

            <div>

                <h2
                    id="tituloModal"
                    class="text-xl font-bold text-white">

                    Nuevo Paciente

                </h2>

                <p class="text-sm text-white">

                    Complete la información del paciente

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
            id="formPaciente"
            class="p-6 space-y-5">

            <input
                type="hidden"
                id="id_paciente"
                name="id_paciente"
                value="0">

            <div class="grid md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm mb-2 font-medium">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

                <div>

                    <label class="block text-sm mb-2 font-medium">
                        Apellido
                    </label>

                    <input
                        type="text"
                        name="apellido"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

            </div>

            <div class="grid md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm mb-2 font-medium">
                        Cédula
                    </label>

                    <input
                        type="text"
                        name="cedula"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

                <div>

                    <label class="block text-sm mb-2 font-medium">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        name="telefono"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

            </div>

            <div>

                <label class="block text-sm mb-2 font-medium">
                    Correo
                </label>

                <input
                    type="email"
                    name="correo"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="block text-sm mb-2 font-medium">
                    Domicilio
                </label>

                <input
                    type="text"
                    name="domicilio"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

            </div>

            <div class="grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm mb-2 font-medium">
                        Sexo
                    </label>

                    <select
                        name="sexo"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                        <option value="">
                            Seleccione
                        </option>

                        <option value="M">
                            Masculino
                        </option>

                        <option value="F">
                            Femenino
                        </option>

                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-2 font-medium">
                        Fecha de Nacimiento
                    </label>

                    <input
                        type="date"
                        name="fecha_nacimiento"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

            </div>

        </form>

        <!-- Footer -->

        <div
            class=" px-6 py-5 flex flex-col md:flex-row justify-end gap-3">

            <button
                type="button"
                id="btnCancelar"
                class="border border-slate-300 px-5 py-3 rounded-xl hover:bg-slate-100">

                Cancelar

            </button>

            <button
                type="submit"
                form="formPaciente"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

                Guardar Paciente

            </button>

        </div>

    </div>

</div>

<script src="/public/js/paciente.js"></script>