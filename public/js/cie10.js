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

                alert(

                    accion == "guardar"

                    ? "Diagnóstico registrado correctamente."

                    : "Diagnóstico actualizado correctamente."

                );

                formCIE10.reset();

                formulario.classList.add("hidden");

                listarCIE10();

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

function cambiarEstado(id_cie10, estado){

    const mensaje =

        estado == 1

        ? "¿Desea activar este diagnóstico?"

        : "¿Desea inactivar este diagnóstico?";

    if(!confirm(mensaje)){

        return;

    }

    const formData = new FormData();

    formData.append("id_cie10",id_cie10);

    formData.append("estado",estado);

    fetch("../ajax/cie10.php?op=estado",{

        method:"POST",

        body:formData

    })

    .then(response => response.json())

    .then(data => {

        if(data.status){

            listarCIE10();

        }else{

            alert("No se pudo actualizar el estado.");

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