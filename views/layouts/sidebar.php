<aside
    id="sidebar"
    class="fixed lg:static inset-y-0 left-0 z-50
           w-72 bg-white shadow-xl
           transform -translate-x-full
           lg:translate-x-0
           transition-transform duration-300">

    <!-- Logo -->

    <div class="bg-blue-600 h-20 flex items-center px-6">

        <div>

            <h1 class="text-xl font-bold text-white">
                BellDente
            </h1>

            <p class="text-xs text-slate-50">
                Centro Odontológico Familiar
            </p>

        </div>

    </div>

    <!-- Menú -->

    <nav class="p-4">

        <ul class="space-y-2">

            <li>
                <!-- Hace redireccionamiento a la página de escritorio y que se marque solo donde nos encontramos-->
                <a href="escritorio.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                    <?= ($pagina == 'dashboard')
                    ? 'bg-blue-50 text-blue-600 font-medium'
                    : 'hover:bg-slate-100'; ?>">
                        🏠 Dashboard
                </a>
            </li>

            <li>
                <a href="usuario.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                    <?= ($pagina == 'usuarios')
                    ? 'bg-blue-50 text-blue-600 font-medium'
                    : 'hover:bg-slate-100'; ?>">
                        👥 Usuarios
                </a>
            </li>

            <li>
                <a href="paciente.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                    <?= ($pagina == 'pacientes')
                    ? 'bg-blue-50 text-blue-600 font-medium'
                    : 'hover:bg-slate-100'; ?>">
                    👥 Pacientes
                </a>
            </li>

            <li>
                <a href="citas.php"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                    <?= ($pagina == 'citas')
                    ? 'bg-blue-50 text-blue-600 font-medium'
                    : 'hover:bg-slate-100'; ?>">
                    📅 Citas
                </a>
            </li>

            <li>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100">
                    🦷 Atención Clínica
                </a>
            </li>

            <li>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100">
                    📷 Fotografías Clínicas
                </a>
            </li>

            <li>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100">
                    💰 Pagos
                </a>
            </li>

            <li>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100">
                    📊 Reportes
                </a>
            </li>

            <li>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-100">
                    ⚙ Configuración
                </a>
            </li>

        </ul>
        <!-- Cerrar sesión -->

    <div class="pt-4 border-t border-slate-200">

        <a href="../ajax/logout.php"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
                   text-red-600 hover:bg-red-50 transition">

            🚪 Cerrar Sesión

        </a>

    </div>

    </nav>

</aside>