<header
    class="h-20 bg-white shadow-sm flex items-center justify-between px-6">

    <!-- Botón móvil -->

    <button
        id="btnMenu"
        class="lg:hidden text-2xl">

        ☰

    </button>

    <div>

        <h2 class="font-semibold text-slate-700">
            Dashboard
        </h2>

        <p class="text-sm text-slate-500">
            Bienvenido al sistema BellDente
        </p>

    </div>

    <div class="flex items-center gap-4">

        <div
            class="flex items-center gap-3">

            <div
                class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center">

                K

            </div>

            <div class="hidden md:block">

                <h4 class="font-medium">
                    <?php echo $_SESSION["nombre_usuario"]; ?>
                </h4>

                <p class="text-xs text-slate-500">
                   <?php echo $_SESSION["rol"]; ?>
                </p>

            </div>

        </div>

    </div>

</header>