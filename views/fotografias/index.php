<div class="space-y-6">

    <!-- Encabezado -->
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="text-3xl font-bold text-slate-800">
            Fotografías Clínicas
        </h2>

        <p class="text-slate-500 mt-1">
            Consulta y agrega fotografías clínicas asociadas
            a las atenciones odontológicas.
        </p>

    </div>


    <!-- Buscador -->
    <div class="bg-white rounded-2xl shadow-sm p-5">

        <input
            type="text"
            id="buscarFotografia"
            placeholder="Buscar por paciente o cédula..."
            class="w-full px-4 py-3 border border-slate-300 rounded-xl
                   focus:outline-none focus:ring-2 focus:ring-blue-500">

    </div>


    <!-- Tabla Desktop -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-blue-600 text-white">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            Paciente
                        </th>

                        <th class="px-6 py-4 text-left">
                            Cédula
                        </th>

                        <th class="px-6 py-4 text-center">
                            Fecha Atención
                        </th>

                        <th class="px-6 py-4 text-center">
                            Fotografías
                        </th>

                        <th class="px-6 py-4 text-center">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody id="tbllistadoFotografias">
                </tbody>

            </table>

        </div>

    </div>


    <!-- Cards Mobile -->
    <div
        id="cardsFotografias"
        class="grid gap-4 lg:hidden">
    </div>

</div>


<!-- ==================================================
     MODAL VER FOTOGRAFÍAS
================================================== -->
<div
    id="modalVerFotografias"
    class="fixed inset-0 z-50 hidden items-center justify-center
           bg-black/50 p-4">

    <div
        class="bg-white rounded-2xl shadow-xl
               w-full max-w-5xl max-h-[90vh]
               flex flex-col overflow-hidden">

        <!-- Header -->
        <div
            class="bg-blue-600 text-white
                   px-6 py-4
                   flex justify-between items-center">

            <div>

                <h3 class="text-xl font-bold">
                    Fotografías Clínicas
                </h3>

                <p
                    id="pacienteGaleria"
                    class="text-blue-100 text-sm mt-1">
                </p>

            </div>

            <button
                type="button"
                onclick="cerrarModalVerFotografias()"
                class="text-white text-2xl
                       hover:opacity-80">
                &times;
            </button>

        </div>


        <!-- Contenido -->
        <div class="p-6 overflow-y-auto">

            <div
                id="galeriaFotografias"
                class="grid grid-cols-1
                       sm:grid-cols-2
                       lg:grid-cols-3
                       gap-5">
            </div>

        </div>


        <!-- Footer -->
        <div
            class="border-t border-slate-200
                   px-6 py-4
                   flex justify-end">

            <button
                type="button"
                onclick="cerrarModalVerFotografias()"
                class="px-5 py-2.5
                       bg-slate-200
                       text-slate-700
                       rounded-xl
                       hover:bg-slate-300">
                Cerrar
            </button>

        </div>

    </div>

</div>

<!-- ==================================================
     VISOR DE FOTOGRAFÍA
================================================== -->
<div
    id="modalVisorFotografia"
    class="fixed inset-0 z-[70] hidden
           items-center justify-center
           bg-black/90 p-4">

    <!-- Cerrar -->
    <button
        type="button"
        onclick="cerrarVisorFotografia()"
        class="absolute top-4 right-4
               w-11 h-11
               flex items-center justify-center
               bg-white/10 hover:bg-white/20
               text-white text-3xl
               rounded-full
               z-10">

        &times;

    </button>


    <!-- Contenedor -->
    <div
        class="w-full max-w-6xl
               max-h-[95vh]
               flex flex-col
               items-center">

        <!-- Imagen -->
        <div
            class="w-full
                   flex items-center justify-center
                   overflow-hidden">

            <img
                id="imagenVisorFotografia"
                src=""
                alt="Fotografía clínica"
                class="max-w-full
                       max-h-[80vh]
                       object-contain
                       rounded-xl">

        </div>


        <!-- Información -->
        <div
            class="mt-4
                   max-w-3xl
                   text-center">

            <p
                id="nombreVisorFotografia"
                class="text-white
                       font-semibold">
            </p>

            <p
                id="observacionVisorFotografia"
                class="text-slate-300
                       text-sm mt-1">
            </p>

        </div>

    </div>

</div>

<!-- ==================================================
     MODAL AGREGAR FOTOGRAFÍAS
================================================== -->
<div
    id="modalAgregarFotografias"
    class="fixed inset-0 z-50 hidden items-center justify-center
           bg-black/50 p-4">

    <div
        class="bg-white rounded-2xl shadow-xl
               w-full max-w-4xl max-h-[90vh]
               flex flex-col overflow-hidden">

        <!-- Header -->
        <div
            class="bg-blue-600 text-white
                   px-6 py-4
                   flex justify-between items-center">

            <div>

                <h3 class="text-xl font-bold">
                    Agregar Fotografías
                </h3>

                <p
                    id="pacienteAgregarFotografia"
                    class="text-blue-100 text-sm mt-1">
                </p>

            </div>

            <button
                type="button"
                onclick="cerrarModalAgregarFotografias()"
                class="text-white text-2xl
                       hover:opacity-80">
                &times;
            </button>

        </div>


        <!-- Contenido -->
        <div class="p-6 overflow-y-auto">

            <input
                type="hidden"
                id="idAtencionFotografia">


            <!-- Selector -->
            <div
                class="border-2 border-dashed
                       border-slate-300
                       rounded-2xl
                       p-6
                       text-center">

                <p class="font-semibold text-slate-700">
                    Selecciona las fotografías clínicas
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Formatos permitidos:
                    JPG, JPEG, PNG y WEBP
                </p>

                <input
                    type="file"
                    id="inputFotografias"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    multiple
                    class="mt-4 block w-full
                           text-sm text-slate-600">

            </div>


            <!-- Previsualizaciones -->
            <div
                id="previewFotografias"
                class="grid grid-cols-1
                       md:grid-cols-2
                       gap-4 mt-6">
            </div>

        </div>


        <!-- Footer -->
        <div
            class="border-t border-slate-200
                   px-6 py-4
                   flex flex-col-reverse
                   sm:flex-row
                   justify-end gap-3">

            <button
                type="button"
                onclick="cerrarModalAgregarFotografias()"
                class="px-5 py-2.5
                       bg-slate-200
                       text-slate-700
                       rounded-xl
                       hover:bg-slate-300">

                Cancelar

            </button>

            <button
                type="button"
                id="btnGuardarFotografias"
                class="px-5 py-2.5
                       bg-blue-600
                       text-white
                       rounded-xl
                       hover:bg-blue-700">

                Guardar fotografías

            </button>

        </div>

    </div>

</div>


<!-- ==================================================
     MODAL MENSAJE
================================================== -->
<div
    id="modalMensajeFotografia"
    class="fixed inset-0 z-[60] hidden items-center justify-center
           bg-black/50 p-4">

    <div
        class="bg-white rounded-2xl shadow-xl
               w-full max-w-md overflow-hidden">

        <div
            id="modalMensajeFotografiaHeader"
            class="bg-blue-600 text-white px-6 py-4">

            <h3
                id="modalMensajeFotografiaTitulo"
                class="text-lg font-bold">
                Información
            </h3>

        </div>

        <div class="p-6">

            <p
                id="modalMensajeFotografiaTexto"
                class="text-slate-600">
            </p>

        </div>

        <div
            class="border-t border-slate-200
                   px-6 py-4
                   flex justify-end">

            <button
                type="button"
                onclick="cerrarMensajeFotografia()"
                class="px-5 py-2.5
                       bg-blue-600
                       text-white
                       rounded-xl
                       hover:bg-blue-700">

                Aceptar

            </button>

        </div>

    </div>

</div>


<script src="/public/js/fotografias.js"></script>