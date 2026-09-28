document.addEventListener("DOMContentLoaded", () => {

    listarTratamientos();

    const formulario = document.getElementById("formTratamiento");
    const formTratamiento = document.getElementById("formTratamientoFormulario");
    const btnNuevo = document.getElementById("btnNuevo");
    const btnCancelar = document.getElementById("btnCancelar");

    // Mostrar formulario
    btnNuevo.addEventListener("click", () => {

        formTratamiento.reset();

        document.getElementById("id_procedimiento").value = 0;

        formulario.classList.remove("hidden");

        formulario.scrollIntoView({

            behavior: "smooth",
            block: "start"

        });

    });

    // Cancelar
    btnCancelar.addEventListener("click", () => {

        formTratamiento.reset();

        document.getElementById("id_procedimiento").value = 0;

        formulario.classList.add("hidden");

    });

    // Guardar / Editar
    formTratamiento.addEventListener("submit", function (e) {

        e.preventDefault();

        const formData = new FormData(formTratamiento);

        const accion = document.getElementById("id_procedimiento").value == 0
            ? "guardar"
            : "editar";

        fetch("../ajax/tratamiento.php?op=" + accion, {

            method: "POST",

            body: formData

        })

        .then(response => response.json())

        .then(data => {

    if (data.status) {

        formTratamiento.reset();

        document.getElementById("id_procedimiento").value = 0;

        if (window.innerWidth < 1024) {
            formulario.classList.add("hidden");
        }

        listarTratamientos();

        mostrarModalSistema({

            titulo:
                accion === "guardar"
                    ? "Tratamiento registrado"
                    : "Tratamiento actualizado",

            mensaje:
                accion === "guardar"
                    ? "El tratamiento fue registrado correctamente."
                    : "El tratamiento fue actualizado correctamente.",

            tipo: "success"

        });

    } else {

        mostrarModalSistema({

            titulo:
                accion === "guardar"
                    ? "No se pudo registrar"
                    : "No se pudo actualizar",

            mensaje:
                data.mensaje ||
                (
                    accion === "guardar"
                        ? "Ocurrió un error al registrar el tratamiento."
                        : "Ocurrió un error al actualizar el tratamiento."
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

// ========================================
// MODAL GENERAL DEL SISTEMA
// ========================================

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

/*=========================================
LISTAR
=========================================*/

function listarTratamientos() {

    fetch("../ajax/tratamiento.php?op=listar")

    .then(response => response.json())

    .then(data => {

        let html = "";

        let cards = "";

        data.forEach(tratamiento => {

            cards += `

                <div class="bg-white rounded-2xl shadow-sm p-4">

                    <h3 class="font-bold text-slate-800">

                        ${tratamiento[0]}

                    </h3>

                    <p class="text-sm text-slate-500 mt-2">

                        Valor:
                        ${tratamiento[1]}

                    </p>

                    <div class="mt-2">

                        ${tratamiento[2]}

                    </div>

                    <div class="mt-4">

                        ${tratamiento[3]}

                    </div>

                </div>

            `;

            html += `

                <tr class="border-b">

                    <td class="px-6 py-4">

                        ${tratamiento[0]}

                    </td>

                    <td class="px-6 py-4 text-center">

                        ${tratamiento[1]}

                    </td>

                    <td class="px-6 py-4 text-center">

                        ${tratamiento[2]}

                    </td>

                    <td class="px-6 py-4 text-center">

                        ${tratamiento[3]}

                    </td>

                </tr>

            `;

        });

        if (data.length === 0) {

            html = `

                <tr>

                    <td
                        colspan="4"
                        class="px-6 py-8 text-center text-slate-500">

                        Sin registros

                    </td>

                </tr>

            `;

            cards = `

                <div class="bg-white rounded-2xl shadow-sm p-4 text-center text-slate-500">

                    Sin registros

                </div>

            `;

        }

        document.getElementById("tbllistado").innerHTML = html;

        document.getElementById("cardsTratamientos").innerHTML = cards;

    })

    .catch(error => {

        console.error(error);

    });

}
/*=========================================
EDITAR
=========================================*/

function editarTratamiento(id_procedimiento){

    const formulario = document.getElementById("formTratamiento");

    formulario.classList.remove("hidden");

    fetch("../ajax/tratamiento.php?op=obtener",{

        method:"POST",

        headers:{

            "Content-Type":"application/x-www-form-urlencoded"

        },

        body:"id_procedimiento="+id_procedimiento

    })

    .then(response => response.json())

    .then(data => {

        document.getElementById("id_procedimiento").value =
            data[0];

        document.querySelector("[name='nombre']").value =
            data[1];

        document.querySelector("[name='valor']").value =
            data[2];

        formulario.scrollIntoView({

            behavior:"smooth"

        });

    })

    .catch(error => {

        console.error(error);

    });

}

/*=========================================
CAMBIAR ESTADO
=========================================*/
function cambiarEstado(id_procedimiento, estado) {

    const activar = estado == 1;

    mostrarModalSistema({

        titulo:
            activar
                ? "Activar tratamiento"
                : "Inactivar tratamiento",

        mensaje:
            activar
                ? "¿Está seguro de activar este tratamiento?"
                : "¿Está seguro de inactivar este tratamiento?",

        tipo:
            activar
                ? "info"
                : "error",

        confirmar: true,

        textoAceptar:
            activar
                ? "Sí, activar"
                : "Sí, inactivar",

        textoCancelar: "Volver",

        onAceptar: () => {

            const formData = new FormData();

            formData.append(
                "id_procedimiento",
                id_procedimiento
            );

            formData.append(
                "estado",
                estado
            );

            fetch("../ajax/tratamiento.php?op=estado", {

                method: "POST",
                body: formData

            })
            .then(response => response.json())
            .then(data => {

                if (data.status) {

                    listarTratamientos();

                    mostrarModalSistema({

                        titulo:
                            activar
                                ? "Tratamiento activado"
                                : "Tratamiento inactivado",

                        mensaje:
                            activar
                                ? "El tratamiento fue activado correctamente."
                                : "El tratamiento fue inactivado correctamente.",

                        tipo: "success"

                    });

                } else {

                    mostrarModalSistema({

                        titulo: "No se pudo actualizar",

                        mensaje:
                            data.mensaje ||
                            "No se pudo actualizar el estado del tratamiento.",

                        tipo: "error"

                    });

                }

            })
            .catch(error => {

                console.error(error);

                mostrarModalSistema({

                    titulo: "Error",

                    mensaje:
                        "Ocurrió un error de comunicación al actualizar el tratamiento.",

                    tipo: "error"

                });

            });

        }

    });

}

/*=========================================
BUSCAR
=========================================*/

document
.getElementById("buscar")
.addEventListener("keyup", buscarTratamientos);

function buscarTratamientos(){

    let filtro =
    this.value.toLowerCase();

    // Tabla Desktop

    document
    .querySelectorAll("#tbllistado tr")
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
    .querySelectorAll("#cardsTratamientos > div")
    .forEach(card => {

        let texto =
        card.textContent.toLowerCase();

        card.style.display =
        texto.includes(filtro)
        ? ""
        : "none";

    });

}