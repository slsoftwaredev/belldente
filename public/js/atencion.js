let listaCIE10 = [];
let listaTratamientos = [];
let idAtencionActual = null;
document.addEventListener("DOMContentLoaded", () => {
    cargarCita();
    listarAntecedentes();
    listarEstomatognatico();
    listarIndicadores();
    comboCIE10();
    comboTratamientos();
    cargarHigieneOral();
    crearAtencion();

});
//FUNCION CARGAR CITA
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
// ======================================================
// HIGIENE ORAL SIMPLIFICADA
// ======================================================
const piezasHigieneOral = [
    ["16", "17", "55"],
    ["11", "21", "51"],
    ["26", "27", "65"],
    ["36", "37", "75"],
    ["31", "41", "71"],
    ["46", "47", "85"]
];

function cargarHigieneOral(){
    const contenedor = document.getElementById("higieneOralSimplificada");
    if (!contenedor) return;
    contenedor.innerHTML = "";
    piezasHigieneOral.forEach((piezas, index) => {
        contenedor.innerHTML += `
            <div class="fila-higiene grid grid-cols-1 md:grid-cols-12 gap-4 px-5 py-4 items-center">
                <!-- PIEZAS -->
                <div class="md:col-span-5">
                    <span class="block md:hidden text-sm font-semibold mb-2">
                        Pieza examinada
                    </span>
                    <div class="flex flex-wrap gap-4">
                        ${piezas.map(pieza => `

    <div class="flex items-center gap-2">

        <!-- PIEZA EXAMINADA -->
        <label
            class="flex items-center gap-1 cursor-pointer"
            title="Pieza examinada">

            <input
                type="checkbox"
                name="pieza_higiene_${index}"
                value="${pieza}"
                class="pieza-higiene w-4 h-4">

            <span class="font-medium">
                ${pieza}
            </span>

        </label>

        <!-- PIEZA AUSENTE -->
        <button
            type="button"
            class="pieza-ausente border border-slate-300 hover:bg-slate-200 rounded-lg px-2 py-1 text-slate-600"
            data-pieza="${pieza}"
            title="Marcar pieza como ausente">
            —
        </button>

    </div>

`).join("")}
                    </div>
                </div>

                <!-- PLACA -->
                <div class="md:col-span-2">
                    <label class="block md:hidden text-sm font-semibold mb-2">
                        Placa
                    </label>
                    <select
                        class="placa-higiene w-full border border-slate-300 rounded-xl p-3"
                        disabled>
                        <option value="">-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>

                <!-- CÁLCULO -->
                <div class="md:col-span-2">
                    <label class="block md:hidden text-sm font-semibold mb-2">
                        Cálculo
                    </label>
                    <select
                        class="calculo-higiene w-full border border-slate-300 rounded-xl p-3"
                        disabled>
                        <option value="">-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>

                <!-- GINGIVITIS -->
                <div class="md:col-span-3">
                    <label class="block md:hidden text-sm font-semibold mb-2">
                        Gingivitis
                    </label>
                    <select
                        class="gingivitis-higiene w-full border border-slate-300 rounded-xl p-3"
                        disabled>
                        <option value="">-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                    </select>
                </div>
            </div>
        `;
    });
}
// ======================================================
// EVENTOS HIGIENE ORAL SIMPLIFICADA
// ======================================================

document.getElementById("higieneOralSimplificada")?.addEventListener("change", function(e){
    const fila = e.target.closest(".fila-higiene");
    if (!fila) return;
    // Seleccionó una pieza dental
    if(e.target.classList.contains("pieza-higiene")){
    const piezas =
        fila.querySelectorAll(".pieza-higiene");
    // Si acaba de marcar una pieza,
    // desmarcar las demás de la misma fila
    if(e.target.checked){
        piezas.forEach(pieza => {
            if(pieza !== e.target){
                pieza.checked = false;
            }
        });
    }

    const hayPiezaSeleccionada =
        fila.querySelector(".pieza-higiene:checked");
    const placa =
        fila.querySelector(".placa-higiene");
    const calculo =
        fila.querySelector(".calculo-higiene");
    const gingivitis =
        fila.querySelector(".gingivitis-higiene");

    if(hayPiezaSeleccionada){
        placa.disabled = false;
        calculo.disabled = false;
        gingivitis.disabled = false;
    }else{
        // Si quitó el check, limpiar la fila
        placa.value = "";
        calculo.value = "";
        gingivitis.value = "";

        placa.disabled = true;
        calculo.disabled = true;
        gingivitis.disabled = true;
    }
    calcularPromediosHigiene();
}

    // Cambió placa, cálculo o gingivitis
    if(
        e.target.classList.contains("placa-higiene") ||
        e.target.classList.contains("calculo-higiene") ||
        e.target.classList.contains("gingivitis-higiene")
    ){
        calcularPromediosHigiene();
    }
});

// ======================================================
// PIEZAS AUSENTES - HIGIENE ORAL
// ======================================================

document.getElementById("higieneOralSimplificada")?.addEventListener("click", function(e){

    const boton = e.target.closest(".pieza-ausente");

    if(!boton) return;

    const fila = boton.closest(".fila-higiene");

    const pieza = boton.dataset.pieza;

    const checkbox = fila.querySelector(
        `.pieza-higiene[value="${pieza}"]`
    );


    // CAMBIAR ESTADO AUSENTE
    boton.classList.toggle("ausente");

    const esAusente =
        boton.classList.contains("ausente");


    if(esAusente){

        // Mostrar visualmente la raya activa
        boton.classList.add(
            "bg-slate-700",
            "text-white",
            "border-slate-700"
        );

        // No puede estar examinada y ausente
        checkbox.checked = false;

        checkbox.disabled = true;

    }else{

        boton.classList.remove(
            "bg-slate-700",
            "text-white",
            "border-slate-700"
        );

        checkbox.disabled = false;

    }


    // COMPROBAR SI QUEDA ALGUNA PIEZA EXAMINADA
    const piezaSeleccionada =
        fila.querySelector(".pieza-higiene:checked");

    const placa =
        fila.querySelector(".placa-higiene");

    const calculo =
        fila.querySelector(".calculo-higiene");

    const gingivitis =
        fila.querySelector(".gingivitis-higiene");


    if(!piezaSeleccionada){

        placa.value = "";
        calculo.value = "";
        gingivitis.value = "";

        placa.disabled = true;
        calculo.disabled = true;
        gingivitis.disabled = true;

    }

    calcularPromediosHigiene();

});

// ======================================================
// CALCULAR PROMEDIOS HIGIENE ORAL
// ======================================================

function calcularPromediosHigiene(){

    const filas =
        document.querySelectorAll(".fila-higiene");

    let totalPlaca = 0;

    let totalCalculo = 0;

    let totalGingivitis = 0;

    let piezasExaminadas = 0;


    filas.forEach(fila => {

        const pieza =
            fila.querySelector(".pieza-higiene:checked");

        if(!pieza) return;


        const placa =
            fila.querySelector(".placa-higiene").value;

        const calculo =
            fila.querySelector(".calculo-higiene").value;

        const gingivitis =
            fila.querySelector(".gingivitis-higiene").value;


        if(
            placa !== "" &&
            calculo !== "" &&
            gingivitis !== ""
        ){

            totalPlaca += Number(placa);

            totalCalculo += Number(calculo);

            totalGingivitis += Number(gingivitis);

            piezasExaminadas++;

        }

    });


    const promedioPlaca =
        piezasExaminadas > 0
        ? totalPlaca / piezasExaminadas
        : 0;


    const promedioCalculo =
        piezasExaminadas > 0
        ? totalCalculo / piezasExaminadas
        : 0;


    const promedioGingivitis =
        piezasExaminadas > 0
        ? totalGingivitis / piezasExaminadas
        : 0;


    document.getElementById("promedioPlaca").textContent =
        promedioPlaca.toFixed(2);


    document.getElementById("promedioCalculo").textContent =
        promedioCalculo.toFixed(2);


    document.getElementById("promedioGingivitis").textContent =
        promedioGingivitis.toFixed(2);

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

document.getElementById("btnAgregarDiagnostico").addEventListener("click", agregarDiagnostico);
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

document.getElementById("btnAgregarTratamiento").addEventListener("click", agregarTratamiento);
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

// ======================================================
// COMPLICACIONES
// ======================================================
document.getElementById("btnAgregarComplicacion")?.addEventListener("click", function () {

    const lista = document.getElementById("listaComplicaciones");

    const nuevaComplicacion = document.createElement("div");

    nuevaComplicacion.className =
        "complicacion border rounded-2xl p-5 border-sky-700 bg-slate-50";

    nuevaComplicacion.innerHTML = `
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">

            <div class="lg:col-span-10">
                <label class="block text-sm font-medium mb-2">
                    Complicación
                </label>

                <input
                    placeholder="Ingrese la complicación"
                    type="text"
                    name="complicacion[]"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">
            </div>

            <div class="lg:col-span-2">
                <button
                    type="button"
                    class="btnEliminarComplicacion w-full bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-xl">
                    Eliminar
                </button>
            </div>
        </div>
    `;
    lista.appendChild(nuevaComplicacion);
});
// Boton eliminar de complicacion
document.getElementById("listaComplicaciones")?.addEventListener("click", function (e) {

    if (e.target.classList.contains("btnEliminarComplicacion")) {

        const complicacion = e.target.closest(".complicacion");

        if (complicacion) {
            complicacion.remove();
        }

    }

});

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
/*=========================================
AGREGAR FOTOGRAFÍA
=========================================*/
document.getElementById("btnAgregarFotografia").addEventListener("click", agregarFotografia);
function agregarFotografia(){
    const lista =document.getElementById("listaFotografias");
    const fotografia =lista.querySelector(".fotografia");
    const copia =fotografia.cloneNode(true);
    // Limpiar todos los inputs de la copia
    copia.querySelectorAll("input").forEach(input => {
        input.value = "";
    });
    lista.appendChild(copia);
}

/*=========================================
ELIMINAR FOTOGRAFÍA
=========================================*/
document.addEventListener("click", function(e){

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
document.getElementById("btnAgregarMedicamento").addEventListener("click", agregarMedicamento);
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
document.addEventListener("click", function(e){
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
document.getElementById("btnFinalizar").addEventListener("click", function(){
    const datos =recopilarDatosAtencion();
    console.log("DATOS COMPLETOS DE LA ATENCIÓN:");
    console.log(datos);
    console.log(JSON.stringify(datos, null, 2));
    mostrarResumen();
});
function mostrarResumen(){
   actualizarResumen();
    document.getElementById("modalResumen").classList.remove("hidden");
    document.getElementById("modalResumen").classList.add("flex");
}

/*=========================================
CERRAR RESUMEN
=========================================*/
document.getElementById("btnCerrarResumen").addEventListener("click", cerrarResumen);
document.getElementById("btnCancelarResumen").addEventListener("click", cerrarResumen);
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
console.log(document.querySelectorAll("#listaDiagnosticos .diagnostico"));
    let htmlDiagnosticos = "";
    document.querySelectorAll("#listaDiagnosticos .diagnostico").forEach(item=>{
        const cie10 =item.querySelector("select[name='cie10[]']");
        const tipo =item.querySelector("select[name='tipo_diagnostico[]']");
        if(cie10 && cie10.value!=""){
            htmlDiagnosticos += `
                <div class="border-b pb-2 mb-2">
                    <strong>
                        ${cie10.options[cie10.selectedIndex].text}
                    </strong>
                    <br>
                    <span class="text-sm text-slate-500">
                        ${
                            tipo.value=="P"? "Presuntivo": "Definitivo"
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
    document.getElementById("resumenDiagnosticos").innerHTML =htmlDiagnosticos;

/*==============================
    TRATAMIENTOS
==============================*/
    let htmlTratamientos="";
    let total=0;
    document.querySelectorAll("#listaTratamientos .tratamiento").forEach(item=>{
        const tratamiento =item.querySelector("select[name='tratamiento[]']");
        const cantidad =Number(item.querySelector("input[name='cantidad[]']").value || 0);
        const subtotal =Number(item.querySelector("input[name='valor[]']").value || 0);
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
    document.getElementById("resumenTratamientos").innerHTML =htmlTratamientos;
    document.getElementById("lblTotalTratamientos").textContent ="$ "+total.toFixed(2);

/*==============================
    FOTOGRAFÍAS
==============================*/
let htmlFotos = "";
let cantidadFotos = 0;
document.querySelectorAll("#listaFotografias .fotografia").forEach(item => {
    const observacion =item.querySelector("input[name='observacion_fotografia[]']");
    const archivo =item.querySelector("input[name='fotografia[]']");
    if(archivo &&archivo.files.length > 0){
        cantidadFotos++;
        htmlFotos += `
            <div class="border-b pb-2 mb-2">
                <strong>
                    ${archivo.files[0].name}
                </strong>
                <br>
                <span class="text-sm text-slate-500">
                    ${
                        observacion && observacion.value.trim() !== ""
                        ? observacion.value
                        : "Sin observación"
                    }
                </span>
            </div>
        `;
    }
});

if(cantidadFotos === 0){
    htmlFotos = `
        <p class="text-slate-500">
            Sin fotografías registradas.
        </p>
    `;
}
document.getElementById("resumenFotografias").innerHTML = htmlFotos;

/*==============================
    MEDICAMENTOS
==============================*/
    let htmlMedicamentos="";
    document.querySelectorAll("#listaMedicamentos .medicamento").forEach(item=>{
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
    document.getElementById("resumenMedicamentos").innerHTML = htmlMedicamentos;
}
//RECOPILAMOS DATOS
function recopilarDatosAtencion() {
    /* =========================================
       ANTECEDENTES PERSONALES
    ========================================= */
    const antecedentesPersonales = [];
    document.querySelectorAll("#antecedentes_personales input[type='checkbox']:checked").forEach(check => {
        antecedentesPersonales.push(Number(check.value));
    });

    /* =========================================
       ANTECEDENTES FAMILIARES
    ========================================= */
    const antecedentesFamiliares = [];
    document.querySelectorAll("#antecedentes_familiares input[type='checkbox']:checked").forEach(check => {
        antecedentesFamiliares.push(Number(check.value));
    });

    /* =========================================
       EXAMEN ESTOMATOGNÁTICO
    ========================================= */
    const estomatognatico = [];
    document.querySelectorAll("#examen_estomatognatico textarea").forEach(campo => {
        // Solo agregamos estructuras que tengan información
        if (campo.value.trim() !== "") {
            estomatognatico.push({estructura_id:
                    Number(campo.dataset.estructura),observacion:campo.value.trim()
            });
        }
    });

    /* =========================================
       INDICADORES DE SALUD BUCAL
    ========================================= */
    const indicadores = [];
    document.querySelectorAll("#indicadores_salud select").forEach(select => {
        if (select.value !== "") {
            indicadores.push({
                tipo_indicador_id:Number(select.dataset.tipo),
                indicador_id:Number(select.value)
            });
        }
    });

    /* =========================================
       HIGIENE ORAL SIMPLIFICADA
    ========================================= */
    const higieneOral = [];
    document.querySelectorAll(".fila-higiene").forEach(fila => {
        const pieza =fila.querySelector(".pieza-higiene:checked");
        if (!pieza) {
            return;
        }
        higieneOral.push({
            pieza:pieza.value,
            placa:fila.querySelector(".placa-higiene").value,
            calculo:fila.querySelector(".calculo-higiene").value,
            gingivitis:fila.querySelector(".gingivitis-higiene").value
        });
    });

    /* =========================================
       DIAGNÓSTICOS
    ========================================= */
    const diagnosticos = [];
    document.querySelectorAll("#listaDiagnosticos .diagnostico").forEach(item => {
        const cie10 =item.querySelector("select[name='cie10[]']");
        const tipo =item.querySelector("select[name='tipo_diagnostico[]']");
        if (cie10 && cie10.value !== "") {
            diagnosticos.push({
                cie10_id:Number(cie10.value),
                tipo:tipo.value
            });
        }
    });

    /* =========================================
       TRATAMIENTOS
    ========================================= */
    const tratamientos = [];
    document.querySelectorAll("#listaTratamientos .tratamiento").forEach(item => {
        const tratamiento =item.querySelector("select[name='tratamiento[]']");
        if (tratamiento &&tratamiento.value !== "") {
            tratamientos.push({
                procedimiento_id:Number(tratamiento.value),
                cantidad:Number(item.querySelector("input[name='cantidad[]']").value || 0),
                subtotal:Number(item.querySelector("input[name='valor[]']").value || 0)
            });
        }
    });

    /* =========================================
       COMPLICACIONES
    ========================================= */
    const complicaciones = [];
    document.querySelectorAll("#listaComplicaciones .complicacion").forEach(item => {
        const input =item.querySelector("input[name='complicacion[]']");
        if (input &&input.value.trim() !== "") {
            complicaciones.push(input.value.trim());
        }
    });

    /* =========================================
       PRESCRIPCIÓN
    ========================================= */
    const prescripcion = [];
    document.querySelectorAll("#listaMedicamentos .medicamento").forEach(item => {
        const medicamento =item.querySelector("input[name='medicamento[]']").value.trim();
        if (medicamento !== "") {
            prescripcion.push({
                medicamento: medicamento,
                dosis:item.querySelector("input[name='dosis[]']").value.trim(),
                frecuencia:item.querySelector("input[name='frecuencia[]']").value.trim(),
                duracion:item.querySelector("input[name='duracion[]']").value.trim(),
                indicaciones:item.querySelector("input[name='indicaciones[]']").value.trim()
            });
        }
    });

    /* =========================================
       EXÁMENES INFORMADOS
    ========================================= */
    const tiposExamen = [];
    document.querySelectorAll("input[type='checkbox'][value='BIOMETRIA'], " +"input[type='checkbox'][value='QUIMICA_SANGUINEA'], " +
        "input[type='checkbox'][value='RAYOS_X'], " +
        "input[type='checkbox'][value='OTROS']"
    )
    .forEach(check => {
        if (check.checked) {
            tiposExamen.push(check.value);
        }
    });

/* =========================================
   FOTOGRAFÍAS - METADATOS
========================================= */
const fotografias = [];
document.querySelectorAll("#listaFotografias .fotografia").forEach(item => {
    const archivo =item.querySelector("input[name='fotografia[]']");
    const observacion =item.querySelector("input[name='observacion_fotografia[]']");
    if (archivo &&archivo.files.length > 0) {
        fotografias.push({nombre_archivo:archivo.files[0].name,observacion:observacion? observacion.value.trim(): ""});
    }
});

    /* =========================================
       OBJETO COMPLETO
    ========================================= */
    let datosOdontograma = null;
const elementoOdontograma = document.getElementById("odontograma");
if (elementoOdontograma) {
    const componenteOdontograma =Alpine.$data(elementoOdontograma);
    if (componenteOdontograma &&typeof componenteOdontograma.obtenerDatosOdontograma === "function") {
        datosOdontograma =componenteOdontograma.obtenerDatosOdontograma();
    }
}
console.log("ODONTOGRAMA CAPTURADO:",datosOdontograma);
    const datos = {
        id_atencion:Number(idAtencionActual),
        id_cita:Number(document.getElementById("id_cita").value),
        antecedentes: {
            personales: antecedentesPersonales,
            observacion_personal:document.getElementById("observacion_personal").value.trim(),
            familiares:antecedentesFamiliares,
            observacion_familiar:document.getElementById("observacion_familiar").value.trim()
        },
        examen_clinico: {
            temperatura:document.getElementById("temperatura").value,
            pulso:document.getElementById("pulso").value,
            frecuencia_respiratoria:document.getElementById("frecuencia_respiratoria").value,
            presion_arterial:document.getElementById("presion_arterial").value,
            pedido_examen_complementario:document.getElementById("pedido_examen_complementario").value.trim(),
            tipos_examen:tiposExamen,
            informe_examen:document.getElementById("informe_examen").value.trim()
        },
        estomatognatico:estomatognatico,
        indicadores:indicadores,
        higiene_oral: {
            registros:higieneOral,
            promedio_placa:Number(document.getElementById("promedioPlaca").textContent),
            promedio_calculo:
                Number(document.getElementById("promedioCalculo").textContent),
            promedio_gingivitis:
                Number(document.getElementById("promedioGingivitis").textContent)
        },
        odontograma:datosOdontograma,
        diagnosticos:diagnosticos,
        tratamientos:tratamientos,
        complicaciones:complicaciones,
        prescripcion:prescripcion,
        fotografias:fotografias
    };
    return datos;
}

/*=============================
Crear atención
===============================*/
function crearAtencion() {
    const id_cita = document.getElementById("id_cita").value;
    const formData = new FormData();
    formData.append("id_cita", id_cita);
    fetch("../ajax/atencion.php?op=crear", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            idAtencionActual = data.id_atencion;
            console.log("Atención actual:",idAtencionActual);
        } else {
            console.error(data.message);
        }
    })
    .catch(error => {
        console.error(error);
    });
}
