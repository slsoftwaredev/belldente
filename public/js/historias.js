console.log("HISTORIAS.JS CARGADO - NUEVA VERSION");
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

// ==========================================
// VER HISTORIA CLÍNICA
// ==========================================
function verHistoria(idPaciente) {

    idPaciente = Number(idPaciente);

    if (!idPaciente || idPaciente <= 0) {
        alert("Paciente no válido.");
        return;
    }

    window.location.href =
        `historias.php?id_paciente=${idPaciente}`;
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
    cargarAntecedentesPaciente(idPaciente);
    await cargarAtencionesPaciente(idPaciente);
}

//===========================================
// CARGAR ANTECEDENTES DEL PACIENTE
//===========================================
function cargarAntecedentesPaciente(idPaciente) {

    const formData = new FormData();
    formData.append("id_paciente", idPaciente);

    fetch("/ajax/atencion.php?op=historia_antecedentes", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(resultado => {

        console.log("ANTECEDENTES DEL PACIENTE:", resultado);

        if (!resultado.status) {
            mostrarAntecedentes([]);
            return;
        }

        mostrarAntecedentes(resultado.datos || []);
    })
    .catch(error => {

        console.error("Error al cargar antecedentes:", error);

        mostrarAntecedentes([]);
    });
}
//===========================================
// MOSTRAR ANTECEDENTES
//===========================================
function mostrarAntecedentes(datos) {

    const contenedor =
        document.getElementById("historiaAntecedentes");

    if (!contenedor) return;

    if (!Array.isArray(datos) || datos.length === 0) {

        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                El paciente no registra antecedentes.
            </p>
        `;

        return;
    }

    const personales = datos.filter(
        item => Number(item.id_tipo_antecedente) === 1
    );

    const familiares = datos.filter(
        item => Number(item.id_tipo_antecedente) === 2
    );

    contenedor.innerHTML = `

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            ${crearGrupoAntecedentes(
                "Antecedentes personales",
                personales
            )}

            ${crearGrupoAntecedentes(
                "Antecedentes familiares",
                familiares
            )}

        </div>
    `;
}
function crearGrupoAntecedentes(titulo, datos) {

    if (!datos || datos.length === 0) {

        return `
            <div class="rounded-xl border border-slate-200 p-4">

                <h3 class="font-semibold text-slate-800 mb-3">
                    ${titulo}
                </h3>

                <p class="text-sm text-slate-500">
                    Sin antecedentes registrados.
                </p>

            </div>
        `;
    }

    // La observación es general para este grupo
    const observacion =
        datos.find(item => item.observacion)?.observacion || "";

    return `
        <div class="rounded-xl border border-slate-200 p-4">

            <h3 class="font-semibold text-slate-800 mb-3">
                ${titulo}
            </h3>

            <div class="space-y-2">

                ${datos.map(item => `
                    <div class="flex items-center gap-2">

                        <span class="w-2 h-2 rounded-full
                                     bg-blue-600 shrink-0">
                        </span>

                        <span class="text-sm text-slate-700">
                            ${escaparHTML(
                                item.nombre_antecedente || "-"
                            )}
                        </span>

                    </div>
                `).join("")}

            </div>

            ${
                observacion
                    ? `
                        <div class="mt-4 pt-3 border-t border-slate-100">

                            <p class="text-xs font-medium text-slate-500">
                                Observación
                            </p>

                            <p class="mt-1 text-sm text-slate-700">
                                ${escaparHTML(observacion)}
                            </p>

                        </div>
                    `
                    : ""
            }

        </div>
    `;
}

// ==========================================
// CARGAR ATENCIONES DEL PACIENTE
// ==========================================
async function cargarAtencionesPaciente(idPaciente) {

    try {

        const formData = new FormData();
        formData.append("id_paciente", idPaciente);

        const response = await fetch(
            "/ajax/atencion.php?op=listar_atenciones_paciente",
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

    const nombreCompleto = `${paciente.nombre || ""} ${paciente.apellido || ""}`.trim();

    colocarTexto("historiaNombrePaciente",nombreCompleto);
    colocarTexto("historiaCedulaPaciente",paciente.cedula || "-");
    colocarTexto("historiaFechaNacimiento",formatearFecha(paciente.fecha_nacimiento));
    colocarTexto("historiaSexo",obtenerSexo(paciente.sexo));
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
    const contenedor = document.getElementById("historiaListaAtenciones");
    if (!contenedor) {
        return;
    }
    contenedor.innerHTML = "";
    atencionesPaciente.forEach(function (atencion) {
        const idAtencion = Number(atencion.id_atencion);
        const profesional = `${atencion.nombre_profesional || ""} ${
                atencion.apellido_profesional || "" }`.trim();
        const boton = document.createElement("button");
        boton.type = "button";
        boton.dataset.idAtencion = idAtencion;
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

    document.querySelectorAll("[data-id-atencion]").forEach(function (boton) {
            const seleccionado = Number(boton.dataset.idAtencion) === idAtencionSeleccionada;
            boton.classList.toggle("border-blue-600",seleccionado);
            boton.classList.toggle("bg-blue-50",seleccionado);
            boton.classList.toggle("ring-2",seleccionado);
            boton.classList.toggle("ring-blue-100",seleccionado);
            boton.classList.toggle("border-slate-200",!seleccionado);
        });

    console.log("ATENCIÓN SELECCIONADA:",idAtencionSeleccionada);
    cargarHistoriaCompleta(idAtencionSeleccionada);
}
// ==========================================
// CARGAR HISTORIA COMPLETA DE UNA ATENCIÓN
// ==========================================
async function cargarHistoriaCompleta(idAtencion) {

    idAtencion = Number(idAtencion);

    if (!idAtencion || idAtencion <= 0) {
        console.error("ID de atención no válido.");
        return;
    }

    const detalle = document.getElementById(
        "historiaDetalleAtencion"
    );

    try {

        const formData = new FormData();
        formData.append("id_atencion", idAtencion);

        const response = await fetch(
            "/ajax/atencion.php?op=obtener_historia_completa",
            {
                method: "POST",
                body: formData
            }
        );

        const resultado = await response.json();

        console.log("HISTORIA COMPLETA:");
        console.log(resultado);

        if (!resultado.status) {

            console.error(
                resultado.message ||
                "No se pudo cargar la atención."
            );

            return;
        }

        const historia = resultado.data;

        // Primero mostramos la cabecera
        mostrarCabeceraAtencion(historia.cabecera);

        //Mostramos el detalle de Estomatognatico
        mostrarEstomatognatico(historia.estomatognatico);

        //Mostramos los Indicadores de Salud Bucal
        mostrarIndicadores(historia.indicadores);

        //Mostrar Higiene Oral
        mostrarHigieneOral(historia.higiene_oral);
        mostrarTotalesHigieneOral(historia.higiene_oral);

        //Mostrar Odontograma
        mostrarOdontogramaHistoria(historia.odontograma);

        //Mostrar Índices de la Historia
        mostrarIndicesHistoria(historia.odontograma);

        //Mostrar Diagnósticos CIE-10
        mostrarDiagnosticos(historia.diagnosticos);

        //Mostrar Tratamientos
        mostrarTratamientos(historia.tratamientos);

        //Mostrar Exámenes Complementarios
        mostrarExamenesComplementarios(historia.examenes_complementarios);

        //Mostrar Informes de Exámenes
        mostrarInformesExamenes(historia.informes_examenes);

        //Mostrar Complicaciones
        mostrarComplicaciones(historia.complicaciones);

        //Mostrar Prescripción Médica
        mostrarPrescripcion(historia.prescripcion);

        //Mostrar Fotografías
        mostrarFotografias(historia.fotografias);

        // Mostramos el contenedor del detalle
        if (detalle) {
            detalle.classList.remove("hidden");
        }

    } catch (error) {

        console.error(
            "Error al cargar historia completa:",
            error
        );
    }
}


// ==========================================
// MOSTRAR CABECERA DE LA ATENCIÓN
// ==========================================
function mostrarCabeceraAtencion(cabecera) {
    if (!cabecera) {
        return;
    }
    colocarTexto("historiaFechaAtencion",formatearFechaHora(cabecera.fecha_fin));
    const profesional =`${cabecera.nombre_profesional || ""} ${cabecera.apellido_profesional || ""}`.trim();
    colocarTexto("historiaProfesional",profesional || "-");
    colocarTexto("historiaTemperatura",cabecera.temperatura ? `${cabecera.temperatura} °C` : "-");
    colocarTexto("historiaPulso",cabecera.pulso ? `${cabecera.pulso} lpm` : "-");
    colocarTexto("historiaFrecuenciaRespiratoria",cabecera.frecuencia_respiratoria ? `${cabecera.frecuencia_respiratoria} rpm` : "-");
    colocarTexto("historiaPresionArterial",cabecera.presion_arterial || "-");
}
//===========================================
//MOSTRAR ESTOMATOGNÁTICO
//===========================================
function mostrarEstomatognatico(datos) {

    const contenedor = document.getElementById("historiaEstomatognatico");

    if (!contenedor) return;

    if (!datos || datos.length === 0) {
        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registró información del examen estomatognático.
            </p>
        `;
        return;
    }

    contenedor.innerHTML = datos.map(item => `
        <div class="flex items-center justify-between gap-4
                    py-2 border-b border-slate-100 last:border-0">

            <span class="text-sm font-medium text-slate-700">
                ${item.nombre_estructura || "-"}
            </span>

            <span class="text-sm text-slate-600">
                ${item.descripcion || "-"}
            </span>

        </div>
    `).join("");
}
//===========================================
//MOSTRAR INDICADORES DE SALUD BUCAL
//===========================================
function mostrarIndicadores(datos) {

    const contenedor = document.getElementById("historiaIndicadores");

    if (!contenedor) return;

    if (!datos || datos.length === 0) {
        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron indicadores de salud bucal.
            </p>
        `;
        return;
    }

    contenedor.innerHTML = datos.map(item => `
        <div class="flex items-center justify-between gap-4
                    py-2 border-b border-slate-100 last:border-0">

            <span class="text-sm font-medium text-slate-700">
                ${item.nombre_tipo_indicador || "-"}
            </span>

            <span class="px-3 py-1 rounded-full
                         bg-blue-50 text-blue-700
                         text-xs font-semibold">
                ${item.nombre_indicador || "-"}
            </span>

        </div>
    `).join("");
}
//===========================================
//MOSTRAR HIGIENE ORAL
//===========================================
function mostrarHigieneOral(datos) {

    const contenedor = document.getElementById("historiaHigieneOral");

    if (!contenedor) return;

    if (!datos || datos.length === 0) {
        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron datos de higiene oral.
            </p>
        `;
        return;
    }

    contenedor.innerHTML = `
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-600">
                        <th class="text-left py-2 px-3">Pieza</th>
                        <th class="text-center py-2 px-3">Placa</th>
                        <th class="text-center py-2 px-3">Cálculo</th>
                        <th class="text-center py-2 px-3">Gingivitis</th>
                    </tr>
                </thead>

                <tbody>
                    ${datos.map(item => `
                        <tr class="border-b border-slate-100 last:border-0">

                            <td class="py-2 px-3 font-semibold text-slate-700">
                                ${item.pieza_dental || "-"}
                            </td>

                            <td class="py-2 px-3 text-center text-slate-600">
                                ${item.placa_bacteriana ?? "-"}
                            </td>

                            <td class="py-2 px-3 text-center text-slate-600">
                                ${item.calculo ?? "-"}
                            </td>

                            <td class="py-2 px-3 text-center text-slate-600">
                                ${item.gingivitis ?? "-"}
                            </td>

                        </tr>
                    `).join("")}
                </tbody>
            </table>
        </div>
    `;
}

//===========================================
//MOSTRAR ODONTOGRAMA DE LA HISTORIA
//===========================================
function mostrarOdontogramaHistoria(odontograma) {

    const contenedor = document.getElementById("historiaOdontograma");

    if (!contenedor) return;

    const registros = odontograma?.registros || [];
    const protesis = odontograma?.protesis || [];

    if (registros.length === 0 && protesis.length === 0) {
        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron datos en el odontograma.
            </p>
        `;
        return;
    }

    // Separamos los registros según dentición
    const permanentes = registros.filter(
        item => Number(item.tipo_denticion_id) === 1
    );

    const temporales = registros.filter(
        item => Number(item.tipo_denticion_id) === 2
    );

    contenedor.innerHTML = `
        <div class="space-y-8">

            ${
                permanentes.length > 0
                    ? crearOdontogramaPermanenteHistoria(permanentes,protesis)
                    : ""
            }

            ${
                temporales.length > 0
                    ? crearOdontogramaTemporalHistoria(temporales,protesis)
                    : ""
            }

        </div>
    `;
}
//ODONTOGRAMA PERMANENTE
function crearOdontogramaPermanenteHistoria(registros,protesis) {

    const superiorDerecho = [18,17,16,15,14,13,12,11];
    const superiorIzquierdo = [21,22,23,24,25,26,27,28];

    const inferiorDerecho = [48,47,46,45,44,43,42,41];
    const inferiorIzquierdo = [31,32,33,34,35,36,37,38];

    return `
        <div class="border border-slate-200 rounded-xl p-5">

            <div class="flex items-center justify-between mb-6">
                <h4 class="font-semibold text-slate-800">
                    Dentición Permanente
                </h4>

                <span class="text-xs font-medium
                             bg-slate-100 text-slate-600
                             px-3 py-1 rounded-full">
                    Solo lectura
                </span>
            </div>

            <div class="overflow-x-auto">

                <div class="min-w-[1050px] space-y-8">

                    <div class="flex justify-center gap-4">

                        ${crearFilaHistoria(
                            superiorDerecho,
                            registros,protesis
                        )}

                        <div class="w-12"></div>

                        ${crearFilaHistoria(
                            superiorIzquierdo,
                            registros, protesis
                        )}

                    </div>

                    <div class="flex justify-center gap-4">

                        ${crearFilaHistoria(
                            inferiorDerecho,
                            registros,protesis
                        )}

                        <div class="w-12"></div>

                        ${crearFilaHistoria(
                            inferiorIzquierdo,
                            registros,protesis
                        )}

                    </div>

                </div>

            </div>

        </div>
    `;
}
//ODONTOGRAMA TEMPORAL
function crearOdontogramaTemporalHistoria(registros,protesis) {

    const superiorDerecho = [55,54,53,52,51];
    const superiorIzquierdo = [61,62,63,64,65];

    const inferiorDerecho = [85,84,83,82,81];
    const inferiorIzquierdo = [71,72,73,74,75];

    return `
        <div class="border border-slate-200 rounded-xl p-5">

            <div class="flex items-center justify-between mb-6">

                <h4 class="font-semibold text-slate-800">
                    Dentición Temporal
                </h4>

                <span class="text-xs font-medium
                             bg-slate-100 text-slate-600
                             px-3 py-1 rounded-full">
                    Solo lectura
                </span>

            </div>

            <div class="overflow-x-auto">

                <div class="min-w-[720px] space-y-8">

                    <div class="flex justify-center gap-4">

                        ${crearFilaHistoria(
                            superiorDerecho,
                            registros,protesis
                        )}

                        <div class="w-12"></div>

                        ${crearFilaHistoria(
                            superiorIzquierdo,
                            registros,protesis
                        )}

                    </div>

                    <div class="flex justify-center gap-4">

                        ${crearFilaHistoria(
                            inferiorDerecho,
                            registros,protesis
                        )}

                        <div class="w-12"></div>

                        ${crearFilaHistoria(
                            inferiorIzquierdo,
                            registros,protesis
                        )}

                    </div>

                </div>

            </div>

        </div>
    `;
}
//CREAR FILA DE ODONTOGRAMA PARA HISTORIA
function crearFilaHistoria(piezas, registros,protesis) {

    return `
        <div class="flex gap-3">

            ${piezas.map(numero =>
                crearDienteHistoria(numero, registros,protesis)
            ).join("")}

        </div>
    `;
}
//CREAR DIENTE PARA HISTORIA
function crearDienteHistoria(numero, registros,protesis) {

    const datosPieza = registros.filter(
        item => Number(item.numero_pieza) === Number(numero)
    );

    return `
        <div class="flex flex-col items-center select-none">

            <span class="text-xs font-semibold text-slate-700 mb-1">
                ${numero}
            </span>

            <div class="relative w-12 h-12">

                <div
                    class="${claseSuperficieHistoria(numero,"superior",datosPieza)}
                    absolute top-0 left-1/2 -translate-x-1/2
                    w-6 h-3 border border-slate-500 rounded-t">
                </div>

                <div
                    class="${claseSuperficieHistoria(numero,"izquierda",datosPieza)}
                    absolute top-3 left-0
                    w-3 h-6 border border-slate-500 rounded-l">
                </div>

                <div
                    class="${claseSuperficieHistoria(numero,"oclusal",datosPieza)}
                    absolute top-3 left-3
                    w-6 h-6 border border-slate-500">
                </div>

                <div
                    class="${claseSuperficieHistoria(numero,"derecha",datosPieza)}
                    absolute top-3 right-0
                    w-3 h-6 border border-slate-500 rounded-r">
                </div>

                <div
                    class="${claseSuperficieHistoria(numero,
                        "inferior",
                        datosPieza
                    )}
                    absolute bottom-0 left-1/2 -translate-x-1/2
                    w-6 h-3 border border-slate-500 rounded-b">
                </div>
                ${crearSimbolosDienteHistoria(datosPieza)}
                ${crearProtesisDienteHistoria(numero,protesis)}

            </div>

        </div>
    `;
}
//CONVERTIR SUPERFICIE EN CLASE PARA HISTORIA
function obtenerSuperficieHistoria(numeroPieza, cara) {
    const pieza = Number(numeroPieza);
    if (cara === "oclusal") {
        return "Oclusal/Incisal";
    }

    const cuadrante = Math.floor(pieza / 10);
    const esSuperior = [1,2,5,6].includes(cuadrante);
    if (cara === "superior") {
        return esSuperior ? "Vestibular" : "Lingual/Palatina";
    }

    if (cara === "inferior") {
        return esSuperior ? "Lingual/Palatina" : "Vestibular";
    }

    const ladoDerechoPaciente = [1,4,5,8].includes(cuadrante);
    if (cara === "izquierda") {
        return ladoDerechoPaciente ? "Distal" : "Mesial";
    }

    if (cara === "derecha") {
        return ladoDerechoPaciente ? "Mesial" : "Distal";
    }
    return null;
}
//CONVERTIR SUPERFICIE EN CLASE PARA HISTORIA
function claseSuperficieHistoria(numero, cara, registros) {
    const superficie = obtenerSuperficieHistoria(numero, cara);
    const registro = registros.find(item => item.nombre_superficie === superficie);
    if (!registro) {
        return "bg-white";
    }

    switch (registro.clave_simbologia) {
        case "caries":
            return "bg-red-500";

        case "obturacion":
            return "bg-blue-500";

        default:
            return "bg-white";
    }
}
//CREAR SÍMBOLOS DE DIENTE PARA HISTORIA
function crearSimbolosDienteHistoria(registros) {

    if (!Array.isArray(registros) || registros.length === 0) {
        return "";
    }

    // Solo registros que corresponden a símbolos,
    // no a superficies dentales.
    const simbolos = registros
        .filter(item => !item.id_superficie)
        .map(item => item.clave_simbologia)
        .filter(Boolean);

    let html = "";

    simbolos.forEach(simbolo => {

        switch (simbolo) {

            // ==========================================
            // AUSENTE
            // ==========================================
            case "ausente":
                html += `
                    <div class="absolute inset-0
                                flex items-center justify-center
                                pointer-events-none">

                        <span class="text-xl font-bold text-slate-700">
                            A
                        </span>

                    </div>
                `;
                break;


            // ==========================================
            // CORONA INDICADA
            // ==========================================
            case "corona_indicada":
                html += crearCoronaHistoria("red");
                break;


            // ==========================================
            // CORONA REALIZADA
            // ==========================================
            case "corona_realizada":
                html += crearCoronaHistoria("blue");
                break;


            // ==========================================
            // ENDODONCIA POR REALIZAR
            // ==========================================
            case "endodoncia_requerida":
                html += crearEndodonciaHistoria("red");
                break;


            // ==========================================
            // ENDODONCIA REALIZADA
            // ==========================================
            case "endodoncia_realizada":
                html += crearEndodonciaHistoria("blue");
                break;


            // ==========================================
            // EXTRACCIÓN INDICADA
            // ==========================================
            case "extraccion":
                html += crearXHistoria("red");
                break;


            // ==========================================
            // PÉRDIDA POR CARIES
            // ==========================================
            case "perdida_caries":
                html += crearXHistoria("blue");
                break;


            // ==========================================
            // PÉRDIDA POR OTRA CAUSA
            // ==========================================
            case "perdida_otra":
                html += crearPerdidaOtraHistoria();
                break;


            // ==========================================
            // SELLANTE NECESARIO
            // ==========================================
            case "sellante_necesario":
                html += crearSellanteHistoria("red");
                break;


            // ==========================================
            // SELLANTE REALIZADO
            // ==========================================
            case "sellante_realizado":
                html += crearSellanteHistoria("blue");
                break;
        }

    });

    return html;
}
//CREAR CORONA PARA HISTORIA
function crearCoronaHistoria(color) {

    const borde = color === "red"
        ? "border-red-600"
        : "border-blue-700";

    const fondo = color === "red"
        ? "bg-red-600"
        : "bg-blue-700";

    return `
        <div class="absolute inset-0
                    flex items-center justify-center
                    pointer-events-none">

            <div class="w-11 h-11 border-[3px] ${borde}
                        flex items-center justify-center">

                <div class="w-8 h-8 border-[3px] ${borde}
                            flex items-center justify-center">

                    <div class="w-5 h-5 border-[3px] ${borde}
                                flex items-center justify-center">

                        <div class="w-2 h-2 ${fondo}"></div>

                    </div>

                </div>

            </div>

        </div>
    `;
}
//CREAR ENDODONCIA PARA HISTORIA
function crearEndodonciaHistoria(color) {

    const borde = color === "red"
        ? "border-b-red-600"
        : "border-b-blue-600";

    return `
        <div class="absolute inset-0
                    flex items-center justify-center
                    pointer-events-none">

            <div class="w-0 h-0
                        border-l-[8px] border-l-transparent
                        border-r-[8px] border-r-transparent
                        border-b-[14px] ${borde}">
            </div>

        </div>
    `;
}
//CREAR X PARA HISTORIA
function crearXHistoria(color) {

    const fondo = color === "red"
        ? "bg-red-600"
        : "bg-blue-600";

    return `
        <div class="absolute inset-0 pointer-events-none">

            <div class="absolute top-1/2 left-0
                        w-full h-0.5 ${fondo}
                        rotate-45 origin-center">
            </div>

            <div class="absolute top-1/2 left-0
                        w-full h-0.5 ${fondo}
                        -rotate-45 origin-center">
            </div>

        </div>
    `;
}
//CREAR PÉRDIDA POR OTRA CAUSA PARA HISTORIA
function crearPerdidaOtraHistoria() {

    return `
        <div class="absolute inset-0 pointer-events-none">

            <div class="absolute inset-0
                        border-2 border-black rounded-full">
            </div>

            <div class="absolute top-1/2 left-0
                        w-full h-0.5 bg-black
                        rotate-45 origin-center">
            </div>

            <div class="absolute top-1/2 left-0
                        w-full h-0.5 bg-black
                        -rotate-45 origin-center">
            </div>

        </div>
    `;
}
//CREAR SELLANTE PARA HISTORIA
function crearSellanteHistoria(color) {

    const texto = color === "red"
        ? "text-red-600"
        : "text-blue-600";

    return `
        <div class="absolute inset-0
                    flex items-center justify-center
                    pointer-events-none">

            <span class="${texto}
                         text-2xl font-bold leading-none">
                *
            </span>

        </div>
    `;
}
//CREAMOS LAS PROTESIS
function crearProtesisDienteHistoria(numero, protesis) {

    if (!Array.isArray(protesis) || protesis.length === 0) {
        return "";
    }

    let html = "";

    protesis.forEach(item => {

        const inicio = Number(item.pieza_inicio);
        const fin = Number(item.pieza_fin);

        if (!inicio || !fin) {
            return;
        }

        const rango =
            obtenerRangoProtesisHistoria(inicio, fin);

        if (!rango.includes(Number(numero))) {
            return;
        }

        const esInicio = Number(numero) === inicio;
        const esFin = Number(numero) === fin;

        switch (item.clave_simbologia) {

            case "protesis_fija_indicada":
                html += crearProtesisFijaHistoria(
                    esInicio,
                    esFin,
                    "red"
                );
                break;

            case "protesis_fija_realizada":
                html += crearProtesisFijaHistoria(
                    esInicio,
                    esFin,
                    "blue"
                );
                break;

            case "protesis_removible_indicada":
                html += crearProtesisRemovibleHistoria(
                    esInicio,
                    esFin,
                    "red"
                );
                break;

            case "protesis_removible_realizada":
                html += crearProtesisRemovibleHistoria(
                    esInicio,
                    esFin,
                    "blue"
                );
                break;

            case "protesis_total_indicada":
                html += crearProtesisTotalHistoria("red");
                break;

            case "protesis_total_realizada":
                html += crearProtesisTotalHistoria("blue");
                break;
        }
    });

    return html;
}
//OBTENEMOS EL RANGO DE PIEZAS PARA LA PROTESIS
function obtenerRangoProtesisHistoria(inicio, fin) {

    inicio = Number(inicio);
    fin = Number(fin);

    const arcadas = [
        [18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28],
        [48,47,46,45,44,43,42,41,31,32,33,34,35,36,37,38],
        [55,54,53,52,51,61,62,63,64,65],
        [85,84,83,82,81,71,72,73,74,75]
    ];

    for (const arcada of arcadas) {

        const iInicio = arcada.indexOf(inicio);
        const iFin = arcada.indexOf(fin);

        if (iInicio === -1 || iFin === -1) {
            continue;
        }

        const desde = Math.min(iInicio, iFin);
        const hasta = Math.max(iInicio, iFin);

        return arcada.slice(desde, hasta + 1);
    }

    return [];
}
//DIBUJAMOS LA PROTESIS
function crearProtesisFijaHistoria(esInicio, esFin, color) {

    const fondo =
        color === "red"
            ? "bg-red-600"
            : "bg-blue-600";

    return `
        <div class="absolute -left-1.5 -right-1.5 top-1/2
                    -translate-y-1/2 z-30
                    pointer-events-none">

            <div class="absolute left-0 right-0
                        top-1/2 -translate-y-1/2
                        h-[3px] ${fondo}">
            </div>

            ${esInicio ? `
                <div class="absolute left-0 top-1/2
                            -translate-y-1/2
                            w-3 h-3 ${fondo}">
                </div>
            ` : ""}

            ${esFin ? `
                <div class="absolute right-0 top-1/2
                            -translate-y-1/2
                            w-3 h-3 ${fondo}">
                </div>
            ` : ""}

        </div>
    `;
}


function crearProtesisRemovibleHistoria(esInicio, esFin, color) {

    const fondo =
        color === "red"
            ? "bg-red-600"
            : "bg-blue-600";

    const texto =
        color === "red"
            ? "text-red-600"
            : "text-blue-600";

    return `
        <div class="absolute -left-1.5 -right-1.5 top-1/2
                    -translate-y-1/2 z-30
                    pointer-events-none">

            <div class="absolute left-0 right-0
                        top-1/2 -translate-y-1/2
                        h-[3px] ${fondo}">
            </div>

            ${esInicio ? `
                <span class="absolute -left-1 top-1/2
                             -translate-y-1/2
                             text-2xl font-bold ${texto}">
                    (
                </span>
            ` : ""}

            ${esFin ? `
                <span class="absolute -right-1 top-1/2
                             -translate-y-1/2
                             text-2xl font-bold ${texto}">
                    )
                </span>
            ` : ""}

        </div>
    `;
}


function crearProtesisTotalHistoria(color) {

    const fondo =
        color === "red"
            ? "bg-red-600"
            : "bg-blue-600";

    return `
        <div class="absolute -left-1.5 -right-1.5 top-1/2
                    -translate-y-1/2 z-30
                    pointer-events-none">

            <div class="absolute left-0 right-0 -top-1
                        h-[2px] ${fondo}">
            </div>

            <div class="absolute left-0 right-0 top-1
                        h-[2px] ${fondo}">
            </div>

        </div>
    `;
}

//===========================================
// MOSTRAR DIAGNÓSTICOS CIE-10
//===========================================
function mostrarDiagnosticos(datos) {

    const contenedor =
        document.getElementById("historiaDiagnosticos");

    if (!contenedor) return;

    if (!Array.isArray(datos) || datos.length === 0) {

        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron diagnósticos en esta atención.
            </p>
        `;

        return;
    }

    contenedor.innerHTML = datos.map(item => {

        const tipo =
            item.tipo_diagnostico === "DEF"
                ? "Definitivo"
                : item.tipo_diagnostico === "PRE"
                    ? "Presuntivo"
                    : item.tipo_diagnostico || "-";

        const claseTipo =
            item.tipo_diagnostico === "DEF"
                ? "bg-green-50 text-green-700"
                : "bg-amber-50 text-amber-700";

        return `
            <div class="py-3 border-b border-slate-100 last:border-0">

                <div class="flex flex-wrap items-center gap-2">

                    <span class="px-2.5 py-1 rounded-lg
                                 bg-blue-50 text-blue-700
                                 text-xs font-bold">
                        ${escaparHTML(item.codigo_cie10 || "-")}
                    </span>

                    <span class="px-2.5 py-1 rounded-full
                                 ${claseTipo}
                                 text-xs font-semibold">
                        ${escaparHTML(tipo)}
                    </span>

                </div>

                <p class="mt-2 text-sm font-medium text-slate-700">
                    ${escaparHTML(item.descripcion_cie10 || "-")}
                </p>

            </div>
        `;

    }).join("");
}

//===========================================
// CALCULAR ÍNDICES CPOD / ceod HISTÓRICOS
// Misma lógica utilizada en Atención
//===========================================
function calcularIndicesHistoria(odontograma) {

    const registros = Array.isArray(odontograma?.registros)
        ? odontograma.registros
        : [];

    const protesis = Array.isArray(odontograma?.protesis)
        ? odontograma.protesis
        : [];

    // ==========================================
    // AGRUPAR REGISTROS POR PIEZA
    // ==========================================
    const piezas = {};

    registros.forEach(registro => {

        const numero = Number(registro.numero_pieza);

        if (!numero) return;

        if (!piezas[numero]) {
            piezas[numero] = {
                denticion: Number(registro.tipo_denticion_id),
                caras: [],
                simbolos: []
            };
        }

        if (registro.nombre_superficie) {

            piezas[numero].caras.push(
                registro.clave_simbologia
            );

        } else {

            piezas[numero].simbolos.push(
                registro.clave_simbologia
            );
        }
    });

    // ==========================================
    // CPOD - DENTICIÓN PERMANENTE
    // ==========================================
    let C = 0;
    let P = 0;
    let O = 0;

    Object.entries(piezas).forEach(([numero, estado]) => {

        const pieza = Number(numero);

        // Solo dentición permanente
        if (estado.denticion !== 1) return;

        const caras = estado.caras;
        const simbolos = estado.simbolos;

        // ======================================
        // C = CARIADO
        // ======================================
        // Caries o endodoncia por realizar.
        // Si tiene obturación + caries,
        // prevalece caries.
        if (
            caras.includes("caries") ||
            simbolos.includes("endodoncia_requerida")
        ) {
            C++;
            return;
        }

        // ======================================
        // P = PERDIDO POR CARIES
        // ======================================
        if (simbolos.includes("perdida_caries")) {
            P++;
            return;
        }

        // ======================================
        // O = OBTURADO
        // ======================================
        if (
            caras.includes("obturacion") ||
            simbolos.includes("endodoncia_realizada") ||
            simbolos.includes("corona_realizada")
        ) {
            O++;
            return;
        }
    });


    // ==========================================
    // PRÓTESIS REMOVIBLE REALIZADA
    // ==========================================
    protesis
        .filter(item =>
            item.clave_simbologia === "protesis_removible_realizada"
        )
        .forEach(item => {

            const rango = obtenerRangoProtesisHistoria(
                Number(item.pieza_inicio),
                Number(item.pieza_fin)
            );

            rango.forEach(pieza => {

                // Igual que Atención:
                // si ya está marcada pérdida por caries,
                // no volver a contarla.
                const estado = piezas[pieza];

                if (
                    estado &&
                    estado.simbolos.includes("perdida_caries")
                ) {
                    return;
                }

                P++;
            });
        });


    // ==========================================
    // PRÓTESIS TOTAL REALIZADA
    // ==========================================
    protesis
        .filter(item =>
            item.clave_simbologia === "protesis_total_realizada"
        )
        .forEach(item => {

            const rango = obtenerRangoProtesisHistoria(
                Number(item.pieza_inicio),
                Number(item.pieza_fin)
            );

            rango.forEach(pieza => {

                // No se toman en cuenta terceros molares
                if (
                    pieza === 18 ||
                    pieza === 28 ||
                    pieza === 38 ||
                    pieza === 48
                ) {
                    return;
                }

                P++;
            });
        });


    // ==========================================
    // ceod - DENTICIÓN TEMPORAL
    // ==========================================
    let c = 0;
    let e = 0;
    let o = 0;

    Object.values(piezas).forEach(estado => {

        // Solo dentición temporal
        if (estado.denticion !== 2) return;

        const caras = estado.caras;
        const simbolos = estado.simbolos;

        // e = extracción indicada
        if (simbolos.includes("extraccion")) {
            e++;
            return;
        }

        // c = caries
        if (caras.includes("caries")) {
            c++;
            return;
        }

        // o = obturación
        if (caras.includes("obturacion")) {
            o++;
        }
    });


    return {

        cpod: {
            C: C,
            P: P,
            O: O,
            total: C + P + O
        },

        ceod: {
            c: c,
            e: e,
            o: o,
            total: c + e + o
        }
    };
}

function obtenerRangoProtesisHistoria(inicio, fin) {

    const arcadas = [

        // Permanente superior
        [
            18,17,16,15,14,13,12,11,
            21,22,23,24,25,26,27,28
        ],

        // Permanente inferior
        [
            48,47,46,45,44,43,42,41,
            31,32,33,34,35,36,37,38
        ],

        // Temporal superior
        [
            55,54,53,52,51,
            61,62,63,64,65
        ],

        // Temporal inferior
        [
            85,84,83,82,81,
            71,72,73,74,75
        ]
    ];

    for (const arcada of arcadas) {

        const posicionInicio =
            arcada.indexOf(Number(inicio));

        const posicionFin =
            arcada.indexOf(Number(fin));

        if (
            posicionInicio !== -1 &&
            posicionFin !== -1
        ) {

            const desde =
                Math.min(posicionInicio, posicionFin);

            const hasta =
                Math.max(posicionInicio, posicionFin);

            return arcada.slice(
                desde,
                hasta + 1
            );
        }
    }

    return [];
}
//===========================================
// MOSTRAR ÍNDICES CPOD / ceod
//===========================================
function mostrarIndicesHistoria(odontograma) {

    const indices =
        calcularIndicesHistoria(odontograma);

    colocarTexto(
        "historiaCPODC",
        indices.cpod.C
    );

    colocarTexto(
        "historiaCPODP",
        indices.cpod.P
    );

    colocarTexto(
        "historiaCPODO",
        indices.cpod.O
    );

    colocarTexto(
        "historiaCPODTotal",
        indices.cpod.total
    );

    colocarTexto(
        "historiaCEODC",
        indices.ceod.c
    );

    colocarTexto(
        "historiaCEODE",
        indices.ceod.e
    );

    colocarTexto(
        "historiaCEODO",
        indices.ceod.o
    );

    colocarTexto(
        "historiaCEODTotal",
        indices.ceod.total
    );

    console.log(
        "ÍNDICES HISTÓRICOS:",
        indices
    );
}

//===========================================
// CALCULAR HIGIENE ORAL SIMPLIFICADA
// FORMULARIO 033 - MSP
//===========================================
function calcularHigieneOralHistoria(datos) {

    if (!Array.isArray(datos) || datos.length === 0) {

        return {
            placa: 0,
            calculo: 0,
            gingivitis: 0,
            piezasExaminadas: 0
        };
    }

    let totalPlaca = 0;
    let totalCalculo = 0;
    let totalGingivitis = 0;

    let piezasExaminadas = 0;

    datos.forEach(item => {

        // Debe existir una pieza examinada
        if (!item.pieza_dental) {
            return;
        }

        // Conservamos los valores originales para
        // distinguir "" de un cero válido
        const placaValor = item.placa_bacteriana;
        const calculoValor = item.calculo;
        const gingivitisValor = item.gingivitis;

        // Si la pieza no tiene los tres valores,
        // no se considera examinada
        if (
            placaValor === null ||
            placaValor === "" ||
            calculoValor === null ||
            calculoValor === "" ||
            gingivitisValor === null ||
            gingivitisValor === ""
        ) {
            return;
        }

        const placa = Number(placaValor);
        const calculo = Number(calculoValor);
        const gingivitis = Number(gingivitisValor);

        // Seguridad ante datos no numéricos
        if (
            !Number.isFinite(placa) ||
            !Number.isFinite(calculo) ||
            !Number.isFinite(gingivitis)
        ) {
            return;
        }

        totalPlaca += placa;
        totalCalculo += calculo;
        totalGingivitis += gingivitis;

        piezasExaminadas++;
    });

    //===========================================
    // PROMEDIOS
    //===========================================

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

    return {
        placa: promedioPlaca,
        calculo: promedioCalculo,
        gingivitis: promedioGingivitis,
        piezasExaminadas: piezasExaminadas
    };
}


//===========================================
// MOSTRAR TOTALES HIGIENE ORAL
//===========================================
function mostrarTotalesHigieneOral(datos) {
    const resultado =
        calcularHigieneOralHistoria(datos);

    colocarTexto(
        "historiaTotalPlaca",
        resultado.placa.toFixed(2)
    );

    colocarTexto(
        "historiaTotalCalculo",
        resultado.calculo.toFixed(2)
    );

    colocarTexto(
        "historiaTotalGingivitis",
        resultado.gingivitis.toFixed(2)
    );

    console.log(
        "HIGIENE ORAL SIMPLIFICADA:",
        resultado
    );
}

//===========================================
// MOSTRAR TRATAMIENTOS REALIZADOS
//===========================================
function mostrarTratamientos(datos) {

    const contenedor =
        document.getElementById("historiaTratamientos");

    if (!contenedor) return;

    if (!Array.isArray(datos) || datos.length === 0) {

        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron tratamientos en esta atención.
            </p>
        `;

        return;
    }

    contenedor.innerHTML = datos.map(item => `

        <div class="flex items-center justify-between gap-4
                    py-3 border-b border-slate-100 last:border-0">

            <div class="flex items-center gap-3">

                <div class="w-2 h-2 rounded-full bg-blue-600"></div>

                <span class="text-sm font-medium text-slate-700">
                    ${escaparHTML(
                        item.nombre_procedimiento || "-"
                    )}
                </span>

            </div>

            ${
                Number(item.cantidad) > 1
                    ? `
                        <span class="px-2.5 py-1 rounded-full
                                     bg-slate-100 text-slate-600
                                     text-xs font-semibold">
                            Cantidad: ${escaparHTML(item.cantidad)}
                        </span>
                    `
                    : ""
            }

        </div>

    `).join("");
}

//===========================================
// MOSTRAR EXÁMENES COMPLEMENTARIOS
//===========================================
function mostrarExamenesComplementarios(datos) {

    const contenedor =
        document.getElementById("historiaExamenes");

    if (!contenedor) return;

    if (!Array.isArray(datos) || datos.length === 0) {

        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron exámenes complementarios.
            </p>
        `;

        return;
    }

    contenedor.innerHTML = datos.map(item => `

        <div class="flex items-center gap-3
                    py-3 border-b border-slate-100 last:border-0">

            <div class="w-2 h-2 rounded-full bg-blue-600"></div>

            <span class="text-sm font-medium text-slate-700">
                ${escaparHTML(item.nombre_examen || "-")}
            </span>

        </div>

    `).join("");
}

//===========================================
// MOSTRAR INFORMES DE EXÁMENES
//===========================================
function mostrarInformesExamenes(datos) {

    const contenedor =
        document.getElementById("historiaInformes");

    if (!contenedor) return;

    if (!Array.isArray(datos) || datos.length === 0) {

        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron informes de exámenes.
            </p>
        `;

        return;
    }

    contenedor.innerHTML = datos.map(item => `

        <div class="py-3 border-b border-slate-100 last:border-0">

            <p class="text-sm text-slate-700 whitespace-pre-line">
                ${escaparHTML(item.descripcion || "-")}
            </p>

        </div>

    `).join("");
}

//===========================================
// MOSTRAR COMPLICACIONES
//===========================================
function mostrarComplicaciones(datos) {

    const contenedor =
        document.getElementById("historiaComplicaciones");

    if (!contenedor) return;

    if (!Array.isArray(datos) || datos.length === 0) {

        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron complicaciones.
            </p>
        `;

        return;
    }

    contenedor.innerHTML = datos.map(item => `

        <div class="flex items-start gap-3
                    py-3 border-b border-slate-100 last:border-0">

            <div class="w-2 h-2 mt-1.5 rounded-full
                        bg-orange-500 shrink-0">
            </div>

            <p class="text-sm text-slate-700">
                ${escaparHTML(item.descripcion || "-")}
            </p>

        </div>

    `).join("");
}

//===========================================
// MOSTRAR PRESCRIPCIÓN MÉDICA
//===========================================
function mostrarPrescripcion(datos) {

    const contenedor =
        document.getElementById("historiaPrescripcion");

    if (!contenedor) return;

    if (!Array.isArray(datos) || datos.length === 0) {

        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registró prescripción médica.
            </p>
        `;

        return;
    }

    contenedor.innerHTML = datos.map(item => `

        <div class="py-4 border-b border-slate-100 last:border-0">

            <div class="flex items-center gap-2 mb-3">

                <span class="w-2 h-2 rounded-full bg-blue-600"></span>

                <h4 class="font-semibold text-slate-800">
                    ${escaparHTML(item.medicamento || "-")}
                </h4>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                <div>
                    <p class="text-xs text-slate-500">
                        Dosis
                    </p>
                    <p class="text-sm font-medium text-slate-700 mt-1">
                        ${escaparHTML(item.dosis || "-")}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Frecuencia
                    </p>
                    <p class="text-sm font-medium text-slate-700 mt-1">
                        ${escaparHTML(item.frecuencia || "-")}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Duración
                    </p>
                    <p class="text-sm font-medium text-slate-700 mt-1">
                        ${escaparHTML(item.duracion || "-")}
                    </p>
                </div>

            </div>

            ${
                item.indicaciones
                    ? `
                        <div class="mt-3 pt-3 border-t border-slate-100">

                            <p class="text-xs text-slate-500">
                                Indicaciones
                            </p>

                            <p class="text-sm text-slate-700 mt-1">
                                ${escaparHTML(item.indicaciones)}
                            </p>

                        </div>
                    `
                    : ""
            }

        </div>

    `).join("");
}

//===========================================
// MOSTRAR FOTOGRAFÍAS CLÍNICAS
//===========================================
function mostrarFotografias(datos) {

    const contenedor =
        document.getElementById("historiaFotografias");

    if (!contenedor) return;

    if (!Array.isArray(datos) || datos.length === 0) {

        contenedor.innerHTML = `
            <p class="text-sm text-slate-500">
                No se registraron fotografías en esta atención.
            </p>
        `;

        return;
    }

    contenedor.innerHTML = `
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            ${datos.map(item => {

                const ruta = "/" + String(
                    item.ruta_archivo || ""
                ).replace(/^\/+/, "");

                return `
                    <div class="border border-slate-200
                                rounded-xl overflow-hidden bg-white">

                        <button type="button"
                                class="block w-full"
                                onclick="abrirFotografiaHistoria(
                                    '${escaparHTML(ruta)}'
                                )">

                            <img
                                src="${escaparHTML(ruta)}"
                                alt="${escaparHTML(
                                    item.observacion ||
                                    item.nombre_archivo ||
                                    "Fotografía clínica"
                                )}"
                                class="w-full aspect-square object-cover
                                       hover:opacity-90 transition"
                            >

                        </button>

                        ${
                            item.observacion
                                ? `
                                    <div class="p-3">
                                        <p class="text-sm text-slate-600">
                                            ${escaparHTML(item.observacion)}
                                        </p>
                                    </div>
                                `
                                : ""
                        }

                    </div>
                `;

            }).join("")}

        </div>
    `;
}
//AMPLIAR FOTOGRAFIA AL HACER CLICK
function abrirFotografiaHistoria(ruta) {

    if (!ruta) return;

    const modal = document.createElement("div");

    modal.className =
        "fixed inset-0 z-[100] bg-black/80 " +
        "flex items-center justify-center p-4";

    modal.innerHTML = `
        <div class="relative max-w-5xl w-full">

            <button type="button"
                    class="absolute -top-10 right-0
                           text-white text-sm font-semibold">
                Cerrar ✕
            </button>

            <img
                src="${escaparHTML(ruta)}"
                alt="Fotografía clínica"
                class="max-h-[85vh] max-w-full mx-auto
                       object-contain rounded-xl bg-white"
            >

        </div>
    `;

    modal.addEventListener("click", function (event) {

        if (
            event.target === modal ||
            event.target.closest("button")
        ) {
            modal.remove();
        }

    });

    document.body.appendChild(modal);
}

// ==========================================
// COLOCAR TEXTO
// ==========================================
function colocarTexto(id, valor) {
    const elemento = document.getElementById(id);
    if (!elemento) {
        return;
    }
    elemento.textContent = valor === null || valor === undefined || valor === "" ? "-" : valor;
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
    const partes = String(fecha).split(" ");
    const fechaFormateada = formatearFecha(partes[0]);
    if (!partes[1]) {
        return fechaFormateada;
    }
    const hora = partes[1].substring(0, 5);
    return `${fechaFormateada} - ${hora}`;
}

// ==========================================
// ERROR DE HISTORIA
// ==========================================
function mostrarErrorHistoria(mensaje) {
    const cargando = document.getElementById("cargandoHistoria");
    if (!cargando) {
        return;
    }
    cargando.innerHTML = `<div class="text-red-600 font-medium"> ${escaparHTML(mensaje)}</div>
        <button type="button" onclick="volverHistorias()" class="mt-4 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium">
            Volver a Historias Clínicas
        </button>
    `;
}

// ==========================================
// VOLVER AL LISTADO
// ==========================================
function volverHistorias() {
    window.location.href = "/views/historias.php";
}