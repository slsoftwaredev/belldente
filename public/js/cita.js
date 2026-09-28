document.addEventListener("DOMContentLoaded", () => {

    listarCitas();
    cargarPacientes();
    cargarDentistas();
    confirmarHoraCita();
    cargarCitasHoy();
    cargarCitasAtrasadas();

    // Modal
    const modalCita = document.getElementById("modalCita");
    const btnNuevaCita = document.getElementById("btnNuevaCita");
    const btnCerrarModal = document.getElementById("btnCerrarModal");
    const btnCancelar = document.getElementById("btnCancelar");

    const modalConfirmarHora =
    document.getElementById("modalConfirmarHora");

const btnCerrarModalHora =
    document.getElementById("btnCerrarModalHora");

const btnCancelarHora =
    document.getElementById("btnCancelarHora");

const btnGuardarHora =
    document.getElementById("btnGuardarHora");


function cerrarModalHora() {

    modalConfirmarHora.classList.add("hidden");
    modalConfirmarHora.classList.remove("flex");

}


btnCerrarModalHora.addEventListener("click", cerrarModalHora);
btnCancelarHora.addEventListener("click", cerrarModalHora);


btnGuardarHora.addEventListener("click", () => {

    const campoCita =
        document.getElementById("id_cita_hora");

    const id_cita = campoCita.value;
    const dentista_id = campoCita.dataset.dentista;
    const fecha_cita = campoCita.dataset.fecha;

    const hora_cita =
        document.getElementById("hora_cita_confirmar").value;

    if (!hora_cita) {

    mostrarModalSistema({
        titulo: "Seleccione una hora",
        mensaje: "Debe seleccionar una hora disponible antes de confirmar la cita.",
        tipo: "warning"
    });

    return;
}

    const datos = new URLSearchParams();

    datos.append("id_cita", id_cita);
    datos.append("dentista_id", dentista_id);
    datos.append("fecha_cita", fecha_cita);
    datos.append("hora_cita", hora_cita);

    fetch("../ajax/cita.php?op=confirmar_hora", {

        method: "POST",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: datos.toString()

    })
    .then(response => response.json())
    .then(respuesta => {

        if (respuesta.status) {

    cerrarModalHora();

    listarCitas();
    cargarCitasHoy();
    cargarCitasAtrasadas();

    mostrarModalSistema({
        titulo: "Hora confirmada",
        mensaje: "La hora de la cita fue confirmada correctamente.",
        tipo: "success"
    });

} else {

    mostrarModalSistema({
        titulo: "No se pudo confirmar",
        mensaje:
            respuesta.mensaje ||
            "No se pudo confirmar la hora de la cita.",
        tipo: "error"
    });
}

    })
    .catch(error => {
        console.error(error);
    });

});
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

        formCita.reset();
        cerrarModal();

        listarCitas();
        cargarCitasHoy();
        cargarCitasAtrasadas();

        mostrarModalSistema({
            titulo:
                accion === "guardar"
                    ? "Cita registrada"
                    : "Cita reagendada",

            mensaje:
                accion === "guardar"
                    ? "La cita fue registrada correctamente."
                    : "La cita fue reagendada correctamente.",

            tipo: "success"
        });

    } else {

        mostrarModalSistema({
            titulo: "No se pudo guardar",
            mensaje:
                data.mensaje ||
                (
                    accion === "guardar"
                        ? "Ocurrió un error al registrar la cita."
                        : "Ocurrió un error al reagendar la cita."
                ),
            tipo: "error"
        });
    }
})
        .catch(error => {
            console.error(error);
        });

    });
});

let accionConfirmadaModal = null;

function mostrarModalSistema({
    titulo = "Información",
    mensaje = "",
    tipo = "info",
    confirmar = false,
    textoAceptar = "Aceptar",
    textoCancelar = "Volver",
    onAceptar = null
}) {

    const modal = document.getElementById("modalSistema");
    const header = document.getElementById("modalSistemaHeader");
    const tituloModal = document.getElementById("modalSistemaTitulo");
    const mensajeModal = document.getElementById("modalSistemaMensaje");
    const btnAceptar = document.getElementById("btnModalSistemaAceptar");
    const btnCancelar = document.getElementById("btnModalSistemaCancelar");

    tituloModal.textContent = titulo;
    mensajeModal.textContent = mensaje;

    btnAceptar.textContent = textoAceptar;
    btnCancelar.textContent = textoCancelar;

    // Colores según el tipo
    header.className =
        "px-6 py-5 flex items-center gap-4 " +
        (
            tipo === "error"
                ? "bg-red-600"
                : tipo === "warning"
                ? "bg-amber-500"
                : tipo === "success"
                ? "bg-green-600"
                : "bg-blue-600"
        );

    btnAceptar.className =
        "text-white px-5 py-3 rounded-xl transition " +
        (
            tipo === "error"
                ? "bg-red-600 hover:bg-red-700"
                : tipo === "warning"
                ? "bg-amber-500 hover:bg-amber-600"
                : tipo === "success"
                ? "bg-green-600 hover:bg-green-700"
                : "bg-blue-600 hover:bg-blue-700"
        );

    if (confirmar) {
        btnCancelar.classList.remove("hidden");
    } else {
        btnCancelar.classList.add("hidden");
    }

    accionConfirmadaModal = onAceptar;

    modal.classList.remove("hidden");
    modal.classList.add("flex");
}

function cerrarModalSistema() {

    const modal = document.getElementById("modalSistema");

    modal.classList.add("hidden");
    modal.classList.remove("flex");

    accionConfirmadaModal = null;
}

document
    .getElementById("btnModalSistemaAceptar")
    .addEventListener("click", () => {

        const accion = accionConfirmadaModal;

        cerrarModalSistema();

        if (typeof accion === "function") {
            accion();
        }
    });

document
    .getElementById("btnModalSistemaCancelar")
    .addEventListener("click", cerrarModalSistema);

// Función para listar las citas
function listarCitas() {

    fetch("../ajax/cita.php?op=listar")
        .then(response => response.json())
        .then(respuesta => {

            if (!respuesta.status) {
                console.error("Error al listar citas:", respuesta);
                return;
            }

            const data = respuesta.data;

            let html = "";
            let cards = "";

            data.forEach(cita => {

                html += `
                    <tr class="border-b">

                        <td class="px-6 py-4">
                            ${cita.id_cita}
                        </td>

                        <td class="px-6 py-4">
                            ${cita.paciente}
                        </td>

                        <td class="px-6 py-4">
                            ${cita.dentista}
                        </td>

                        <td class="px-6 py-4">
                            ${cita.fecha_cita}
                        </td>

                        <td class="px-6 py-4">
                            ${cita.hora_cita}
                        </td>

                        <td class="px-6 py-4">
                            ${cita.motivo_cita}
                        </td>

                        <td class="px-6 py-4">
                            ${cita.estado}
                        </td>

                        <td class="px-6 py-4">
                            ${cita.acciones}
                        </td>

                    </tr>
                `;


                cards += `
                    <div class="bg-white rounded-2xl shadow-sm p-4">

                        <h3 class="font-bold text-slate-800">
                            ${cita.paciente}
                        </h3>

                        <div class="mt-3 space-y-1 text-sm text-slate-500">

                            <p>
                                <span class="font-medium text-slate-700">
                                    Dentista:
                                </span>

                                ${cita.dentista}
                            </p>

                            <p>
                                <span class="font-medium text-slate-700">
                                    Fecha:
                                </span>

                                ${cita.fecha_cita}
                            </p>

                            <p>
                                <span class="font-medium text-slate-700">
                                    Hora:
                                </span>

                                ${cita.hora_cita}
                            </p>

                            <p>
                                <span class="font-medium text-slate-700">
                                    Motivo:
                                </span>

                                ${cita.motivo_cita}
                            </p>

                            <p>
                                <span class="font-medium text-slate-700">
                                    Estado:
                                </span>

                                ${cita.estado}
                            </p>

                        </div>

                        <div class="mt-4 flex items-center gap-2">

                            ${cita.acciones}

                        </div>

                    </div>
                `;

            });


            // Si no existen registros
            if (data.length === 0) {

                html = `
                    <tr>
                        <td
                            colspan="8"
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

        })
        .catch(error => {

            console.error("Error al cargar las citas:", error);

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

// Función para cargar el combo de dentistas
function cargarDentistas() {

    fetch("../ajax/cita.php?op=dentistas")
    .then(response => response.json())
    .then(respuesta => {

        if (!respuesta.status) {
            console.error("No se pudieron cargar los dentistas");
            return;
        }

        let html = `
            <option value="">
                Seleccione un dentista
            </option>
        `;

        respuesta.data.forEach(dentista => {

            html += `
                <option value="${dentista.id_usuario}">
                    ${dentista.dentista}
                </option>
            `;

        });

        document.getElementById("dentista_id").innerHTML = html;

    })
    .catch(error => {
        console.error(error);
    });

}

// Editar cita
// Editar / Reagendar cita
function editarCita(id_cita) {

    const modal = document.getElementById("modalCita");

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    fetch("../ajax/cita.php?op=obtener", {

        method: "POST",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: "id_cita=" + id_cita

    })
    .then(response => response.json())
    .then(respuesta => {

        if (!respuesta.status) {

    mostrarModalSistema({
        titulo: "No se pudo cargar la cita",
        mensaje:
            respuesta.mensaje ||
            "No se pudo obtener la información de la cita.",
        tipo: "error"
    });

    return;
}

        const cita = respuesta.data;

        document.getElementById("id_cita").value =
            cita.id_cita;

        document.getElementById("paciente_id").value =
            cita.paciente_id;

        document.getElementById("dentista_id").value =
            cita.dentista_id;

        document.getElementById("fecha_cita").value =
            cita.fecha_cita;

        document.getElementById("motivo_cita").value =
            cita.motivo_cita ?? "";

        document.getElementById("tituloModal").innerText =
            "Reagendar Cita";

    })
    .catch(error => {

        console.error(error);

    });

}

// Abrir modal para confirmar la hora de una cita
function confirmarHoraCita(id_cita) {

    fetch("../ajax/cita.php?op=obtener", {

        method: "POST",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: "id_cita=" + id_cita

    })
    .then(response => response.json())
    .then(respuesta => {

        if (!respuesta.status) {

    mostrarModalSistema({
        titulo: "No se pudo cargar la cita",
        mensaje:
            respuesta.mensaje ||
            "No se pudo obtener la información de la cita.",
        tipo: "error"
    });

    return;
}

        const cita = respuesta.data;

        if (!cita.dentista_id || !cita.fecha_cita) {

    mostrarModalSistema({
        titulo: "Información incompleta",
        mensaje: "La cita debe tener un dentista y una fecha asignados antes de confirmar la hora.",
        tipo: "warning"
    });

    return;
}

        cargarHorasDisponibles(
            cita.id_cita,
            cita.dentista_id,
            cita.fecha_cita
        );

    })
    .catch(error => {
        console.error(error);
    });
}
function cargarHorasDisponibles(id_cita, dentista_id, fecha_cita) {

    const datosHorario = new URLSearchParams();
    datosHorario.append("fecha_cita", fecha_cita);

    const datosOcupadas = new URLSearchParams();
    datosOcupadas.append("id_cita", id_cita);
    datosOcupadas.append("dentista_id", dentista_id);
    datosOcupadas.append("fecha_cita", fecha_cita);

    Promise.all([

        fetch("../ajax/cita.php?op=horario", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: datosHorario.toString()
        }).then(response => response.json()),

        fetch("../ajax/cita.php?op=horas_ocupadas", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: datosOcupadas.toString()
        }).then(response => response.json())

    ])
    .then(([respuestaHorario, respuestaOcupadas]) => {

        if (!respuestaHorario.status) {

    mostrarModalSistema({
        titulo: "Horario no disponible",
        mensaje:
            respuestaHorario.mensaje ||
            "No se pudo obtener el horario del consultorio.",
        tipo: "error"
    });

    return;
}

        const horarios = respuestaHorario.data || [];
        const ocupadas = respuestaOcupadas.data || [];

        mostrarHorasDisponibles(
            id_cita,
            dentista_id,
            fecha_cita,
            horarios,
            ocupadas
        );

    })
    .catch(error => {
        console.error(error);
    });
}
function mostrarHorasDisponibles(
    id_cita,
    dentista_id,
    fecha_cita,
    horarios,
    ocupadas
) {

    const select = document.getElementById("hora_cita_confirmar");

    let html = `
        <option value="">
            Seleccione una hora
        </option>
    `;

    const horasOcupadas = ocupadas.map(item => {
        return item.hora_cita.substring(0, 5);
    });

    horarios.forEach(horario => {

        const intervalo = parseInt(horario.intervalo_minutos);

        let actual = convertirMinutos(horario.hora_inicio);
        const fin = convertirMinutos(horario.hora_fin);

        // hora_fin es el cierre del bloque.
        // Por eso no generamos una cita que comience exactamente al cierre.
        while (actual < fin) {

            const hora = convertirHora(actual);

            if (!horasOcupadas.includes(hora)) {

                html += `
                    <option value="${hora}">
                        ${hora}
                    </option>
                `;
            }

            actual += intervalo;
        }
    });

    select.innerHTML = html;

    document.getElementById("id_cita_hora").value = id_cita;

    // Guardamos estos datos para confirmar posteriormente
    document.getElementById("id_cita_hora").dataset.dentista = dentista_id;
    document.getElementById("id_cita_hora").dataset.fecha = fecha_cita;

    const modal = document.getElementById("modalConfirmarHora");

    modal.classList.remove("hidden");
    modal.classList.add("flex");
}
function convertirMinutos(hora) {

    const partes = hora.split(":");

    return (
        parseInt(partes[0]) * 60 +
        parseInt(partes[1])
    );
}


function convertirHora(minutos) {

    const hora = Math.floor(minutos / 60);
    const minuto = minutos % 60;

    return (
        String(hora).padStart(2, "0") +
        ":" +
        String(minuto).padStart(2, "0")
    );
}

// Función para cargar el número de citas de hoy
function cargarCitasHoy(){

    fetch("../ajax/cita.php?op=citas_hoy")

    .then(response => response.json())

    .then(data => {
        document.getElementById("lblCitasHoy").textContent = data.total ?? 0;
    })
    .catch(error => {
        console.error(error);
        document.getElementById("lblCitasHoy").textContent = 0;
    });

}
// Función para cargar el número de citas atrasadas
function cargarCitasAtrasadas(){

    fetch("../ajax/cita.php?op=citas_atrasadas")

    .then(response => response.json())

    .then(data => {

        document.getElementById("lblCitasAtrasadas").textContent =
            data.total ?? 0;

    })

    .catch(error => {
        console.error(error);
        document.getElementById("lblCitasAtrasadas").textContent = 0;
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

// Cancelar cita
function cancelarCita(id_cita) {

    mostrarModalSistema({
        titulo: "Cancelar cita",
        mensaje: "¿Está seguro de cancelar esta cita? Esta acción cambiará su estado a Cancelada.",
        tipo: "error",
        confirmar: true,
        textoAceptar: "Sí, cancelar",
        textoCancelar: "Volver",

        onAceptar: () => {

            const datos = new URLSearchParams();

            datos.append("id_cita", id_cita);
            datos.append("estado", 6);

            fetch("../ajax/cita.php?op=estado", {

                method: "POST",

                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },

                body: datos.toString()

            })
            .then(response => response.json())
            .then(respuesta => {

                if (respuesta.status) {

                    listarCitas();
                    cargarCitasHoy();
                    cargarCitasAtrasadas();

                    mostrarModalSistema({
                        titulo: "Cita cancelada",
                        mensaje: "La cita fue cancelada correctamente.",
                        tipo: "success"
                    });

                } else {

                    mostrarModalSistema({
                        titulo: "No se pudo cancelar",
                        mensaje:
                            respuesta.mensaje ||
                            "Ocurrió un error al cancelar la cita.",
                        tipo: "error"
                    });
                }

            })
            .catch(error => {

                console.error(error);

                mostrarModalSistema({
                    titulo: "Error",
                    mensaje: "Ocurrió un error de comunicación al cancelar la cita.",
                    tipo: "error"
                });

            });

        }
    });
}

// Cerrar modal de mensaje
function cerrarModalMensaje() {

    document.getElementById("modalMensaje").remove();

    const url = new URL(window.location);

    url.searchParams.delete("mensaje");

    window.history.replaceState({}, "", url);

}