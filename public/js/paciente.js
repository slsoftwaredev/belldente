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

                alert(accion == "guardar" ? "Paciente registrado correctamente" : "Paciente actualizado correctamente");

                formPaciente.reset();

                modal.classList.add("hidden");
                modal.classList.remove("flex");

                listarPacientes();

            } else {

                alert(accion == "guardar" ? "Error al registrar paciente" : "Error al actualizar paciente");

            }

        })
        .catch(error => {

            console.error(error);

        });

    });

});
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
function cambiarEstado(id_paciente, estado){

    const mensaje =
        estado == 1
        ? "¿Desea activar este paciente?"
        : "¿Desea inactivar este paciente?";

    if(!confirm(mensaje)){
        return;
    }

    const formData = new FormData();

    formData.append(
        "id_paciente",
        id_paciente
    );

    formData.append(
        "estado",
        estado
    );

    fetch("../ajax/paciente.php?op=estado",{
        method:"POST",
        body:formData
    })
    .then(response => response.json())
    .then(data => {

        if(data.status){

            listarPacientes();

        }else{

            alert("No se pudo actualizar el estado");

        }

    })
    .catch(error => {

        console.error(error);

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
