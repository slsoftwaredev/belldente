<div
    x-data="{ tab:'datos' }"
    class="w-full max-w-7xl mx-auto space-y-6">

    <!-- CABECERA -->
<div class="bg-white rounded-2xl shadow-sm p-6">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between ">

        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                Atención Clínica
            </h1>

            <p class="text-slate-500">
                Historia clínica odontológica
            </p>

        </div>

        <div class="flex flex-col sm:flex-row gap-3">

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

    <div class="flex flex-col sm:flex-row gap-2 min-w-max">

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
            @click="tab='odontograma'"
            :class="tab==='odontograma'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Odontograma

        </button>

        <button
            @click="tab='diagnostico'"
            :class="tab==='diagnostico'
            ? 'bg-blue-600 text-white'
            : 'hover:bg-slate-100'"
            class="px-4 py-2 rounded-xl">

            Diagnóstico

        </button>
    </div>

</div>

    <!-- CONTENIDO DE LAS PESTAÑAS -->
     <!-- DATOS -->
<div x-show="tab==='datos'" x-transition>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold text-slate-700 mb-4">
                Información del Paciente
            </h2>

            <div class="space-y-3 text-sm">

                <p>
                    <span class="font-medium">Paciente:</span>
                    Juan Pérez
                </p>

                <p>
                    <span class="font-medium">Cédula:</span>
                    1000000001
                </p>

                <p>
                    <span class="font-medium">Fecha Nacimiento:</span>
                    15/05/1995
                </p>

                <p>
                    <span class="font-medium">Edad:</span>
                    31 años
                </p>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold text-slate-700 mb-4">
                Contacto
            </h2>

            <div class="space-y-3 text-sm">

                <p>
                    <span class="font-medium">Teléfono:</span>
                    0999999999
                </p>

                <p>
                    <span class="font-medium">Correo:</span>
                    correo@email.com
                </p>

                <p>
                    <span class="font-medium">Dirección:</span>
                    Otavalo
                </p>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold text-slate-700 mb-4">
                Atención
            </h2>

            <div class="space-y-3 text-sm">

                <p>
                    <span class="font-medium">Establecimiento:</span>
                    BellDente
                </p>

                <p>
                    <span class="font-medium">Fecha:</span>
                    21/06/2026
                </p>

                <p>
                    <span class="font-medium">Estado:</span>
                    En Atención
                </p>

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
                    <select name="" id="" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                        <option value="">Alergia Antibiótico</option>
                        <option value="">Alergia Anestésico</option>
                        <option value="">Hemorragias</option>
                        <option value="">VIH/SIDA</option>
                        <option value="">Tuberculosis</option>
                        <option value="">Asma</option>
                        <option value="">Diabetes</option>
                        <option value="">Hipertensión Arterial</option>
                        <option value="">Enfermedades Cardíacas</option>
                        <option value="">Otro</option>
                        <option value="">Ninguno</option>
                    </select>

            </div>

            <input
                type="text"
                placeholder="Observaciones"
                class="w-full mt-5 border rounded-xl p-3">

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-5">
                Antecedentes Familiares
            </h2>

            <div class="space-y-3">

                <select class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    <option>Cardiopatía</option>
                    <option>Hipertensión Arterial</option>
                    <option>Enfermedad Cardiovascular</option>
                    <option>Cancer</option>
                    <option>Tuberculosis</option>
                    <option>Enfermedad Mental</option>
                    <option>Enfermedad Infecciosa</option>
                    <option>Mal Formación</option>
                    <option>Otro</option>
                    <option>Ninguno</option>
                </select>
                

            </div>

            <input
                type="text"
                placeholder="Observaciones"
                class="w-full mt-5 border rounded-xl p-3">

        </div>

    </div>

</div>

            <!-- EXAMEN CLÍNICO -->
<div x-show="tab==='examen'" x-transition>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-5">
                Signos Vitales
            </h2>

            <div class="grid gap-4">
                <p>Presión Arterial</p>
                <input
                    type="text"
                    placeholder="Presión Arterial"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">
                <p>Frecuencia Cardíaca</p>
                <input
                    type="text"
                    placeholder="Frecuencia Cardíaca"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">
                <p>Frecuencia Respiratoria</p>
                <input
                    type="text"
                    placeholder="Frecuencia Respiratoria"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">
                <p>Temperatura</p>
                <input
                    type="text" 
                    placeholder="Temperatura"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">
                <p>Saturación O₂</p>
                <input
                    type="text"
                    placeholder="Saturación O₂"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-5">
                Examen Estomatognático
            </h2>

            <div class="grid gap-4">
                <select name="examen" id="" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    <option value="">Seleccione una opción</option>
                    <option value="labios">Labios</option>
                    <option value="mejillas">Mejillas</option>
                    <option value="maxilar_superior">Maxilar Superior</option>
                    <option value="maxilar_inferior">Maxilar Inferior</option>
                    <option value="lengua">Lengua</option>
                    <option value="paladar">Paladar</option>
                    <option value="piso_boca">Piso de la Boca</option>
                    <option value="carrillos">Carrillos</option>
                    <option value="glandulas_salivales">Glándulas Salivales</option>
                    <option value="oro_faringe">Oro Faringe</option>
                    <option value="atm">ATM</option>
                    <option value="ganglios">Ganglios</option>
                    <option value="otros">Otros</option>
                    <option value="ninguno">Ninguno</option>
                </select>
                <input
                    type="text"
                    placeholder="Descripción"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

            </div>

        </div>

    </div>

</div>

            <!-- ODONTOGRAMA -->
             <div x-show="tab==='odontograma'" x-transition>

    <div class="bg-cyan-100 border-2border-slate-600">
        <!-- Título -->

        <div class="bg-violet-200 border-b-2 border-slate-600 px-4 py-2">
            <h2 class="font-semibold mb-5">
                ODONTOGRAMA
            </h2>

        </div>
        <!-- Contenido -->
        <div class="p-4">
            <?php include "components/odontograma.php"; ?>  
        </div>
        

    </div>

</div>

<!-- DIAGNÓSTICO -->
<div x-show="tab==='diagnostico'" x-transition>
    <div class="bg-white rounded-2xl shadow-sm p-6">

            <h2 class="font-semibold mb-4">
                Diagnóstico
            </h2>
            <button class="px-4 py-2 rounded-xl bg-green-600 text-white mb-4">
                Agregar Diagnóstico
            </button>
            <select class="w-full border border-slate-300 rounded-xl px-4 py-3 mb-4">
                <option>Diagnóstico 1</option>
                <option>Diagnóstico 2</option>
                <option>Diagnóstico 3</option>
            </select>

            <label><input type="radio" name="diagnostico"> PREDICTIVO</label>
            <label><input type="radio" name="diagnostico"> DEFINITIVO</label>
</div>
</div>


<script src="/public/js/odontograma.js"></script>