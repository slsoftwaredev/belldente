document.addEventListener("DOMContentLoaded", () => {
    listarUsuarios();
    cargarRoles();

    // Modal
    const modal = document.getElementById("modalUsuario");
    const btnNuevoUsuario = document.getElementById("btnNuevoUsuario");
    const btnCerrarModal = document.getElementById("btnCerrarModal");
    const btnCancelar = document.getElementById("btnCancelar");

    btnNuevoUsuario.addEventListener("click", () => {

        modal.classList.remove("hidden");
        modal.classList.add("flex");

    });

    btnCerrarModal.addEventListener("click", () => {

        modal.classList.add("hidden");
        modal.classList.remove("flex");

    });
    btnCancelar.addEventListener("click", () => {

        formUsuario.reset();
        modal.classList.add("hidden");
        });

    // Formulario
    const formUsuario = document.getElementById("formUsuario");

    formUsuario.addEventListener("submit", function (e) {

        e.preventDefault();

        const formData = new FormData(formUsuario);

        fetch("../ajax/usuario.php?op=guardar", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            if (data.status) {

                alert("Usuario registrado correctamente");

                formUsuario.reset();

                modal.classList.add("hidden");
                modal.classList.remove("flex");

                listarUsuarios();

            } else {

                alert("Error al registrar usuario");

            }

        })
        .catch(error => {

            console.error(error);

        });

    });

});
// Función para listar los usuarios
function listarUsuarios() {

    fetch("../ajax/usuario.php?op=listar")
        .then(response => response.json())
        .then(data => {

            let html = "";
            let cards = "";

            data.forEach(usuario => {
                //Llenado de cards en movil
                cards += `
                <div class="bg-white rounded-2xl shadow-sm p-4">

                    <h3 class="font-bold text-slate-800">
                        ${usuario[1]}
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Usuario: ${usuario[2]}
                    </p>

                    <p class="text-sm text-slate-500">
                        Rol: ${usuario[3]}
                    </p>

                    <div class="mt-2">
                        ${usuario[4]}
                    </div>

                    <div class="mt-4">
                        ${usuario[5]}
                    </div>

                </div>
                `;
                //Llenado de tabla en escritorio
                html += `
                    <tr class="border-b">

                        <td class="px-4 py-3">
                            ${usuario[0]}
                        </td>

                        <td class="px-4 py-3">
                            ${usuario[1]}
                        </td>

                        <td class="px-4 py-3">
                            ${usuario[2]}
                        </td>

                        <td class="px-4 py-3">
                            ${usuario[3]}
                        </td>

                        <td class="px-4 py-3">
                            ${usuario[4]}
                        </td>

                        <td class="px-4 py-3 text-center">
                            ${usuario[5]}
                        </td>

                    </tr>
                `;

            });

            document.getElementById("tblUsuarios").innerHTML = html;
            document.getElementById("cardUsuarios").innerHTML = cards;

        })
        .catch(error => {

            console.error(error);

        });

}
// Función para cargar los roles en el select del formulario
function cargarRoles(){

    fetch("../ajax/usuario.php?op=roles")
    .then(response => response.json())
    .then(data => {

        let html = `
            <option value="">
                Seleccione un rol
            </option>
        `;

        data.forEach(rol => {

            html += `
                <option value="${rol.id_rol}">
                    ${rol.nombre_rol}
                </option>
            `;

        });

        document.getElementById("rol").innerHTML = html;

    })
    .catch(error => {

        console.error(error);

    });

}