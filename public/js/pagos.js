let pagos = [];
let filtroEstado = "Todos";
document.addEventListener("DOMContentLoaded", function () {
    listarPagos();
//Buscador
const buscarPago = document.getElementById("buscarPago");
    if (buscarPago) {
        buscarPago.addEventListener("input", function () {
            renderizarPagos();
        });
    }

//Filtros
document.querySelectorAll(".filtro-pago").forEach(function (boton) {
    boton.addEventListener("click", function () {
            filtroEstado = this.dataset.filtro;
            actualizarBotonesFiltro(this);
            renderizarPagos();
        });
    });
});

//Listar pagos
async function listarPagos() {
    try {
        const response = await fetch("../ajax/pagos.php?op=listar");
        const data = await response.json();
        if (!data.status) {
            console.error(data.message);
            return;
        }
        pagos = data.data || [];
        actualizarResumen();
        renderizarPagos();
    } catch (error) {
        console.error("ERROR AL LISTAR PAGOS:",error);
    }
}

//Actualizamos el resumen
function actualizarResumen() {
    const totalOrdenes = pagos.length;
    const totalPendientes = pagos.filter(pago => pago.estado_pago === "Pendiente").length;
    const totalPagadas = pagos.filter(pago => pago.estado_pago === "Pagado").length;
    const totalCobrar = pagos.reduce(
        (total, pago) => total + Number(pago.saldo || 0),0);
    document.getElementById("totalOrdenes").textContent = totalOrdenes;
    document.getElementById("totalPendientes").textContent = totalPendientes;
    document.getElementById("totalPagadas").textContent = totalPagadas;
    document.getElementById("totalCobrar").textContent = formatoMoneda(totalCobrar);
}

//Cargamos los pagos
function renderizarPagos() {
    const tbody = document.getElementById("tbllistadoPagos");
    const cards = document.getElementById("cardsPagos");
    const busqueda = document.getElementById("buscarPago").value.trim().toLowerCase();
    tbody.innerHTML = "";
    cards.innerHTML = "";
    const pagosFiltrados = pagos.filter(function (pago) {
        //Filtro de estado de pago
        const cumpleEstado = filtroEstado === "Todos" || pago.estado_pago === filtroEstado;
        //Buscador
        const nombreCompleto = `${pago.nombre || ""} ${pago.apellido || ""}`.toLowerCase();
        const cedula = String(pago.cedula || "").toLowerCase();
        const orden = String(pago.id_orden_pago || "").toLowerCase();
        const cumpleBusqueda = nombreCompleto.includes(busqueda) || cedula.includes(busqueda) || orden.includes(busqueda);
        return cumpleEstado && cumpleBusqueda;
    });

    //Sin resultados
    if (pagosFiltrados.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="px-6 py-10 text-center text-slate-500">
                    No se encontraron órdenes de pago.
                </td>
            </tr>
        `;

        cards.innerHTML = `
            <div
                class="bg-white rounded-2xl shadow-sm p-6 text-center text-slate-500">
                No se encontraron órdenes de pago.
            </div>
        `;
        return;
    }

    //Generamos las filas y las cards
    pagosFiltrados.forEach(function (pago) {
        const estado = obtenerEstado(pago.estado_pago);
        const paciente = `${pago.nombre || ""} ${pago.apellido || ""}`.trim();

        //Tabla del Desktop
        const fila = document.createElement("tr");
        fila.className = "border-b border-slate-100 hover:bg-slate-50";
        fila.innerHTML = `
            <td class="px-6 py-4 font-semibold text-slate-700">
                #${pago.id_orden_pago}
            </td>

            <td class="px-6 py-4">
                <div class="font-medium text-slate-800">
                    ${escaparHTML(paciente)}
                </div>

                <div class="text-sm text-slate-500">
                    ${escaparHTML(pago.cedula || "")}
                </div>
            </td>

            <td class="px-6 py-4 text-center text-slate-600">
                ${formatearFecha(pago.fecha_atencion)}
            </td>

            <td class="px-6 py-4 text-center font-medium">
                ${formatoMoneda(pago.total)}
            </td>

            <td class="px-6 py-4 text-center text-blue-600 font-medium">
                ${formatoMoneda(pago.abonado)}
            </td>

            <td class="px-6 py-4 text-center text-red-600 font-semibold">
                ${formatoMoneda(pago.saldo)}
            </td>

            <td class="px-6 py-4 text-center">

                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                    ${estado.clase}
                ">
                    ${estado.texto}
                </span>
            </td>

            <td class="px-6 py-4 text-center">
                ${generarAcciones(pago)}
            </td>
        `;
        tbody.appendChild(fila);

        //Cards Móvil
        const card = document.createElement("div");
        card.className = "bg-white rounded-2xl shadow-sm p-5";
        card.innerHTML = `
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-500">
                        Orden #${pago.id_orden_pago}
                    </p>

                    <h3 class="font-semibold text-slate-800 mt-1">
                        ${escaparHTML(paciente)}
                    </h3>

                    <p class="text-sm text-slate-500">
                        ${escaparHTML(pago.cedula || "")}
                    </p>
                </div>

                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    ${estado.clase}
                ">
                    ${estado.texto}
                </span>
            </div>


            <div class="grid grid-cols-3 gap-3 mt-5">
                <div>
                    <p class="text-xs text-slate-500">
                        Total
                    </p>

                    <p class="font-semibold text-slate-800">
                        ${formatoMoneda(pago.total)}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Abonado
                    </p>

                    <p class="font-semibold text-blue-600">
                        ${formatoMoneda(pago.abonado)}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Saldo
                    </p>

                    <p class="font-semibold text-red-600">
                        ${formatoMoneda(pago.saldo)}
                    </p>
                </div>
            </div>

            <div class="mt-4 text-sm text-slate-500">
                ${formatearFecha(pago.fecha_atencion)}
            </div>

            <div class="mt-5">
                ${generarAcciones(pago)}
            </div>
        `;
        cards.appendChild(card);
    });
}

//Acciones
function generarAcciones(pago) {
    let botones = `
        <button type="button" onclick="verDetallePago(${pago.id_orden_pago})" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium">
            Ver detalle
        </button>
    `;
    if (Number(pago.saldo) > 0) {
        botones += `
            <button type="button" onclick="abrirPago(${pago.id_orden_pago})" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium ml-2">
                Registrar pago
            </button>
        `;
    }
    return botones;
}

//Estados
function obtenerEstado(estado) {
    switch (estado) {
        case "Pendiente":
            return {
                texto: "Pendiente",
                clase: "bg-yellow-100 text-yellow-700"
            };
        case "Abonado":
            return {
                texto: "Abonado",
                clase: "bg-orange-100 text-orange-700"
            };
        case "Pagado":
            return {
                texto: "Pagado",
                clase: "bg-green-100 text-green-700"
            };
        default:
            return {
                texto: estado || "Sin estado",
                clase: "bg-slate-100 text-slate-700"
            };
    }
}

//Filtros visuales
function actualizarBotonesFiltro(botonActivo) {
    document.querySelectorAll(".filtro-pago").forEach(function (boton) {
        boton.classList.remove("ring-2","ring-offset-2","ring-slate-400");
});

    botonActivo.classList.add("ring-2","ring-offset-2","ring-slate-400");
}

//Formatear moneda de pago
function formatoMoneda(valor) {
    const numero = Number(valor || 0);
    return new Intl.NumberFormat("en-US",{
            style: "currency",
            currency: "USD"
        }
    ).format(numero);
}

//Formateamos la fecha
function formatearFecha(fecha) {
    if (!fecha) {
        return "-";
    }
    const soloFecha = String(fecha).split(" ")[0];
    const partes = soloFecha.split("-");
    if (partes.length !== 3) {
        return fecha;
    }
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

//Escapamos HTML
function escaparHTML(texto) {
    const div =document.createElement("div");
    div.textContent = texto == null ? "" : String(texto);
    return div.innerHTML;
}

//Ver el detalle del pago
async function verDetallePago(idOrdenPago) {
    try {
        const formData = new FormData();
        formData.append("id_orden_pago",idOrdenPago);

        /* ==========================================
           CONSULTAMOS LOS 3 DATOS
        ========================================== */
        const [
            responseOrden,
            responseDetalle,
            responseAbonos
        ] = await Promise.all([
            fetch("../ajax/pagos.php?op=obtener",{
                    method: "POST",
                    body: formData
                }
            ),
            fetch("../ajax/pagos.php?op=detalle",{
                    method: "POST",
                    body: crearFormDataOrden(idOrdenPago)
                }
            ),
            fetch("../ajax/pagos.php?op=listar_abonos",{
                    method: "POST",
                    body: crearFormDataOrden(idOrdenPago)
                }
            )
        ]);

        const ordenData = await responseOrden.json();
        const detalleData = await responseDetalle.json();
        const abonosData = await responseAbonos.json();
        if (!ordenData.status) {
            alert(ordenData.message || "No se pudo obtener la orden.");
            return;
        }

        //Datos generales
        const orden = ordenData.datos;
        document.getElementById("detalleNumeroOrden").textContent = `Orden #${orden.id_orden_pago}`;
        document.getElementById("detallePaciente").textContent = `${orden.nombre_paciente || ""} ${orden.apellido_paciente || ""}`.trim();
        document.getElementById("detalleCedula").textContent = orden.cedula_paciente || "-";
        document.getElementById("detalleFecha").textContent = formatearFecha(orden.fecha_fin || orden.fecha_inicio);
        document.getElementById("detalleTotal").textContent = formatoMoneda(orden.total);
        document.getElementById("detalleAbonado").textContent = formatoMoneda(orden.abonado);
        document.getElementById("detalleSaldo").textContent = formatoMoneda(orden.saldo);

        //Estado
        const estado = obtenerEstado(orden.estado_pago);
        const badgeEstado = document.getElementById("detalleEstado");
        badgeEstado.textContent = estado.texto;
        badgeEstado.className = `inline-flex px-3 py-1 rounded-full text-xs font-semibold ${estado.clase}`;

        //Tratamientos
        renderizarDetalleTratamientos(detalleData.data || []);

        //Abonos
        renderizarDetalleAbonos(abonosData.data || []);

        //Abrir modal de Ver Detalle
        const modal = document.getElementById("modalDetallePago");
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    } catch (error) {
        console.error("ERROR AL OBTENER DETALLE:",error);
        alert("Ocurrió un error al consultar la orden.");
    }
}
//Formato de la Data
function crearFormDataOrden(idOrdenPago) {
    const formData = new FormData();
    formData.append("id_orden_pago",idOrdenPago);
    return formData;
}

//Cargamos tratamientos
function renderizarDetalleTratamientos(tratamientos) {
    const tbody = document.getElementById("detalleTratamientos");
    tbody.innerHTML = "";
    if (tratamientos.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-6 text-center text-slate-500">
                    No existen tratamientos registrados.
                </td>
            </tr>
        `;
        return;
    }

    tratamientos.forEach(function (item) {
        const fila = document.createElement("tr");
        fila.className = "border-t border-slate-100";
        fila.innerHTML = `
            <td class="px-4 py-3 text-slate-700">
                ${escaparHTML(item.procedimiento)}
            </td>

            <td class="px-4 py-3 text-center">
                ${item.cantidad}
            </td>

            <td class="px-4 py-3 text-right">
                ${formatoMoneda(item.precio_unitario)}
            </td>

            <td class="px-4 py-3 text-right font-semibold">
                ${formatoMoneda(item.subtotal)}
            </td>
        `;
        tbody.appendChild(fila);
    });
}

//Cargamos el historial de Abonos
function renderizarDetalleAbonos(abonos) {
    const tbody = document.getElementById("detalleAbonos");
    tbody.innerHTML = "";
    if (abonos.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-6 text-center text-slate-500">
                    Todavía no existen pagos registrados.
                </td>
            </tr>
        `;
        return;
    }

    abonos.forEach(function (abono) {
        const fila = document.createElement("tr");
        fila.className = "border-t border-slate-100";
        fila.innerHTML = `
            <td class="px-4 py-3 text-slate-600">
                ${formatearFechaHora(abono.fecha_abono)}
            </td>

            <td class="px-4 py-3 text-slate-700">
                ${escaparHTML(abono.forma_pago)}
            </td>

            <td class="px-4 py-3 text-slate-600">
                ${escaparHTML(abono.observacion || "-")}
            </td>

            <td class="px-4 py-3 text-right
                       font-semibold text-green-600">
                ${formatoMoneda(abono.valor_abono)}
            </td>
        `;
        tbody.appendChild(fila);
    });
}

//Fecha y hora
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
    return `${fechaFormateada} ${hora}`;
}

//Cerrar modal
function cerrarDetallePago() {
    const modal = document.getElementById("modalDetallePago");
    modal.classList.add("hidden");
    modal.classList.remove("flex");
}

function abrirPago(idOrdenPago) {
    console.log("Registrar pago orden:",idOrdenPago);
}