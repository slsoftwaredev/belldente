document.addEventListener("DOMContentLoaded", () => {
    cargarCitasHoy();
    cargarPendientesHoy();
    const btnValidarCedula = document.getElementById("btnValidarCedula");
    const inputCedula = document.getElementById("cedula");
    btnValidarCedula.addEventListener("click", validarCedula);
    inputCedula.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            validarCedula();
        }
    });

});
function validarCedula() {
    const cedula = document.getElementById("cedula").value.trim();
    if (cedula === "") {
        alert("Ingrese una cédula");
        return;
    }
    fetch("../ajax/paciente.php?op=buscar_cedula", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "cedula=" + encodeURIComponent(cedula)
    })
    .then(response => response.json())
    .then(data => {
        if (data.existe) {
            // Paciente registrado
            window.location.href = "../views/citas.php";
        } else {
            // Paciente no registrado
            window.location.href = "../views/paciente.php";
        }
    })
    .catch(error => {
        console.error(error);
        alert("Error al consultar la cédula");
    });

}
function cargarCitasHoy() {

    fetch("../ajax/cita.php?op=citas_hoy")

        .then(response => response.json())

        .then(data => {

            // =========================
            // CARD CITAS HOY
            // =========================

            document.getElementById("totalCitasHoy").textContent =
                data.total;


            let tabla = "";
            let cards = "";


            // =========================
            // SIN CITAS
            // =========================

            if (data.citas.length === 0) {

                tabla = `
                    <tr>
                        <td
                            colspan="4"
                            class="py-8 text-center text-slate-500">

                            No hay citas programadas para hoy

                        </td>
                    </tr>
                `;

                cards = `
                    <div class="text-center text-slate-500 py-6">
                        No hay citas programadas para hoy
                    </div>
                `;

            }


            // =========================
            // CITAS
            // =========================

            data.citas.forEach(cita => {

                let estadoClase = obtenerClaseEstado(
                    cita.estado_id
                );


                // TABLA DESKTOP

                tabla += `
                    <tr class="border-b">

                        <td class="py-3">
                            ${cita.paciente}
                        </td>

                        <td class="py-3">
                            ${formatearFecha(cita.fecha)}
                        </td>

                        <td class="py-3">

                            <span class="${estadoClase}
                                         px-3 py-1
                                         rounded-full text-xs">

                                ${cita.estado}

                            </span>

                        </td>

                        <td class="py-3 text-center">

                            <button
                                onclick="atenderCitaDashboard(${cita.id_cita})"
                                class="text-blue-600 hover:text-blue-800">

                                Ver

                            </button>

                        </td>

                    </tr>
                `;


                // CARDS MOBILE

                cards += `
                    <div class="border border-slate-200
                                rounded-xl p-4">

                        <div class="flex justify-between gap-3">

                            <div>

                                <p class="font-semibold text-slate-800">
                                    ${cita.paciente}
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    ${formatearFecha(cita.fecha)}
                                </p>

                            </div>

                            <span class="${estadoClase}
                                         px-3 py-1
                                         rounded-full text-xs
                                         h-fit">

                                ${cita.estado}

                            </span>

                        </div>


                        <div class="mt-4">

                            <button
                                onclick="atenderCitaDashboard(${cita.id_cita})"
                                class="text-blue-600 text-sm font-medium">

                                Ver cita

                            </button>

                        </div>

                    </div>
                `;

            });


            document.getElementById("tblCitasHoy").innerHTML =
                tabla;

            document.getElementById("cardCitasHoy").innerHTML =
                cards;

        })

        .catch(error => {

            console.error(
                "Error al cargar las citas de hoy:",
                error
            );

        });

}
function obtenerClaseEstado(estado) {

    switch (parseInt(estado)) {

        case 1:
            return "bg-green-100 text-green-700";

        case 2:
            return "bg-amber-100 text-amber-700";

        case 3:
            return "bg-blue-100 text-blue-700";

        case 4:
            return "bg-purple-100 text-purple-700";

        case 5:
            return "bg-red-100 text-red-700";

        case 6:
            return "bg-slate-100 text-slate-700";

        default:
            return "bg-slate-100 text-slate-600";
    }

}
function formatearFecha(fecha) {

    const partes = fecha.split("-");

    return `${partes[2]}/${partes[1]}/${partes[0]}`;

}
function atenderCitaDashboard(id_cita) {
    window.location.href =
        "../views/atencion.php?id_cita=" + id_cita;
}
function cargarPendientesHoy() {
    fetch("../ajax/cita.php?op=pendientes_hoy")
        .then(response => response.json())
        .then(data => {
            document.getElementById("totalPendientesHoy").textContent =
                data.total;
        })
        .catch(error => {
            console.error(
                "Error al cargar citas pendientes:",
                error
            );
        });
}