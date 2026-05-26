<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BellDente | Login</title>
    <link rel="stylesheet" href="/belldente/public/assets/css/style.css">
</head>
<body class="min-h-screen bg-[#f8f8f8] overflow-hidden">

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="relative min-h-screen flex items-center justify-center p-4">

        <!-- FONDO -->
        <div 
            class="absolute inset-0 bg-center bg-cover opacity-90"
            style="background-image: url('/belldente/public/assets/img/Fondo-login.png');"
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
            <form>

                <!-- USUARIO -->
                <div class="mb-4">

                    <input
                        type="text"
                        placeholder="Ingrese su nombre de usuario"
                        class="w-full border border-[#b8d8ff] rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#8dc7ff] transition"
                    >
                </div>

                <!-- PASSWORD -->
                <div class="mb-6">

                    <input
                        type="password"
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

</body>
</html>