/* ==========================================
   REPORTES - BELLDENTE
========================================== */

document.addEventListener("DOMContentLoaded", function () {
cargarResumenReportes();
 cargarEstadosCitas();
  cargarFormasPago();

    const tipoPago = document.getElementById("reportePagoTipo");

    if (tipoPago) {

        tipoPago.addEventListener("change", function () {

            const contenedor =
                document.getElementById("contenedorFormaPago");

            if (this.value === "pendientes") {

                contenedor.classList.add("hidden");

            } else {

                contenedor.classList.remove("hidden");

            }

        });

    }

});
/* ==========================================
   CARGAR RESUMEN
========================================== */

async function cargarResumenReportes() {

    try {

        const response =
            await fetch("../ajax/reportes.php?op=resumen");

        const data = await response.json();

        if (!data.status) {
            console.error(data.message);
            return;
        }

        const datos = data.datos;

        document.getElementById("totalPacientes").textContent =
            Number(datos.total_pacientes || 0);

        document.getElementById("totalAtenciones").textContent =
            Number(datos.total_atenciones || 0);

        document.getElementById("totalCobrado").textContent =
            "$" + Number(datos.total_cobrado || 0).toFixed(2);

        document.getElementById("totalPendiente").textContent =
            "$" + Number(datos.total_pendiente || 0).toFixed(2);

    } catch (error) {

        console.error(
            "Error al cargar resumen de reportes:",
            error
        );

    }
}


/* ==========================================
   CARGAR ESTADOS DE CITAS
========================================== */

async function cargarEstadosCitas() {

    try {

        const response =
            await fetch("../ajax/reportes.php?op=estados_citas");

        const data = await response.json();

        if (!data.status) {
            return;
        }

        const select =
            document.getElementById("reporteCitaEstado");

        select.innerHTML =
            `<option value="0">Todos</option>`;

        data.datos.forEach(estado => {

            select.innerHTML += `
                <option value="${estado.id_estado_cita}">
                    ${estado.nombre_estado}
                </option>
            `;

        });

    } catch (error) {

        console.error(
            "Error al cargar estados de citas:",
            error
        );

    }
}


/* ==========================================
   CARGAR FORMAS DE PAGO
========================================== */

async function cargarFormasPago() {

    try {

        const response =
            await fetch("../ajax/reportes.php?op=formas_pago");

        const data = await response.json();

        if (!data.status) {
            return;
        }

        const select =
            document.getElementById("reporteFormaPago");

        select.innerHTML =
            `<option value="0">Todas</option>`;

        data.datos.forEach(forma => {

            select.innerHTML += `
                <option value="${forma.id_forma_pago}">
                    ${forma.nombre_forma_pago}
                </option>
            `;

        });

    } catch (error) {

        console.error(
            "Error al cargar formas de pago:",
            error
        );

    }
}

/* ==========================================
   ABRIR MODALES
========================================== */

function abrirReportePacientes() {
    abrirModalReporte("modalReportePacientes");
}

function abrirReporteCitas() {
    abrirModalReporte("modalReporteCitas");
}

function abrirReporteAtenciones() {
    abrirModalReporte("modalReporteAtenciones");
}

function abrirReportePagos() {
    abrirModalReporte("modalReportePagos");
}


/* ==========================================
   MODAL GENERAL
========================================== */

function abrirModalReporte(idModal) {

    const modal = document.getElementById(idModal);

    if (!modal) {
        return;
    }

    modal.classList.remove("hidden");
    modal.classList.add("flex");
}


function cerrarModalReporte(idModal) {

    const modal = document.getElementById(idModal);

    if (!modal) {
        return;
    }

    modal.classList.add("hidden");
    modal.classList.remove("flex");
}


/* ==========================================
   GENERAR REPORTES
   Se conectarán después con los PDF
========================================== */

function generarReportePacientes() {

    const estado =
        document.getElementById("reportePacienteEstado").value;

    let estadoEnviar = -1;

    if (estado !== "") {
        estadoEnviar = Number(estado);
    }

    const url =
        `../reportes/pacientes.php?estado=${estadoEnviar}`;

    window.open(url, "_blank");
}


function generarReporteCitas() {

    const desde =
        document.getElementById("reporteCitaDesde").value;

    const hasta =
        document.getElementById("reporteCitaHasta").value;

    const estado =
        document.getElementById("reporteCitaEstado").value;

    console.log("Reporte citas:", {
        desde: desde,
        hasta: hasta,
        estado: estado
    });
}

function generarReporteAtenciones() {

    const desde = document.getElementById("reporteAtencionDesde").value;
    const hasta = document.getElementById("reporteAtencionHasta").value;
    console.log("Reporte atenciones:", {
        desde: desde,
        hasta: hasta
    });
}


function generarReportePagos() {

    const desde = document.getElementById("reportePagoDesde").value;
    const hasta = document.getElementById("reportePagoHasta").value;
    const tipo = document.getElementById("reportePagoTipo").value;
    const formaPago = document.getElementById("reporteFormaPago").value;
    console.log("Reporte pagos:", {
        desde: desde,
        hasta: hasta,
        tipo: tipo,
        forma_pago: formaPago
    });
}