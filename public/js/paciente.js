document.addEventListener("DOMContentLoaded", () => {
    listarPacientes();

    // Modal
    const modal = document.getElementById("modalPaciente");
    const btnNuevoPaciente = document.getElementById("btnNuevoPaciente");
    const btnCerrarModal = document.getElementById("btnCerrarModal");
    const btnCancelar = document.getElementById("btnCancelar");

    btnNuevoPaciente.addEventListener("click", () => {
        formPaciente.reset();
        document.getElementById("id_paciente").value = 0;
        document.getElementById("tituloModal").innerText = "Nuevo Paciente";

        modal.classList.remove("hidden");
        modal.classList.add("flex");

    });

    btnCerrarModal.addEventListener("click", () => {

        modal.classList.add("hidden");
        modal.classList.remove("flex");

    });
    btnCancelar.addEventListener("click", () => {

        formPaciente.reset();
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        });

    // Formulario
    const formPaciente = document.getElementById("formPaciente");

    formPaciente.addEventListener("submit", function (e) {

        e.preventDefault();

        const formData = new FormData(formPaciente);
        const accion = document.getElementById("id_paciente").value ==0 ? "guardar" : "editar";
        fetch("../ajax/paciente.php?op=" + accion, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {

    if (data.status) {

        formPaciente.reset();

        modal.classList.add("hidden");
        modal.classList.remove("flex");

        listarPacientes();

        mostrarModalSistema({

            titulo:
                accion === "guardar"
                    ? "Paciente registrado"
                    : "Paciente actualizado",

            mensaje:
                accion === "guardar"
                    ? "El paciente fue registrado correctamente."
                    : "La información del paciente fue actualizada correctamente.",

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
                        ? "Ocurrió un error al registrar el paciente."
                        : "Ocurrió un error al actualizar el paciente."
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

// Función para listar los pacientes
function listarPacientes() {

    fetch("../ajax/paciente.php?op=listar")
        .then(response => response.json())
        .then(data => {

            let html = "";
            let cards = "";

            data.forEach(paciente => {
                //Llenado de cards en movil
                cards += `
                <div class="bg-white rounded-2xl shadow-sm p-4">

                    <h3 class="font-bold text-slate-800">
                        ${paciente[1]}
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Cédula: ${paciente[2]}
                    </p>

                    <p class="text-sm text-slate-500">
                        Teléfono: ${paciente[3]}
                    </p>

                    <div class="mt-2">
                        ${paciente[4]}
                    </div>

                    <div class="mt-4">
                        ${paciente[5]}
                    </div>

                </div>
                `;
                //Llenado de tabla en escritorio
                html += `
                    <tr class="border-b">

                        <td class="px-4 py-3">
                            ${paciente[0]}
                        </td>

                        <td class="px-4 py-3">
                            ${paciente[1]}
                        </td>

                        <td class="px-4 py-3">
                            ${paciente[2]}
                        </td>

                        <td class="px-4 py-3">
                            ${paciente[3]}
                        </td>

                        <td class="px-4 py-3">
                            ${paciente[4]}
                        </td>

                        <td class="px-4 py-3 text-center">
                            ${paciente[5]}
                        </td>

                    </tr>
                `;

            });
            //Validar que no haya registros para mostrar en tabla
            if(data.length === 0){

        html = `
            <tr>
                <td
                    colspan="6"
                    class="px-4 py-6 text-center text-slate-500">

                    Sin registros

                </td>
            </tr>
        `;

    }
    // Validar que no haya registros para mostrar en cards
    if(data.length === 0){

    cards = `
        <div class="bg-white rounded-2xl shadow-sm p-4 text-center text-slate-500">

            Sin registros

        </div>
    `;

}
            document.getElementById("tblPacientes").innerHTML = html;
            document.getElementById("cardPacientes").innerHTML = cards;

        })
        .catch(error => {

            console.error(error);

        });

}
//Funcion para cargar los datos del usuario para editar
function editarPaciente(id_paciente){
    const modal = document.getElementById("modalPaciente");
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    fetch("../ajax/paciente.php?op=obtener",{
        method:"POST",
        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:"id_paciente="+id_paciente
    })
    .then(response => response.json())
    .then(data => {

        document.getElementById("id_paciente").value =
            data[0];

            document.querySelector("[name='nombre']").value =
            data[1];

            document.querySelector("[name='apellido']").value =
            data[2];

            document.querySelector("[name='cedula']").value =
            data[3];

            document.querySelector("[name='fecha_nacimiento']").value =
            data[4];

            document.querySelector("[name='sexo']").value =
            data[5];

            document.querySelector("[name='telefono']").value =
            data[6];

            document.querySelector("[name='correo']").value =
            data[7];

            document.querySelector("[name='domicilio']").value =
            data[8];

        document.getElementById("tituloModal").innerText =
        "Editar Paciente";

    });

}
//Función para cambiar el estado del paciente
function cambiarEstado(id_paciente, estado) {

    const activar = estado == 1;

    mostrarModalSistema({

        titulo:
            activar
                ? "Activar paciente"
                : "Inactivar paciente",

        mensaje:
            activar
                ? "¿Está seguro de activar este paciente?"
                : "¿Está seguro de inactivar este paciente?",

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
                "id_paciente",
                id_paciente
            );

            formData.append(
                "estado",
                estado
            );

            fetch("../ajax/paciente.php?op=estado", {

                method: "POST",
                body: formData

            })
            .then(response => response.json())
            .then(data => {

                if (data.status) {

                    listarPacientes();

                    mostrarModalSistema({

                        titulo:
                            activar
                                ? "Paciente activado"
                                : "Paciente inactivado",

                        mensaje:
                            activar
                                ? "El paciente fue activado correctamente."
                                : "El paciente fue inactivado correctamente.",

                        tipo: "success"

                    });

                } else {

                    mostrarModalSistema({

                        titulo: "No se pudo actualizar",

                        mensaje:
                            data.mensaje ||
                            "No se pudo actualizar el estado del paciente.",

                        tipo: "error"

                    });

                }

            })
            .catch(error => {

                console.error(error);

                mostrarModalSistema({

                    titulo: "Error",

                    mensaje:
                        "Ocurrió un error de comunicación al actualizar el paciente.",

                    tipo: "error"

                });

            });

        }

    });

}
// Función para buscar usuarios en la tabla y cards
document
.getElementById("txtBuscar")
.addEventListener("keyup", buscarPacientes);
// Función para buscar pacientes en la tabla y cards
function buscarPacientes(){

    let filtro =
    this.value.toLowerCase();

    // Tabla Desktop

    document
    .querySelectorAll("#tblPacientes tr")
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
    .querySelectorAll("#cardPacientes > div")
    .forEach(card => {

        let texto =
        card.textContent.toLowerCase();

        card.style.display =
        texto.includes(filtro)
        ? ""
        : "none";

    });

}
