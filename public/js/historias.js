document.addEventListener("DOMContentLoaded", function () {
// Listado de historias - Principal
    if (document.getElementById("tbllistadoHistorias")) {
        listarHistorias();
        const buscarHistoria = document.getElementById("buscarHistoria");
        if (buscarHistoria) {
            buscarHistoria.addEventListener("input", function () {
                renderizarHistorias();
            });
        }
    }

// Ver Historia
    if (document.getElementById("contenidoHistoria")) {
        iniciarHistoria();
    }
});

let historias = [];

//Función para listar las historias clínicas
async function listarHistorias() {
    try {
        const response = await fetch("../ajax/atencion.php?op=listar_historias");
        const data = await response.json();
        if (!data.status) {
            console.error(data.message || "No se pudieron cargar las historias clínicas.");
            return;
        }
        historias = data.data || [];
        renderizarHistorias();
    } catch (error) {
        console.error("Error al listar historias clínicas:",error);
    }
}

//Recargamos las historias
function renderizarHistorias() {
    const tabla = document.getElementById("tbllistadoHistorias");
    const cards = document.getElementById("cardsHistorias");
    const buscador = document.getElementById("buscarHistoria");
    if (!tabla || !cards) {
        return;
    }
    const termino = (buscador?.value || "").trim().toLowerCase();
    const filtradas = historias.filter(function (historia) {
        const nombreCompleto = `${historia.nombre || ""} ${historia.apellido || ""}`.toLowerCase();
        const cedula = String(historia.cedula || "").toLowerCase();
        return (nombreCompleto.includes(termino) ||cedula.includes(termino));
    });
    tabla.innerHTML = "";
    cards.innerHTML = "";
    if (filtradas.length === 0) {
        tabla.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                    No se encontraron historias clínicas.
                </td>
            </tr>
        `;
        cards.innerHTML = `
            <div class="bg-white rounded-2xl shadow-sm p-6 text-center text-slate-500">
                No se encontraron historias clínicas.
            </div>
        `;
        return;
    }

    filtradas.forEach(function (historia) {
        const nombreCompleto = `${historia.nombre || ""} ${historia.apellido || ""}`;
        const fecha = formatearFecha(historia.ultima_atencion);

        //Completamos la tabla Desktop
        tabla.innerHTML += `
            <tr class="border-b border-slate-100 hover:bg-slate-50">
                <td class="px-6 py-4">
                    <div class="font-medium text-slate-800">
                        ${escaparHTML(nombreCompleto)}
                    </div>
                </td>

                <td class="px-6 py-4 text-slate-600">
                    ${escaparHTML(historia.cedula || "-")}
                </td>

                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center justify-center min-w-[38px] px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold">
                        ${historia.total_atenciones || 0}
                    </span>
                </td>

                <td class="px-6 py-4 text-center text-slate-600">
                    ${fecha}
                </td>

                <td class="px-6 py-4 text-center">

                    <button type="button" onclick="verHistoria(${Number(historia.id_paciente)})" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium">
                        Ver historia
                    </button>
                </td>
            </tr>
        `;

        //Llenamos las cards móvil
        cards.innerHTML += `
            <div class="bg-white rounded-2xl shadow-sm p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-slate-800">
                            ${escaparHTML(nombreCompleto)}
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Cédula: ${escaparHTML(historia.cedula || "-")}
                        </p>
                    </div>

                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                        ${historia.total_atenciones || 0}
                    </span>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100">
                    <p class="text-sm text-slate-500">
                        Última atención
                    </p>

                    <p class="font-medium text-slate-700 mt-1">
                        ${fecha}
                    </p>
                </div>

                <button type="button" onclick="verHistoria(${Number(historia.id_paciente)})" class="w-full mt-4 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium">
                    Ver historia
                </button>
            </div>
        `;
    });
}

// Función para ver la historia del paciente
function volverHistorias() {
    window.location.href =
        "historias.php";
}

//Formateamos la fecha, para que nos traiga la que se registró
function formatearFecha(fecha) {
    if (!fecha) {
        return "-";
    }
    const soloFecha = fecha.split(" ")[0];
    const partes = soloFecha.split("-");
    if (partes.length !== 3) {
        return fecha;
    }
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}


/* ==========================================
   ESCAPAR HTML
========================================== */
function escaparHTML(texto) {
    return String(texto ?? "").replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

/* ==========================================
   DETALLE DE HISTORIA CLÍNICA
========================================== */

let atencionesPaciente = [];
let idAtencionSeleccionada = null;


// ==========================================
// INICIAR HISTORIA DEL PACIENTE
// ==========================================
async function iniciarHistoria() {

    const params = new URLSearchParams(window.location.search);
    const idPaciente = parseInt(params.get("id_paciente"));

    if (!idPaciente || idPaciente <= 0) {
        mostrarErrorHistoria("Paciente no válido.");
        return;
    }

    await cargarAtencionesPaciente(idPaciente);
}


// ==========================================
// CARGAR ATENCIONES DEL PACIENTE
// ==========================================
async function cargarAtencionesPaciente(idPaciente) {

    try {

        const formData = new FormData();
        formData.append("id_paciente", idPaciente);

        const response = await fetch(
            "../ajax/atencion.php?op=listar_atenciones_paciente",
            {
                method: "POST",
                body: formData
            }
        );

        const resultado = await response.json();

        if (!resultado.status) {

            mostrarErrorHistoria(
                resultado.message ||
                "No se pudo cargar la historia clínica."
            );

            return;
        }

        atencionesPaciente = resultado.data || [];

        if (atencionesPaciente.length === 0) {

            mostrarErrorHistoria(
                "El paciente no tiene atenciones finalizadas."
            );

            return;
        }


        // Datos generales del paciente
        mostrarDatosPaciente(atencionesPaciente[0]);


        // Tarjetas de atenciones
        renderizarAtenciones();


        // Ocultamos mensaje de carga
        const cargando =
            document.getElementById("cargandoHistoria");

        if (cargando) {
            cargando.classList.add("hidden");
        }


        // Mostramos contenido
        const contenido =
            document.getElementById("contenidoHistoria");

        if (contenido) {
            contenido.classList.remove("hidden");
        }

    } catch (error) {

        console.error(
            "Error al cargar las atenciones:",
            error
        );

        mostrarErrorHistoria(
            "Ocurrió un error al cargar la historia clínica."
        );
    }
}


// ==========================================
// MOSTRAR DATOS DEL PACIENTE
// ==========================================
function mostrarDatosPaciente(paciente) {

    const nombreCompleto =
        `${paciente.nombre || ""} ${paciente.apellido || ""}`.trim();

    colocarTexto(
        "historiaNombrePaciente",
        nombreCompleto
    );

    colocarTexto(
        "historiaCedulaPaciente",
        paciente.cedula || "-"
    );

    colocarTexto(
        "historiaFechaNacimiento",
        formatearFecha(paciente.fecha_nacimiento)
    );

    colocarTexto(
        "historiaSexo",
        obtenerSexo(paciente.sexo)
    );

    colocarTexto(
        "historiaTelefono",
        paciente.telefono || "-"
    );

    colocarTexto(
        "historiaCorreo",
        paciente.correo || "-"
    );

    colocarTexto(
        "historiaDireccion",
        paciente.direccion || "-"
    );

    colocarTexto(
        "historiaTotalAtenciones",
        `${atencionesPaciente.length} ${
            atencionesPaciente.length === 1
                ? "atención"
                : "atenciones"
        }`
    );
}


// ==========================================
// RENDERIZAR ATENCIONES
// ==========================================
function renderizarAtenciones() {

    const contenedor =
        document.getElementById("historiaListaAtenciones");

    if (!contenedor) {
        return;
    }

    contenedor.innerHTML = "";

    atencionesPaciente.forEach(function (atencion) {

        const idAtencion =
            Number(atencion.id_atencion);

        const profesional =
            `${atencion.nombre_profesional || ""} ${
                atencion.apellido_profesional || ""
            }`.trim();

        const boton =
            document.createElement("button");

        boton.type = "button";

        boton.dataset.idAtencion =
            idAtencion;

        boton.className =
            "shrink-0 min-w-[210px] text-left px-4 py-3 " +
            "rounded-xl border border-slate-200 bg-white " +
            "hover:border-blue-500 hover:bg-blue-50 transition";

        boton.innerHTML = `
            <div class="text-xs font-semibold text-blue-600">
                Atención #${idAtencion}
            </div>

            <div class="font-semibold text-slate-800 mt-1">
                ${escaparHTML(
                    formatearFechaHora(atencion.fecha_fin)
                )}
            </div>

            <div class="text-xs text-slate-500 mt-2">
                ${escaparHTML(profesional || "-")}
            </div>
        `;

        boton.addEventListener(
            "click",
            function () {
                seleccionarAtencion(idAtencion);
            }
        );

        contenedor.appendChild(boton);
    });


    // La consulta ya viene ordenada por fecha_fin DESC,
    // por eso [0] corresponde a la más reciente.
    if (atencionesPaciente.length > 0) {

        seleccionarAtencion(
            Number(
                atencionesPaciente[0].id_atencion
            )
        );
    }
}


// ==========================================
// SELECCIONAR ATENCIÓN
// ==========================================
function seleccionarAtencion(idAtencion) {

    idAtencionSeleccionada =
        Number(idAtencion);


    document
        .querySelectorAll("[data-id-atencion]")
        .forEach(function (boton) {

            const seleccionado =
                Number(boton.dataset.idAtencion) ===
                idAtencionSeleccionada;


            boton.classList.toggle(
                "border-blue-600",
                seleccionado
            );

            boton.classList.toggle(
                "bg-blue-50",
                seleccionado
            );

            boton.classList.toggle(
                "ring-2",
                seleccionado
            );

            boton.classList.toggle(
                "ring-blue-100",
                seleccionado
            );

            boton.classList.toggle(
                "border-slate-200",
                !seleccionado
            );

        });


    console.log(
        "ATENCIÓN SELECCIONADA:",
        idAtencionSeleccionada
    );


    /*
        AQUÍ conectaremos después:

        cargarHistoriaCompleta(
            idAtencionSeleccionada
        );
    */
}


// ==========================================
// COLOCAR TEXTO
// ==========================================
function colocarTexto(id, valor) {

    const elemento =
        document.getElementById(id);

    if (!elemento) {
        return;
    }

    elemento.textContent =
        valor === null ||
        valor === undefined ||
        valor === ""
            ? "-"
            : valor;
}


// ==========================================
// OBTENER SEXO
// ==========================================
function obtenerSexo(sexo) {

    if (!sexo) {
        return "-";
    }

    const valor =
        String(sexo).toUpperCase();

    if (valor === "M") {
        return "Masculino";
    }

    if (valor === "F") {
        return "Femenino";
    }

    return sexo;
}


// ==========================================
// FORMATEAR FECHA Y HORA
// ==========================================
function formatearFechaHora(fecha) {

    if (!fecha) {
        return "-";
    }

    const partes =
        String(fecha).split(" ");

    const fechaFormateada =
        formatearFecha(partes[0]);

    if (!partes[1]) {
        return fechaFormateada;
    }

    const hora =
        partes[1].substring(0, 5);

    return `${fechaFormateada} - ${hora}`;
}


// ==========================================
// ERROR DE HISTORIA
// ==========================================
function mostrarErrorHistoria(mensaje) {

    const cargando =
        document.getElementById("cargandoHistoria");

    if (!cargando) {
        return;
    }

    cargando.innerHTML = `
        <div class="text-red-600 font-medium">
            ${escaparHTML(mensaje)}
        </div>

        <button
            type="button"
            onclick="volverHistorias()"
            class="mt-4 px-4 py-2 rounded-xl
                   bg-slate-100 hover:bg-slate-200
                   text-slate-700 font-medium"
        >
            Volver a Historias Clínicas
        </button>
    `;
}


// ==========================================
// VOLVER AL LISTADO
// ==========================================
function volverHistorias() {

    window.location.href =
        "index.php";
}