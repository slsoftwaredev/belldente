<div
    x-data="{ tab:'datos' }"
    class="space-y-6">

    <!-- CABECERA -->
<div class="bg-white rounded-2xl shadow-sm p-6">

    <div class="flex flex-col lg:flex-row lg:justify-between gap-4">

        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                Atención Clínica
            </h1>

            <p class="text-slate-500">
                Historia clínica odontológica
            </p>

        </div>

        <div class="flex gap-3">

            <button
                class="px-5 py-3 rounded-xl bg-blue-600 text-white">

                Guardar

            </button>

            <button
                class="px-5 py-3 rounded-xl bg-green-600 text-white">

                Finalizar

            </button>

        </div>

    </div>

</div>

    <!-- PESTAÑAS -->
<div class="bg-white rounded-2xl shadow-sm p-2 overflow-x-auto">

    <div class="flex gap-2 min-w-max">

        <button
            @click="tab='datos'"
            :class="tab==='datos'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Datos

        </button>

        <button
            @click="tab='antecedentes'"
            :class="tab==='antecedentes'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Antecedentes

        </button>

        <button
            @click="tab='examen'"
            :class="tab==='examen'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Examen

        </button>

        <button
            @click="tab='diagnostico'"
            :class="tab==='diagnostico'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Diagnóstico

        </button>

        <button
            @click="tab='odontograma'"
            :class="tab==='odontograma'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Odontograma

        </button>

    </div>

</div>

    <!-- CONTENIDO DE LAS PESTAÑAS -->
     <!-- DATOS -->
<div x-show="tab==='datos'" x-transition>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold text-slate-700 mb-4">
                Datos Personales
            </h2>

            <div class="grid gap-4">

                <input type="text" placeholder="Nombres"
                    class="border rounded-xl px-4 py-3">

                <input type="text" placeholder="Apellidos"
                    class="border rounded-xl px-4 py-3">

                <input type="text" placeholder="Cédula"
                    class="border rounded-xl px-4 py-3">

                <input type="date"
                    class="border rounded-xl px-4 py-3">

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold text-slate-700 mb-4">
                Información de Contacto
            </h2>

            <div class="grid gap-4">

                <input type="text" placeholder="Teléfono"
                    class="border rounded-xl px-4 py-3">

                <input type="email" placeholder="Correo"
                    class="border rounded-xl px-4 py-3">

                <textarea rows="4"
                    placeholder="Dirección"
                    class="border rounded-xl px-4 py-3"></textarea>

            </div>

        </div>

    </div>

</div>
        <!-- ANTECEDENTES -->
         <div x-show="tab==='antecedentes'" x-transition>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-5">
                Antecedentes Personales
            </h2>

            <div class="space-y-3">

                <label><input type="checkbox"> Diabetes</label>
                <label><input type="checkbox"> Hipertensión</label>
                <label><input type="checkbox"> Cardiopatías</label>
                <label><input type="checkbox"> Alergias</label>

            </div>

            <textarea
                rows="5"
                placeholder="Observaciones"
                class="w-full mt-5 border rounded-xl p-3"></textarea>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-5">
                Antecedentes Familiares
            </h2>

            <div class="space-y-3">

                <label><input type="checkbox"> Diabetes</label>
                <label><input type="checkbox"> Hipertensión</label>
                <label><input type="checkbox"> Cáncer</label>

            </div>

            <textarea
                rows="5"
                placeholder="Observaciones"
                class="w-full mt-5 border rounded-xl p-3"></textarea>

        </div>

    </div>

</div>

            <!-- EXAMEN CLÍNICO -->
<div x-show="tab==='examen'" x-transition>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-4">
                Signos Vitales
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-4">
                Sistema Estomatognático
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-4">
                Observaciones
            </h2>

        </div>

    </div>

</div>

            <!-- DIAGNÓSTICO -->
             <div x-show="tab==='diagnostico'" x-transition>

    <div class="space-y-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-4">
                Motivo de Consulta
            </h2>

            <textarea rows="4"
                class="w-full border rounded-xl p-3"></textarea>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-4">
                Enfermedad Actual
            </h2>

            <textarea rows="4"
                class="w-full border rounded-xl p-3"></textarea>

        </div>

    </div>

</div>

            <!-- ODONTOGRAMA -->
             <div x-show="tab==='odontograma'" x-transition>

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="font-semibold mb-4">
            Odontograma
        </h2>

    </div>