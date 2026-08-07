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

                alert(

                    accion == "guardar"

                    ? "Tratamiento registrado correctamente."

                    : "Tratamiento actualizado correctamente."

                );

                formTratamiento.reset();

                document.getElementById("id_procedimiento").value = 0;

                if (window.innerWidth < 1024) {

                    formulario.classList.add("hidden");

                }

                listarTratamientos();

            } else {

                alert(

                    accion == "guardar"

                    ? "Error al registrar."

                    : "Error al actualizar."

                );

            }

        })

        .catch(error => {

            console.error(error);

        });

    });

});

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

function cambiarEstado(id_procedimiento, estado){

    const mensaje =

        estado == 1

        ? "¿Desea activar este tratamiento?"

        : "¿Desea inactivar este tratamiento?";

    if(!confirm(mensaje)){

        return;

    }

    const formData = new FormData();

    formData.append(
        "id_procedimiento",
        id_procedimiento
    );

    formData.append(
        "estado",
        estado
    );

    fetch("../ajax/tratamiento.php?op=estado",{

        method:"POST",

        body:formData

    })

    .then(response => response.json())

    .then(data => {

        if(data.status){

            listarTratamientos();

        }else{

            alert("No se pudo actualizar el estado");

        }

    })

    .catch(error => {

        console.error(error);

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