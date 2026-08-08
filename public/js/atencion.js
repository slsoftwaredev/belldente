let listaCIE10 = [];
let listaTratamientos = [];
document.addEventListener("DOMContentLoaded", () => {
    cargarCita();
    listarAntecedentes();
    listarEstomatognatico();
    listarIndicadores();
    comboCIE10();
    comboTratamientos();
});

async function cargarCita() {

    const id_cita = document.getElementById("id_cita").value;

    if (!id_cita) return;

    const formData = new FormData();
    formData.append("id_cita", id_cita);

    const respuesta = await fetch("../ajax/atencion.php?op=obtener_cita", {
        method: "POST",
        body: formData
    });

    const data = await respuesta.json();

    document.getElementById("paciente").textContent =
        data.nombre_paciente + " " + data.apellido_paciente;

    document.getElementById("cedula").textContent = data.cedula_paciente;
    document.getElementById("fecha_nacimiento").textContent = data.fecha_nacimiento;
    document.getElementById("edad").textContent = data.edad_paciente;
    document.getElementById("telefono").textContent = data.telefono_paciente;
    document.getElementById("correo").textContent = data.correo_paciente;
    document.getElementById("direccion").textContent = data.direccion_paciente;
    document.getElementById("fecha_cita").textContent = data.fecha_cita;
    document.getElementById("estado_cita").textContent =
        data.nombre_estado ?? data.estado_cita;
}

// Funcionalidad de cancelar
document.getElementById("btnCancelar").addEventListener("click", () => {
    if (confirm("¿Cancelar la atención? Los cambios no guardados se perderán.")) {
        location.href = "citas.php";
    }
});

// ANTECEDENTES
// Función para listar los antecedentes
async function listarAntecedentes(){
    try{
        const respuesta = await fetch(
            "../ajax/atencion.php?op=listar_antecedentes"
        );
        const data = await respuesta.json();
        const personales = document.getElementById("antecedentes_personales");
        const familiares = document.getElementById("antecedentes_familiares");
        personales.innerHTML = "";
        familiares.innerHTML = "";
        data.forEach(antecedente => {
            const html = `
                <label class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        class="rounded border-slate-300"
                        value="${antecedente.id_antecedente}">
                    <span>${antecedente.nombre_antecedente}</span>
                </label>
            `;
            if (antecedente.id_tipo_antecedente == 1){
                personales.innerHTML += html;
            }else{
                familiares.innerHTML += html;
            }
        });
    }catch(error){
        console.error(error);
    }
}
// Función para listar el examen estomatognático
async function listarEstomatognatico(){
    try{
        const respuesta = await fetch(
            "../ajax/atencion.php?op=listar_estomatognatico"
        );
        const data = await respuesta.json();
        const contenedor = document.getElementById("examen_estomatognatico");
        contenedor.innerHTML = "";
        data.forEach(item => {
            contenedor.innerHTML += `
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        ${item.nombre_estructura}
                    </label>
                    <textarea
                        class="w-full border border-slate-300 rounded-xl p-3"
                        rows="2"
                        data-estructura="${item.id_estructura}"
                        placeholder="Sin alteraciones"></textarea>
                </div>
            `;
        });
    }catch(error){

        console.error(error);
    }
}

// INDICADORES DE SALUD
async function listarIndicadores(){

    const respuesta = await fetch("../ajax/atencion.php?op=listar_indicadores");
    const data = await respuesta.json();

    const contenedor = document.getElementById("indicadores_salud");

    contenedor.innerHTML = "";

    let tipoActual = "";
    let html = "";

    data.forEach((indicador, index) => {

        // Nuevo grupo
        if (tipoActual !== indicador.id_tipo_indicador) {

            // Cierra el select anterior
            if (tipoActual !== "") {
                html += `
                        </select>
                    </div>
                `;
            }

            tipoActual = indicador.id_tipo_indicador;

            html += `
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        ${indicador.nombre_tipo_indicador}
                    </label>

                    <select
                        class="w-full border border-slate-300 rounded-xl p-3"
                        data-tipo="${indicador.id_tipo_indicador}">

                        <option value="">
                            Seleccione...
                        </option>
            `;
        }

        // Agrega la opción
        html += `
            <option value="${indicador.id_indicador}">
                ${indicador.nombre_indicador}
            </option>
        `;

        // Cierra el último select
        if(index === data.length - 1){
            html += `
                    </select>
                </div>
            `;
        }

    });
    contenedor.innerHTML = html;
}
// ==========================================
// CARGAR CATÁLOGO CIE-10
// ==========================================

async function comboCIE10(){

    try{

        const respuesta = await fetch(

            "../ajax/atencion.php?op=combo_cie10"

        );

        listaCIE10 = await respuesta.json();

    }catch(error){

        console.error(error);

    }

}
// ==========================================
// CARGAR CATÁLOGO DE TRATAMIENTOS
// ==========================================

async function comboTratamientos(){

    try{

        const respuesta = await fetch(

            "../ajax/atencion.php?op=combo_tratamientos"

        );

        listaTratamientos = await respuesta.json();

    }catch(error){

        console.error(error);

    }

}
/* ==========================================
   AGREGAR DIAGNÓSTICO
========================================== */

document
.getElementById("btnAgregarDiagnostico")
.addEventListener("click", agregarDiagnostico);

async function agregarDiagnostico(){

    try{

        const respuesta = await fetch(
            "../ajax/atencion.php?op=combo_cie10"
        );

        const data = await respuesta.json();

        let opciones = `
            <option value="">
                Seleccione un diagnóstico
            </option>
        `;

        data.forEach(cie10 => {

            opciones += `
                <option value="${cie10.id_cie10}">
                    ${cie10.codigo_cie10} - ${cie10.descripcion_cie10}
                </option>
            `;

        });

        document
        .getElementById("listaDiagnosticos")
        .insertAdjacentHTML("beforeend",`

            <div class="border border-sky-700 rounded-2xl p-5 bg-slate-50 diagnostico">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

                    <div class="lg:col-span-6">

                        <label class="block text-sm font-medium mb-2">

                            Diagnóstico CIE-10

                        </label>

                        <select
                            name="cie10[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                            ${opciones}

                        </select>

                    </div>

                    <div class="lg:col-span-3">

                        <label class="block text-sm font-medium mb-2">

                            Tipo

                        </label>

                        <select
                            name="tipo_diagnostico[]"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                            <option value="P">

                                Presuntivo

                            </option>

                            <option value="D">

                                Definitivo

                            </option>

                        </select>

                    </div>

                    <div class="lg:col-span-3 flex items-end">

                        <button
                            type="button"
                            class="w-full bg-red-500 hover:bg-red-600 text-white rounded-xl py-3"
                            onclick="eliminarDiagnostico(this)">

                            Eliminar

                        </button>

                    </div>

                </div>

            </div>

        `);

    }catch(error){

        console.error(error);

    }

}
/* ==========================================
   ELIMINAR DIAGNÓSTICO
========================================== */

function eliminarDiagnostico(boton){

    boton
    .closest(".diagnostico")
    .remove();

}

document
.getElementById("btnAgregarTratamiento")
.addEventListener("click", agregarTratamiento);
/* ==========================================
   AGREGAR TRATAMIENTO
========================================== */

async function agregarTratamiento(){

    let opciones = `
        <option value="">
            Seleccione un tratamiento
        </option>
    `;

    listaTratamientos.forEach(tratamiento => {

        opciones += `
            <option
                value="${tratamiento.id_procedimiento}"
                data-valor="${tratamiento.costo_procedimiento}">

                ${tratamiento.nombre_procedimiento}

            </option>
        `;

    });

    document
    .getElementById("listaTratamientos")
    .insertAdjacentHTML("beforeend",`

        <div class="border border-sky-700 rounded-2xl p-5 bg-slate-50 tratamiento">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

                <div class="lg:col-span-5">

                    <label class="block text-sm font-medium mb-2">

                        Tratamiento

                    </label>

                    <select
                        name="tratamiento[]"
                        class="cmbTratamiento w-full border border-slate-300 rounded-xl px-4 py-3"
                        onchange="calcularSubtotal(this)">

                        ${opciones}

                    </select>

                </div>

                <div class="lg:col-span-2">

                    <label class="block text-sm font-medium mb-2">

                        Cantidad

                    </label>

                    <input
                        type="number"
                        name="cantidad[]"
                        value="1"
                        min="1"
                        class="cantidad w-full border border-slate-300 rounded-xl px-4 py-3"
                        oninput="calcularSubtotal(this)">

                </div>

                <div class="lg:col-span-2">

                    <label class="block text-sm font-medium mb-2">

                        Valor

                    </label>

                    <input
                        type="text"
                        name="valor[]"
                        readonly
                        class="valor w-full border border-slate-300 rounded-xl px-4 py-3 bg-slate-100">

                </div>

                <div class="lg:col-span-3 flex items-end">

                    <button
                        type="button"
                        class="w-full bg-red-500 hover:bg-red-600 text-white rounded-xl py-3"
                        onclick="eliminarTratamiento(this)">

                        Eliminar

                    </button>

                </div>

            </div>

        </div>

    `);

}
/* ==========================================
   CALCULAR VALOR
========================================== */

function calcularSubtotal(control){

    const fila = control.closest(".tratamiento");

    const combo = fila.querySelector(".cmbTratamiento");

    const cantidad = fila.querySelector(".cantidad");

    const valor = fila.querySelector(".valor");

    const precio = combo.options[combo.selectedIndex]
        .dataset.valor || 0;

    valor.value = (precio * cantidad.value).toFixed(2);

}
/* ==========================================
   ELIMINAR TRATAMIENTO
========================================== */

function eliminarTratamiento(boton){

    boton
    .closest(".tratamiento")
    .remove();

}
/*=========================================
AGREGAR FOTOGRAFÍA
=========================================*/

document
.getElementById("btnAgregarFotografia")
.addEventListener("click", agregarFotografia);

function agregarFotografia(){

    const lista =
    document.getElementById("listaFotografias");

    const fotografia =
    lista.querySelector(".fotografia");

    const copia =
    fotografia.cloneNode(true);

    // Limpiar controles

    copia
    .querySelector("select")
    .selectedIndex = 0;

    copia
    .querySelectorAll("input")
    .forEach(input => {

        input.value = "";

    });

    lista.appendChild(copia);

}
/*=========================================
ELIMINAR FOTOGRAFÍA
=========================================*/

document
.addEventListener("click", function(e){

    if(
        e.target.classList.contains("btnEliminarFotografia")
    ){

        const lista =
        document.getElementById("listaFotografias");

        // No permitir eliminar la última

        if(
            lista.querySelectorAll(".fotografia").length == 1
        ){

            alert("Debe existir al menos una fotografía.");

            return;

        }

        e.target
        .closest(".fotografia")
        .remove();

    }

});
/*=========================================
AGREGAR MEDICAMENTO
=========================================*/

document
.getElementById("btnAgregarMedicamento")
.addEventListener("click", agregarMedicamento);

function agregarMedicamento(){

    const lista =
    document.getElementById("listaMedicamentos");

    const medicamento =
    lista.querySelector(".medicamento");

    const copia =
    medicamento.cloneNode(true);

    copia
    .querySelectorAll("input")
    .forEach(input => {

        input.value = "";

    });

    lista.appendChild(copia);

}
/*=========================================
ELIMINAR MEDICAMENTO
=========================================*/

document
.addEventListener("click", function(e){

    if(
        e.target.classList.contains("btnEliminarMedicamento")
    ){

        const lista =
        document.getElementById("listaMedicamentos");

        if(
            lista.querySelectorAll(".medicamento").length == 1
        ){

            alert("Debe existir al menos un medicamento.");

            return;

        }

        e.target
        .closest(".medicamento")
        .remove();

    }

});
/*=========================================
MOSTRAR RESUMEN
=========================================*/

document.getElementById("btnFinalizar").addEventListener("click", mostrarResumen);

function mostrarResumen(){

   actualizarResumen();

    document
    .getElementById("modalResumen")
    .classList.remove("hidden");

    document
    .getElementById("modalResumen")
    .classList.add("flex");

}

/*=========================================
CERRAR RESUMEN
=========================================*/

document
.getElementById("btnCerrarResumen")
.addEventListener("click", cerrarResumen);

document
.getElementById("btnCancelarResumen")
.addEventListener("click", cerrarResumen);

function cerrarResumen(){

    document
    .getElementById("modalResumen")
    .classList.add("hidden");

    document
    .getElementById("modalResumen")
    .classList.remove("flex");

}

/*=========================================
ACTUALIZAR RESUMEN
=========================================*/

function actualizarResumen(){

    /*==============================
    DIAGNÓSTICOS
    ==============================*/
console.log(
    document.querySelectorAll("#listaDiagnosticos .diagnostico")
);
    let htmlDiagnosticos = "";

    document
    .querySelectorAll("#listaDiagnosticos .diagnostico")
    .forEach(item=>{

        const cie10 =
            item.querySelector("select[name='cie10[]']");

        const tipo =
            item.querySelector("select[name='tipo_diagnostico[]']");

        if(cie10 && cie10.value!=""){

            htmlDiagnosticos += `

                <div class="border-b pb-2 mb-2">

                    <strong>

                        ${cie10.options[cie10.selectedIndex].text}

                    </strong>

                    <br>

                    <span class="text-sm text-slate-500">

                        ${
                            tipo.value=="P"
                            ? "Presuntivo"
                            : "Definitivo"
                        }

                    </span>

                </div>

            `;

        }

    });

    if(htmlDiagnosticos==""){

        htmlDiagnosticos=`
            <p class="text-slate-500">
                Sin diagnósticos registrados.
            </p>
        `;

    }

    document.getElementById("resumenDiagnosticos").innerHTML =
        htmlDiagnosticos;


    /*==============================
    TRATAMIENTOS
    ==============================*/
    let htmlTratamientos="";

    let total=0;

    document
    .querySelectorAll("#listaTratamientos .tratamiento")
    .forEach(item=>{

        const tratamiento =
            item.querySelector("select[name='tratamiento[]']");

        const cantidad =
            Number(
                item.querySelector("input[name='cantidad[]']").value || 0
            );

        const subtotal =
            Number(
                item.querySelector("input[name='valor[]']").value || 0
            );

        if(tratamiento && tratamiento.value!=""){

            total += subtotal;

            htmlTratamientos += `

                <div class="border-b pb-2 mb-2">

                    <strong>

                        ${tratamiento.options[tratamiento.selectedIndex].text}

                    </strong>

                    <br>

                    Cantidad:
                    ${cantidad}

                    <br>

                    Subtotal:

                    <strong>

                        $ ${subtotal.toFixed(2)}

                    </strong>

                </div>

            `;

        }

    });

    if(htmlTratamientos==""){

        htmlTratamientos=`
            <p class="text-slate-500">
                Sin tratamientos registrados.
            </p>
        `;

    }

    document.getElementById("resumenTratamientos").innerHTML =
        htmlTratamientos;

    document.getElementById("lblTotalTratamientos").textContent =
        "$ "+total.toFixed(2);


    /*==============================
    FOTOGRAFÍAS
    ==============================*/

    let htmlFotos="";

    let cantidadFotos=0;

    document
    .querySelectorAll("#listaFotografias .fotografia")
    .forEach(item=>{

        const tipo =
            item.querySelector("select[name='tipo_fotografia[]']");

        const observacion =
            item.querySelector("input[name='observacion_fotografia[]']");

        const archivo =
            item.querySelector("input[name='fotografia[]']");

        if(archivo.files.length>0){

            cantidadFotos++;

            htmlFotos += `

                <div class="border-b pb-2 mb-2">

                    <strong>

                        ${tipo.value}

                    </strong>

                    <br>

                    ${observacion.value}

                    <br>

                    ${archivo.files[0].name}

                </div>

            `;

        }

    });

    if(cantidadFotos==0){

        htmlFotos=`
            <p class="text-slate-500">
                Sin fotografías registradas.
            </p>
        `;

    }

    document.getElementById("resumenFotografias").innerHTML =
        htmlFotos;


    /*==============================
    MEDICAMENTOS
    ==============================*/

    let htmlMedicamentos="";

    document
    .querySelectorAll("#listaMedicamentos .medicamento")
    .forEach(item=>{

        const medicamento =
            item.querySelector("input[name='medicamento[]']").value;

        if(medicamento!=""){

            htmlMedicamentos += `

                <div class="border-b pb-2 mb-2">

                    <strong>

                        ${medicamento}

                    </strong>

                    <br>

                    Dosis:
                    ${item.querySelector("input[name='dosis[]']").value}

                    <br>

                    Frecuencia:
                    ${item.querySelector("input[name='frecuencia[]']").value}

                    <br>

                    Duración:
                    ${item.querySelector("input[name='duracion[]']").value}

                    <br>

                    Indicaciones:
                    ${item.querySelector("input[name='indicaciones[]']").value}

                </div>

            `;

        }

    });

    if(htmlMedicamentos==""){

        htmlMedicamentos=`
            <p class="text-slate-500">
                Sin medicamentos registrados.
            </p>
        `;

    }

    document.getElementById("resumenMedicamentos").innerHTML =
        htmlMedicamentos;

}