let listadoFotografias = [];
let archivosFotografias = [];


// ==========================================
// INICIALIZAR
// ==========================================
document.addEventListener("DOMContentLoaded", () => {

    cargarFotografias();

    const buscador =
        document.getElementById("buscarFotografia");

    const input =
        document.getElementById("inputFotografias");

    const btnGuardar =
        document.getElementById("btnGuardarFotografias");

    const visor =
    document.getElementById(
        "modalVisorFotografia"
    );

visor.addEventListener("click", function (event) {

    if (event.target === visor) {
        cerrarVisorFotografia();
    }

});


    buscador.addEventListener("input", filtrarFotografias);

    input.addEventListener(
        "change",
        seleccionarFotografias
    );

    btnGuardar.addEventListener(
        "click",
        guardarFotografias
    );

});

document.addEventListener("keydown", function (event) {

    if (event.key === "Escape") {

        const visor =
            document.getElementById(
                "modalVisorFotografia"
            );

        if (
            visor &&
            !visor.classList.contains("hidden")
        ) {
            cerrarVisorFotografia();
        }

    }

});

// ==========================================
// LISTAR ATENCIONES
// ==========================================
function cargarFotografias() {

    fetch("../ajax/atencion.php?op=listar_fotografias")

        .then(response => response.json())

        .then(respuesta => {

            if (!respuesta.status) {

                mostrarMensajeFotografia(
                    "Error",
                    respuesta.message ||
                    "No se pudieron cargar las fotografías.",
                    "error"
                );

                return;
            }

            listadoFotografias =
                respuesta.data || [];

            renderizarListado(
                listadoFotografias
            );

        })

        .catch(error => {

            console.error(error);

            mostrarMensajeFotografia(
                "Error",
                "Ocurrió un error al cargar las atenciones.",
                "error"
            );

        });

}


// ==========================================
// RENDERIZAR LISTADO
// ==========================================
function renderizarListado(datos) {

    const tabla =
        document.getElementById(
            "tbllistadoFotografias"
        );

    const cards =
        document.getElementById(
            "cardsFotografias"
        );


    tabla.innerHTML = "";
    cards.innerHTML = "";


    if (!datos.length) {

        tabla.innerHTML = `
            <tr>
                <td
                    colspan="5"
                    class="px-6 py-10
                           text-center
                           text-slate-500">
                    No se encontraron atenciones.
                </td>
            </tr>
        `;


        cards.innerHTML = `
            <div
                class="bg-white rounded-2xl
                       shadow-sm p-6
                       text-center text-slate-500">
                No se encontraron atenciones.
            </div>
        `;

        return;
    }


    datos.forEach(registro => {

        const nombreCompleto =
            `${registro.nombre} ${registro.apellido}`;


        const fecha =
            formatearFecha(
                registro.fecha_atencion
            );


        // ======================================
        // DESKTOP
        // ======================================

        tabla.innerHTML += `

            <tr
                class="border-b border-slate-100
                       hover:bg-slate-50">

                <td class="px-6 py-4">

                    <p class="font-semibold text-slate-800">
                        ${escaparHTML(nombreCompleto)}
                    </p>

                </td>


                <td class="px-6 py-4 text-slate-600">

                    ${escaparHTML(registro.cedula)}

                </td>


                <td
                    class="px-6 py-4
                           text-center text-slate-600">

                    ${fecha}

                </td>


                <td class="px-6 py-4 text-center">

                    <span
                        class="inline-flex
                               items-center
                               justify-center
                               min-w-10
                               px-3 py-1
                               rounded-full
                               bg-blue-100
                               text-blue-700
                               font-semibold">

                        ${registro.total_fotografias}

                    </span>

                </td>


                <td class="px-6 py-4">

                    <div
                        class="flex justify-center
                               items-center gap-2">

                        <button
                            type="button"
                            onclick='verFotografias(
                                ${Number(registro.id_atencion)},
                                ${JSON.stringify(nombreCompleto)}
                            )'
                            class="px-3 py-2
                                   bg-slate-100
                                   text-slate-700
                                   rounded-lg
                                   hover:bg-slate-200">

                            Ver

                        </button>


                        <button
                            type="button"
                            onclick='abrirAgregarFotografias(
                                ${Number(registro.id_atencion)},
                                ${JSON.stringify(nombreCompleto)}
                            )'
                            class="px-3 py-2
                                   bg-blue-600
                                   text-white
                                   rounded-lg
                                   hover:bg-blue-700">

                            + Agregar

                        </button>

                    </div>

                </td>

            </tr>
        `;


        // ======================================
        // MOBILE
        // ======================================

        cards.innerHTML += `

            <div
                class="bg-white
                       rounded-2xl
                       shadow-sm
                       border border-slate-100
                       p-5">

                <div
                    class="flex justify-between
                           gap-4">

                    <div>

                        <h3
                            class="font-bold
                                   text-slate-800">

                            ${escaparHTML(nombreCompleto)}

                        </h3>

                        <p
                            class="text-sm
                                   text-slate-500
                                   mt-1">

                            ${escaparHTML(registro.cedula)}

                        </p>

                    </div>


                    <span
                        class="h-fit
                               bg-blue-100
                               text-blue-700
                               font-semibold
                               text-sm
                               px-3 py-1
                               rounded-full">

                        ${registro.total_fotografias}
                        foto${Number(registro.total_fotografias) === 1 ? "" : "s"}

                    </span>

                </div>


                <div
                    class="mt-4
                           pt-4
                           border-t border-slate-100">

                    <p class="text-sm text-slate-500">
                        Fecha de atención
                    </p>

                    <p
                        class="font-medium
                               text-slate-700">

                        ${fecha}

                    </p>

                </div>


                <div
                    class="grid grid-cols-2
                           gap-2 mt-4">

                    <button
                        type="button"
                        onclick='verFotografias(
                            ${Number(registro.id_atencion)},
                            ${JSON.stringify(nombreCompleto)}
                        )'
                        class="px-3 py-2
                               bg-slate-100
                               text-slate-700
                               rounded-lg">

                        Ver

                    </button>


                    <button
                        type="button"
                        onclick='abrirAgregarFotografias(
                            ${Number(registro.id_atencion)},
                            ${JSON.stringify(nombreCompleto)}
                        )'
                        class="px-3 py-2
                               bg-blue-600
                               text-white
                               rounded-lg">

                        + Agregar

                    </button>

                </div>

            </div>
        `;

    });

}


// ==========================================
// BUSCAR
// ==========================================
function filtrarFotografias() {

    const texto =
        document.getElementById(
            "buscarFotografia"
        )
        .value
        .trim()
        .toLowerCase();


    if (!texto) {

        renderizarListado(
            listadoFotografias
        );

        return;
    }


    const filtrados =
        listadoFotografias.filter(registro => {

            const nombre =
                `${registro.nombre} ${registro.apellido}`
                .toLowerCase();

            const cedula =
                String(registro.cedula || "")
                .toLowerCase();


            return (
                nombre.includes(texto) ||
                cedula.includes(texto)
            );

        });


    renderizarListado(filtrados);

}


// ==========================================
// VER FOTOGRAFÍAS
// ==========================================
function verFotografias(
    idAtencion,
    paciente
) {

    document.getElementById(
        "pacienteGaleria"
    ).textContent = paciente;


    const galeria =
        document.getElementById(
            "galeriaFotografias"
        );


    galeria.innerHTML = `
        <div
            class="col-span-full
                   text-center
                   text-slate-500
                   py-10">
            Cargando fotografías...
        </div>
    `;


    abrirModal(
        "modalVerFotografias"
    );


    const formData =
        new FormData();

    formData.append(
        "id_atencion",
        idAtencion
    );


    fetch(
        "../ajax/atencion.php?op=listar_fotografias_atencion",
        {
            method: "POST",
            body: formData
        }
    )

        .then(response => response.json())

        .then(respuesta => {

            if (!respuesta.status) {

                galeria.innerHTML = `
                    <div
                        class="col-span-full
                               text-center
                               text-red-500
                               py-10">
                        ${escaparHTML(
                            respuesta.message ||
                            "No se pudieron cargar las fotografías."
                        )}
                    </div>
                `;

                return;
            }


            mostrarGaleria(
                respuesta.data || []
            );

        })

        .catch(error => {

            console.error(error);

            galeria.innerHTML = `
                <div
                    class="col-span-full
                           text-center
                           text-red-500
                           py-10">
                    Error al cargar las fotografías.
                </div>
            `;

        });

}


// ==========================================
// MOSTRAR GALERÍA
// ==========================================
function mostrarGaleria(fotografias) {

    const galeria =
        document.getElementById(
            "galeriaFotografias"
        );


    galeria.innerHTML = "";


    if (!fotografias.length) {

        galeria.innerHTML = `
            <div
                class="col-span-full
                       text-center
                       py-12">

                <p
                    class="text-slate-500
                           font-medium">

                    Esta atención todavía no tiene
                    fotografías clínicas.

                </p>

            </div>
        `;

        return;
    }


    fotografias.forEach(foto => {

        const ruta =
            "/" + String(foto.ruta_archivo)
                .replace(/^\/+/, "");


        galeria.innerHTML += `

            <div
                class="border border-slate-200
                       rounded-xl
                       overflow-hidden
                       bg-white">

                <div
                    class="aspect-[4/3]
                           bg-slate-100">

                    <img
    src="${escaparHTML(ruta)}"
    alt="Fotografía clínica"
    onclick='abrirVisorFotografia(
        ${JSON.stringify(ruta)},
        ${JSON.stringify(foto.nombre_archivo || "")},
        ${JSON.stringify(foto.observacion || "")}
    )'
    class="w-full h-full
           object-cover
           cursor-zoom-in
           hover:scale-105
           transition-transform
           duration-300"
    loading="lazy">

                </div>


                <div class="p-4">

                    <p
                        class="font-medium
                               text-slate-700
                               break-words">

                        ${escaparHTML(
                            foto.nombre_archivo
                        )}

                    </p>


                    <p
                        class="text-sm
                               text-slate-500
                               mt-2">

                        ${
                            foto.observacion
                            ? escaparHTML(foto.observacion)
                            : "Sin observación"
                        }

                    </p>


                    <p
                        class="text-xs
                               text-slate-400
                               mt-3">

                        Agregada:
                        ${formatearFechaHora(
                            foto.fecha_registro
                        )}

                    </p>

                </div>

            </div>
        `;

    });

}

// ==========================================
// ABRIR VISOR DE FOTOGRAFÍA
// ==========================================
function abrirVisorFotografia(
    ruta,
    nombre,
    observacion
) {

    const modal =
        document.getElementById(
            "modalVisorFotografia"
        );

    const imagen =
        document.getElementById(
            "imagenVisorFotografia"
        );

    const nombreElemento =
        document.getElementById(
            "nombreVisorFotografia"
        );

    const observacionElemento =
        document.getElementById(
            "observacionVisorFotografia"
        );


    imagen.src = ruta;

    nombreElemento.textContent =
        nombre || "Fotografía clínica";

    observacionElemento.textContent =
        observacion || "Sin observación";


    modal.classList.remove("hidden");
    modal.classList.add("flex");


    // Evita scroll de la página mientras está abierto
    document.body.classList.add(
        "overflow-hidden"
    );

}


// ==========================================
// CERRAR VISOR
// ==========================================
function cerrarVisorFotografia() {

    const modal =
        document.getElementById(
            "modalVisorFotografia"
        );

    const imagen =
        document.getElementById(
            "imagenVisorFotografia"
        );


    modal.classList.add("hidden");
    modal.classList.remove("flex");


    imagen.src = "";


    document.body.classList.remove(
        "overflow-hidden"
    );

}


// ==========================================
// ABRIR AGREGAR
// ==========================================
function abrirAgregarFotografias(
    idAtencion,
    paciente
) {

    archivosFotografias = [];

    document.getElementById(
        "idAtencionFotografia"
    ).value = idAtencion;


    document.getElementById(
        "pacienteAgregarFotografia"
    ).textContent = paciente;


    document.getElementById(
        "inputFotografias"
    ).value = "";


    document.getElementById(
        "previewFotografias"
    ).innerHTML = "";


    abrirModal(
        "modalAgregarFotografias"
    );

}


// ==========================================
// SELECCIONAR ARCHIVOS
// ==========================================
function seleccionarFotografias(event) {

    const archivos =
        Array.from(
            event.target.files || []
        );


    archivosFotografias = archivos.map(
        archivo => ({
            archivo: archivo,
            observacion: ""
        })
    );


    mostrarPreviews();

}


// ==========================================
// PREVIEWS
// ==========================================
function mostrarPreviews() {

    const contenedor =
        document.getElementById(
            "previewFotografias"
        );


    contenedor.innerHTML = "";


    archivosFotografias.forEach(
        (item, index) => {

            const url =
                URL.createObjectURL(
                    item.archivo
                );


            const div =
                document.createElement("div");


            div.className =
                "border border-slate-200 " +
                "rounded-xl overflow-hidden";


            div.innerHTML = `

                <div
                    class="relative
                           aspect-[4/3]
                           bg-slate-100">

                    <img
                        src="${url}"
                        class="w-full h-full
                               object-cover"
                        alt="Previsualización">

                    <button
                        type="button"
                        onclick="eliminarFotografiaSeleccionada(${index})"
                        class="absolute
                               top-2 right-2
                               w-8 h-8
                               bg-red-600
                               text-white
                               rounded-full
                               shadow
                               hover:bg-red-700">

                        &times;

                    </button>

                </div>


                <div class="p-4">

                    <p
                        class="font-medium
                               text-slate-700
                               text-sm
                               truncate">

                        ${escaparHTML(
                            item.archivo.name
                        )}

                    </p>


                    <label
                        class="block
                               text-sm
                               text-slate-600
                               mt-3 mb-1">

                        Observación

                    </label>


                    <textarea
                        rows="2"
                        oninput="actualizarObservacion(
                            ${index},
                            this.value
                        )"
                        placeholder="Observación de esta fotografía..."
                        class="w-full
                               px-3 py-2
                               border border-slate-300
                               rounded-lg
                               resize-none
                               focus:outline-none
                               focus:ring-2
                               focus:ring-blue-500"></textarea>

                </div>
            `;


            contenedor.appendChild(div);

        }
    );

}


// ==========================================
// OBSERVACIÓN INDIVIDUAL
// ==========================================
function actualizarObservacion(
    index,
    valor
) {

    if (!archivosFotografias[index]) {
        return;
    }

    archivosFotografias[index]
        .observacion = valor;

}


// ==========================================
// ELIMINAR DEL PREVIEW
// ==========================================
function eliminarFotografiaSeleccionada(index) {

    archivosFotografias.splice(
        index,
        1
    );

    mostrarPreviews();

}


// ==========================================
// GUARDAR
// ==========================================
async function guardarFotografias() {

    const idAtencion =
        Number(
            document.getElementById(
                "idAtencionFotografia"
            ).value
        );


    if (!idAtencion) {

        mostrarMensajeFotografia(
            "Atención no válida",
            "No se pudo identificar la atención.",
            "error"
        );

        return;
    }


    if (!archivosFotografias.length) {

        mostrarMensajeFotografia(
            "Fotografías requeridas",
            "Selecciona al menos una fotografía.",
            "warning"
        );

        return;
    }


    const boton =
        document.getElementById(
            "btnGuardarFotografias"
        );


    boton.disabled = true;
    boton.textContent = "Guardando...";


    try {

        /*
         * Enviamos una fotografía por petición.
         *
         * Esto nos permite conservar una observación
         * diferente para cada imagen usando el backend
         * que acabamos de crear.
         */

        for (
            const item of archivosFotografias
        ) {

            const formData =
                new FormData();


            formData.append(
                "id_atencion",
                idAtencion
            );


            formData.append(
                "observacion",
                item.observacion.trim()
            );


            formData.append(
                "fotografias[]",
                item.archivo
            );


            const response =
                await fetch(
                    "../ajax/atencion.php?op=agregar_fotografias",
                    {
                        method: "POST",
                        body: formData
                    }
                );


            const respuesta =
                await response.json();


            if (!respuesta.status) {

                throw new Error(
                    respuesta.message ||
                    "No se pudo guardar una fotografía."
                );

            }

        }


        cerrarModalAgregarFotografias();

        await cargarFotografias();


        mostrarMensajeFotografia(
            "Fotografías guardadas",
            "Las fotografías clínicas se agregaron correctamente.",
            "success"
        );


    } catch (error) {

        console.error(error);

        mostrarMensajeFotografia(
            "Error",
            error.message ||
            "No se pudieron guardar las fotografías.",
            "error"
        );


    } finally {

        boton.disabled = false;
        boton.textContent =
            "Guardar fotografías";

    }

}


// ==========================================
// MODALES
// ==========================================
function abrirModal(id) {

    const modal =
        document.getElementById(id);

    modal.classList.remove("hidden");
    modal.classList.add("flex");

}


function cerrarModalVerFotografias() {

    const modal =
        document.getElementById(
            "modalVerFotografias"
        );

    modal.classList.add("hidden");
    modal.classList.remove("flex");

}


function cerrarModalAgregarFotografias() {

    const modal =
        document.getElementById(
            "modalAgregarFotografias"
        );

    modal.classList.add("hidden");
    modal.classList.remove("flex");

    archivosFotografias = [];

    document.getElementById(
        "inputFotografias"
    ).value = "";

    document.getElementById(
        "previewFotografias"
    ).innerHTML = "";

}


// ==========================================
// MODAL MENSAJE
// ==========================================
function mostrarMensajeFotografia(
    titulo,
    mensaje,
    tipo = "info"
) {

    const modal =
        document.getElementById(
            "modalMensajeFotografia"
        );

    const header =
        document.getElementById(
            "modalMensajeFotografiaHeader"
        );


    document.getElementById(
        "modalMensajeFotografiaTitulo"
    ).textContent = titulo;


    document.getElementById(
        "modalMensajeFotografiaTexto"
    ).textContent = mensaje;


    header.classList.remove(
        "bg-blue-600",
        "bg-green-600",
        "bg-red-600",
        "bg-orange-500"
    );


    switch (tipo) {

        case "success":

            header.classList.add(
                "bg-green-600"
            );

            break;


        case "error":

            header.classList.add(
                "bg-red-600"
            );

            break;


        case "warning":

            header.classList.add(
                "bg-orange-500"
            );

            break;


        default:

            header.classList.add(
                "bg-blue-600"
            );

    }


    modal.classList.remove("hidden");
    modal.classList.add("flex");

}


function cerrarMensajeFotografia() {

    const modal =
        document.getElementById(
            "modalMensajeFotografia"
        );

    modal.classList.add("hidden");
    modal.classList.remove("flex");

}


// ==========================================
// FECHAS
// ==========================================
function formatearFecha(fecha) {

    if (!fecha) {
        return "Sin fecha";
    }

    const parte =
        String(fecha).split(" ")[0];

    const datos =
        parte.split("-");

    if (datos.length !== 3) {
        return fecha;
    }

    return `${datos[2]}/${datos[1]}/${datos[0]}`;

}


function formatearFechaHora(fecha) {

    if (!fecha) {
        return "";
    }

    const partes =
        String(fecha).split(" ");

    const fechaFormateada =
        formatearFecha(partes[0]);

    if (!partes[1]) {
        return fechaFormateada;
    }

    return `${fechaFormateada} ${partes[1].substring(0, 5)}`;

}


// ==========================================
// ESCAPAR HTML
// ==========================================
function escaparHTML(valor) {

    if (valor === null ||
        valor === undefined) {

        return "";
    }

    const div =
        document.createElement("div");

    div.textContent =
        String(valor);

    return div.innerHTML;

}