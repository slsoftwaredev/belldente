document.addEventListener("DOMContentLoaded", () => {

    listarCIE10();

    const formulario = document.getElementById("formCIE");
    const formCIE10 = document.getElementById("formCIE10");
    const btnNuevo = document.getElementById("btnNuevo");
    const btnCancelar = document.getElementById("btnCancelar");

    // Mostrar formulario
    btnNuevo.addEventListener("click", () => {

        formCIE10.reset();

        document.getElementById("id_cie10").value = 0;

        formulario.classList.remove("hidden");

        formulario.scrollIntoView({

            behavior: "smooth",
            block: "start"

        });

    });

    // Cancelar
    btnCancelar.addEventListener("click", () => {

        formCIE10.reset();

        formulario.classList.add("hidden");

    });

    // Guardar / Editar

    formCIE10.addEventListener("submit", function (e) {

        e.preventDefault();

        const formData = new FormData(formCIE10);

        const accion = document.getElementById("id_cie10").value == 0
            ? "guardar"
            : "editar";

        fetch("../ajax/cie10.php?op=" + accion, {

            method: "POST",

            body: formData

        })

        .then(response => response.json())

        .then(data => {

    if (data.status) {

        formCIE10.reset();

        document.getElementById("id_cie10").value = 0;

        // En móvil ocultamos el formulario
        if (window.innerWidth < 1024) {
            formulario.classList.add("hidden");
        }

        listarCIE10();

        mostrarModalSistema({

            titulo:
                accion === "guardar"
                    ? "Diagnóstico registrado"
                    : "Diagnóstico actualizado",

            mensaje:
                accion === "guardar"
                    ? "El diagnóstico CIE-10 fue registrado correctamente."
                    : "El diagnóstico CIE-10 fue actualizado correctamente.",

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
                        ? "Ocurrió un error al registrar el diagnóstico."
                        : "Ocurrió un error al actualizar el diagnóstico."
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

function listarCIE10() {

    fetch("../ajax/cie10.php?op=listar")

    .then(response => response.json())

    .then(data => {

        let html = "";

        let cards = "";

        data.forEach(cie10 => {

            cards += `

                <div class="bg-white rounded-2xl shadow-sm p-4">

                    <h3 class="font-bold text-slate-800">

                        ${cie10[0]}

                    </h3>

                    <p class="text-sm text-slate-500 mt-2">

                        ${cie10[1]}

                    </p>

                    <div class="mt-2">

                        ${cie10[2]}

                    </div>

                    <div class="mt-4">

                        ${cie10[3]}

                    </div>

                </div>

            `;

            html += `

                <tr class="border-b">

                    <td class="px-6 py-4">

                        ${cie10[0]}

                    </td>

                    <td class="px-6 py-4">

                        ${cie10[1]}

                    </td>

                    <td class="px-6 py-4 text-center">

                        ${cie10[2]}

                    </td>

                    <td class="px-6 py-4 text-center">

                        ${cie10[3]}

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

        document.getElementById("tbllistadoCie10").innerHTML = html;

        document.getElementById("cardsCie10").innerHTML = cards;

    })

    .catch(error => {

        console.error(error);

    });

}

/*=========================================
EDITAR
=========================================*/

function editarCIE10(id_cie10){

    const formulario = document.getElementById("formCIE");

    formulario.classList.remove("hidden");

    fetch("../ajax/cie10.php?op=obtener",{

        method:"POST",

        headers:{

            "Content-Type":"application/x-www-form-urlencoded"

        },

        body:"id_cie10="+id_cie10

    })

    .then(response => response.json())

    .then(data => {

        document.getElementById("id_cie10").value =
            data[0];

        document.querySelector("[name='codigo']").value =
            data[1];

        document.querySelector("[name='descripcion']").value =
            data[2];

        formulario.scrollIntoView({

            behavior:"smooth"

        });

    });

}

/*=========================================
CAMBIAR ESTADO
=========================================*/
function cambiarEstado(id_cie10, estado) {

    const activar = estado == 1;

    mostrarModalSistema({

        titulo:
            activar
                ? "Activar diagnóstico"
                : "Inactivar diagnóstico",

        mensaje:
            activar
                ? "¿Está seguro de activar este diagnóstico CIE-10?"
                : "¿Está seguro de inactivar este diagnóstico CIE-10?",

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
                "id_cie10",
                id_cie10
            );

            formData.append(
                "estado",
                estado
            );

            fetch("../ajax/cie10.php?op=estado", {

                method: "POST",
                body: formData

            })
            .then(response => response.json())
            .then(data => {

                if (data.status) {

                    listarCIE10();

                    mostrarModalSistema({

                        titulo:
                            activar
                                ? "Diagnóstico activado"
                                : "Diagnóstico inactivado",

                        mensaje:
                            activar
                                ? "El diagnóstico CIE-10 fue activado correctamente."
                                : "El diagnóstico CIE-10 fue inactivado correctamente.",

                        tipo: "success"

                    });

                } else {

                    mostrarModalSistema({

                        titulo: "No se pudo actualizar",

                        mensaje:
                            data.mensaje ||
                            "No se pudo actualizar el estado del diagnóstico.",

                        tipo: "error"

                    });

                }

            })
            .catch(error => {

                console.error(error);

                mostrarModalSistema({

                    titulo: "Error",

                    mensaje:
                        "Ocurrió un error de comunicación al actualizar el diagnóstico.",

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
.getElementById("buscarCIE10")
.addEventListener("keyup", buscarCIE10);

function buscarCIE10(){

    let filtro =
    this.value.toLowerCase();

    document
    .querySelectorAll("#tbllistadoCie10 tr")
    .forEach(fila => {

        let texto =
        fila.textContent.toLowerCase();

        fila.style.display =

        texto.includes(filtro)

        ? ""

        : "none";

    });

    document
    .querySelectorAll("#cardsCie10 > div")
    .forEach(card => {

        let texto =
        card.textContent.toLowerCase();

        card.style.display =

        texto.includes(filtro)

        ? ""

        : "none";

    });

}