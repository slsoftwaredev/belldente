<div class="space-y-6">

    <!-- Encabezado -->
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    Usuarios
                </h1>

                <p class="text-slate-500 mt-1">
                    Administración de usuarios del sistema BellDente
                </p>

            </div>

            <button
                id="btnNuevoUsuario"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-medium transition">

                + Nuevo Usuario

            </button>

        </div>

    </div>

    <!-- Buscador -->
    <div class="bg-white rounded-2xl shadow-sm p-5">

        <input
            type="text"
            id="txtBuscar"
            placeholder="Buscar usuario..."
            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">

    </div>

    <!-- Tabla Desktop -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Nombre Completo
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Usuario
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Rol
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Estado
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody id="tblUsuarios">

                </tbody>

            </table>

        </div>

    </div>

    <!-- Vista móvil -->
    <div
        id="cardUsuarios"
        class="grid gap-4 lg:hidden">

    </div>

</div>

<!-- Modal Usuario -->

<div
    id="modalUsuario"
    class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50">

    <div
        class="bg-white rounded-3xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">

        <!-- Header -->

        <div
            class="border-b px-6 py-5 flex items-center justify-between">

            <div>

                <h2
                    id="tituloModal"
                    class="text-xl font-bold text-slate-800">

                    Nuevo Usuario

                </h2>

                <p class="text-sm text-slate-500">

                    Complete la información del usuario

                </p>

            </div>

            <button
                type="button"
                id="btnCerrarModal"
                class="text-3xl text-slate-400 hover:text-red-500">

                ×

            </button>

        </div>

        <!-- Formulario -->

        <form
            id="formUsuario"
            class="p-6 space-y-5">

            <input
                type="hidden"
                id="id_usuario"
                name="id_usuario"
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
                        Usuario
                    </label>

                    <input
                        type="text"
                        name="usuario"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

                <div>

                    <label class="block text-sm mb-2 font-medium">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

            </div>

            <div>

                <label class="block text-sm mb-2 font-medium">
                    Rol
                </label>

                <select
                    id="rol"
                    name="rol"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    <option value="">
                        Seleccione un rol
                    </option>

                    <option value="1">
                        Administrador
                    </option>

                    <option value="2">
                        Dentista
                    </option>

                    <option value="3">
                        Recepcionista
                    </option>

                </select>

            </div>

        </form>

        <!-- Footer -->

        <div
            class="border-t px-6 py-5 flex flex-col md:flex-row justify-end gap-3">

            <button
                type="button"
                id="btnCancelar"
                class="border border-slate-300 px-5 py-3 rounded-xl hover:bg-slate-100">

                Cancelar

            </button>

            <button
                type="submit"
                form="formUsuario"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

                Guardar Usuario

            </button>

        </div>

    </div>

</div>

<script src="/public/js/usuario.js"></script>