<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BellDente | Login</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="min-h-screen bg-[#f8f8f8] overflow-hidden">

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="relative min-h-screen flex items-center justify-center p-4">

        <!-- FONDO -->
        <div 
            class="absolute inset-0 bg-center bg-cover opacity-90"
            style="background-image: url('/public/assets/img/Fondo-login.png');"
        ></div>

        <!-- CAPA BLANCA -->
        <div class="absolute inset-0 bg-white/80"></div>

        <!-- CARD LOGIN -->
        <div 
            class="relative z-10 bg-white w-full max-w-md rounded-2xl shadow-2xl px-8 py-10 border border-gray-100"
        >

            <!-- LOGO -->
            <div class="flex justify-center mb-6">

                <div class="w-36 h-24 border border-gray-200 rounded-md"></div>

            </div>

            <!-- TITULO -->
            <div class="text-center mb-8">

                <h1 class="text-2xl md:text-3xl font-extrabold text-[#1e3a5f] leading-tight">
                    Sistema de Gestión
                </h1>

                <h2 class="text-2xl md:text-3xl font-extrabold text-[#1e3a5f]">
                    Clínica y Control de pagos
                </h2>

            </div>

            <!-- FORM -->
            <form id="formLogin" method="post" >

                <!-- USUARIO -->
                <div class="mb-4">

                    <input
                        type="text"
                        name="usuario"
                        required
                        placeholder="Ingrese su nombre de usuario"
                        class="w-full border border-[#b8d8ff] rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#8dc7ff] transition"
                    >
                </div>

                <!-- PASSWORD -->
                <div class="mb-6">

                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="Ingrese su contraseña"
                        class="w-full border border-[#b8d8ff] rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#8dc7ff] transition"
                    >
                </div>

                <!-- BOTON -->
                <button
                    type="submit"
                    class="w-full bg-[#9fd1ff] hover:bg-[#8ac6fb] text-[#1e3a5f] font-semibold py-3 rounded-full transition duration-300 shadow-md"
                >
                    Ingresar
                </button>

            </form>

            <!-- FOOTER -->
            <div class="mt-8 text-center">

                <p class="text-[11px] text-gray-500">
                    Desarrollado por 
                    <span class="font-semibold text-[#1e3a5f]">
                        Kevin Stalin Lema Conejo
                    </span>
                </p>

            </div>

        </div>

    </div>

    <!-- MODAL LOGIN -->
<div
    id="modalLogin"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center p-4 z-50">

    <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden">

        <!-- Header -->
        <div class="bg-[#1e3a5f] px-6 py-5">

            <div class="flex items-center gap-4">

                <div
                    class="w-12 h-12 bg-white/15 rounded-full flex items-center justify-center">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                        />

                    </svg>

                </div>

                <div>

                    <h2 class="text-xl font-bold text-white">
                        No se pudo iniciar sesión
                    </h2>

                    <p class="text-sm text-white/70">
                        BellDente
                    </p>

                </div>

            </div>

        </div>

        <!-- Contenido -->
        <div class="p-6">

            <p
                id="mensajeLogin"
                class="text-slate-600 text-sm leading-relaxed">
                Usuario o contraseña incorrectos.
            </p>

        </div>

        <!-- Footer -->
        <div class="px-6 pb-6 flex justify-end">

            <button
                type="button"
                id="btnCerrarModalLogin"
                class="bg-[#1e3a5f] hover:bg-[#162c49] text-white px-6 py-2.5 rounded-xl transition">

                Intentar nuevamente

            </button>

        </div>

    </div>

</div>
</body>
<script src="/public/js/login.js"></script>
</html>