document.addEventListener("DOMContentLoaded", () => {

    listarCitas();
    cargarPacientes();
    cargarCitasHoy();
    cargarCitasAtrasadas();

    // Modal
    const modalCita = document.getElementById("modalCita");
    const btnNuevaCita = document.getElementById("btnNuevaCita");
    const btnCerrarModal = document.getElementById("btnCerrarModal");
    const btnCancelar = document.getElementById("btnCancelar");
// Botones del modal
    btnNuevaCita.addEventListener("click", () => {

        formCita.reset();

        document.getElementById("id_cita").value = 0;

        document.getElementById("tituloModal").textContent = "Nueva Cita";

        modalCita.classList.remove("hidden");
        modalCita.classList.add("flex");

    });

    btnCerrarModal.addEventListener("click", cerrarModal);

    btnCancelar.addEventListener("click", cerrarModal);

    function cerrarModal() {
        formCita.reset();
        modalCita.classList.add("hidden");
        modalCita.classList.remove("flex");

    }
    // Formulario
    const formCita = document.getElementById("formCita");
    formCita.addEventListener("submit", function (e) {

        e.preventDefault();
        const formData = new FormData(formCita);
        const accion = document.getElementById("id_cita").value == 0 ? "guardar" : "editar";    
        fetch("../ajax/cita.php?op=" + accion, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {

                alert(accion == "guardar" ? "Cita registrada correctamente" : "Cita actualizada correctamente");
                formCita.reset();
                cerrarModal();
                listarCitas(); 
            } else {

                alert(accion == "guardar" ? "Error al guardar la cita" : "Error al actualizar la cita");
            }
        })
        .catch(error => {
            console.error(error);
        });

    });
});

// Función para listar las citas
    function listarCitas() {

    fetch("../ajax/cita.php?op=listar")
        .then(response => response.json())
        .then(data => {

            let html = "";
            let cards = "";

            data.forEach(cita => {

                    html += `
                        <tr class="border-b">

                            <td class="px-6 py-4">
                                ${cita[0]}
                            </td>

                            <td class="px-6 py-4">
                                ${cita[1]}
                            </td>

                            <td class="px-6 py-4">
                                ${cita[2]}
                            </td>

                            <td class="px-6 py-4">
                                ${cita[3]}
                            </td>
                            <td class="px-6 py-4">
                                ${cita[4]}
                            </td>


                        </tr>
                    `;

                    cards += `
                        <div class="bg-white rounded-2xl shadow-sm p-4">

                            <h3 class="font-bold text-slate-800">

                                ${cita[1]}

                            </h3>

                            <p class="text-sm text-slate-500 mt-2">

                                Fecha:
                                ${cita[2]}

                            </p>

                            <p class="text-sm text-slate-500">

                                Estado:
                                ${cita[3]}

                            </p>

                            <div class="mt-4">

                                Acciones:
                                ${cita[4]}

                            </div>

                        </div>
                    `;

                });
            // Si no existen registros
            if (data.length === 0) {

                html = `
                    <tr>

                        <td
                            colspan="5"
                            class="px-6 py-8 text-center text-slate-500">

                            No hay citas registradas

                        </td>

                    </tr>
                `;

                cards = `
                    <div
                        class="bg-white rounded-2xl shadow-sm p-6 text-center text-slate-500">

                        No hay citas registradas

                    </div>
                `;

            }

            document.getElementById("tblCitas").innerHTML = html;
            document.getElementById("cardCitas").innerHTML = cards;

        }) .catch(error => {
            console.error(error);
        });

}
// Función para cargar el combo de pacientes
function cargarPacientes() {

    fetch("../ajax/paciente.php?op=combo")
    .then(response => response.json())
    .then(data => {

        let html = `
            <option value="">
                Seleccione un paciente
            </option>
        `;

        data.forEach(paciente => {

            html += `
                <option value="${paciente.id_paciente}">
                    ${paciente.nombre_completo}
                </option>
            `;

        });

        document.getElementById("paciente_id").innerHTML = html;
    })
    .catch(error => {

        console.error(error);

    });

}
// Editar cita
function editarCita(id_cita){

    const modal = document.getElementById("modalCita");

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    fetch("../ajax/cita.php?op=obtener",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"id_cita="+id_cita

    })
    .then(response => response.json())
    .then(data => {

        document.getElementById("id_cita").value =
            data[0];

        document.getElementById("paciente_id").value =
            data[1];

        document.querySelector("[name='fecha_cita']").value =
            data[2];

        document.getElementById("tituloModal").innerText =
            "Reagendar Cita";

    })
    .catch(error => {

        console.error(error);

    });

}
// Función para cargar el número de citas de hoy
function cargarCitasHoy(){

    fetch("../ajax/cita.php?op=citas_hoy")

    .then(response => response.json())

    .then(data => {

        document.getElementById("lblCitasHoy").textContent =
            data.total;

    })

    .catch(error => {

        console.error(error);

    });

}
// Función para cargar el número de citas atrasadas
function cargarCitasAtrasadas(){

    fetch("../ajax/cita.php?op=citas_atrasadas")

    .then(response => response.json())

    .then(data => {

        document.getElementById("lblCitasAtrasadas").textContent =
            data.total;

    })

    .catch(error => {

        console.error(error);

    });

}

// BUSCAR CITAS CON EL BUSCADOR DEL VIEW
document.getElementById("txtBuscar").addEventListener("keyup", buscarCitas);
function buscarCitas(){

    let filtro =
    this.value.toLowerCase();

    // Tabla Desktop

    document
    .querySelectorAll("#tblCitas tr")
    .forEach(fila => {

        let texto =
        fila.textContent.toLowerCase();

        fila.style.display =
        texto.includes(filtro)
        ? ""
        : "none";

    });

    // Cards Mobile

    document
    .querySelectorAll("#cardCitas > div")
    .forEach(card => {

        let texto =
        card.textContent.toLowerCase();

        card.style.display =
        texto.includes(filtro)
        ? ""
        : "none";

    });

}

// Abrir módulo de Atención Clínica
function atenderCita(id_cita){
    window.location.href = "atencion.php?id_cita=" + id_cita;
}

// Cerrar modal de mensaje
function cerrarModalMensaje() {

    document.getElementById("modalMensaje").remove();

    const url = new URL(window.location);

    url.searchParams.delete("mensaje");

    window.history.replaceState({}, "", url);

}