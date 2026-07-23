document.addEventListener("DOMContentLoaded", () => {
    cargarCita();
    listarAntecedentes();
    listarEstomatognatico();
    listarIndicadores();
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