document.addEventListener("DOMContentLoaded", () => {
    listarUsuarios();
    cargarRoles();
    cargarModulos();

    // Modal
    const modal = document.getElementById("modalUsuario");
    const btnNuevoUsuario = document.getElementById("btnNuevoUsuario");
    const btnCerrarModal = document.getElementById("btnCerrarModal");
    const btnCancelar = document.getElementById("btnCancelar");

    btnNuevoUsuario.addEventListener("click", () => {
    formUsuario.reset();
    document.getElementById("id_usuario").value = 0;
    // Desmarcamos todos los permisos
    document.querySelectorAll(".permisoModulo").forEach(permiso => {permiso.checked = false;});
    // Restauramos el texto del botón
    document.getElementById("btnSeleccionarTodos").innerText = "Seleccionar todos";
    document.getElementById("tituloModal").innerText = "Nuevo Usuario";
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

    const btnSeleccionarTodos =
    document.getElementById("btnSeleccionarTodos");

btnSeleccionarTodos.addEventListener("click", () => {

    const permisos =
        document.querySelectorAll(".permisoModulo");

    const todosMarcados =
        [...permisos].every(permiso => permiso.checked);

    permisos.forEach(permiso => {
        permiso.checked = !todosMarcados;
    });

    btnSeleccionarTodos.innerText =
        todosMarcados
            ? "Seleccionar todos"
            : "Quitar todos";

});
    // Formulario
    const formUsuario = document.getElementById("formUsuario");

    formUsuario.addEventListener("submit", function (e) {

        e.preventDefault();

        const formData = new FormData(formUsuario);
        const accion = document.getElementById("id_usuario").value ==0 ? "guardar" : "editar";
        fetch("../ajax/usuario.php?op=" + accion, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            if (data.status) {

                alert(accion == "guardar" ? "Usuario registrado correctamente" : "Usuario actualizado correctamente");

                formUsuario.reset();

                modal.classList.add("hidden");
                modal.classList.remove("flex");

                listarUsuarios();

            } else {

                alert(accion == "guardar" ? "Error al registrar usuario" : "Error al actualizar usuario");

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
//Funcion para cargar los datos del usuario para editar
function editarUsuario(id_usuario){
    const modal = document.getElementById("modalUsuario");
    modal.classList.remove("hidden");
    fetch("../ajax/usuario.php?op=obtener",{
        method:"POST",
        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:"id_usuario="+id_usuario
    })
    .then(response => response.json())
    .then(data => {

        document.getElementById("id_usuario").value =
        data[0];

        document.querySelector("[name='nombre']").value =
        data[1];

        document.querySelector("[name='apellido']").value =
        data[2];

        document.querySelector("[name='correo']").value =
        data[3];

        document.querySelector("[name='cedula']").value =
        data[4];

        document.querySelector("[name='usuario']").value =
        data[5];

        document.querySelector("[name='domicilio']").value =
        data[6];

        document.querySelector("[name='telefono']").value =
        data[7];

        document.getElementById("rol").value =
        data[8];

        // Cargamos los permisos que tiene asignados
        cargarModulos().then(() => {cargarPermisosUsuario(id_usuario);});

        document.getElementById("tituloModal").innerText =
        "Editar Usuario";

        modal.classList.remove("hidden");

    });

}
//Función para cambiar el estado del usuario
function cambiarEstado(id_usuario, estado){

    const mensaje =
        estado == 1
        ? "¿Desea activar este usuario?"
        : "¿Desea inactivar este usuario?";

    if(!confirm(mensaje)){
        return;
    }

    const formData = new FormData();

    formData.append(
        "id_usuario",
        id_usuario
    );

    formData.append(
        "estado",
        estado
    );

    fetch("../ajax/usuario.php?op=estado",{
        method:"POST",
        body:formData
    })
    .then(response => response.json())
    .then(data => {

        if(data.status){

            listarUsuarios();

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
.addEventListener("keyup", buscarUsuarios);

function buscarUsuarios(){

    let filtro =
    this.value.toLowerCase();

    // Tabla Desktop

    document
    .querySelectorAll("#tblUsuarios tr")
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
    .querySelectorAll("#cardUsuarios > div")
    .forEach(card => {

        let texto =
        card.textContent.toLowerCase();

        card.style.display =
        texto.includes(filtro)
        ? ""
        : "none";

    });

}
// Función para cargar los módulos disponibles
function cargarModulos(){
    return fetch("../ajax/usuario.php?op=modulos")
        .then(response => response.json())
        .then(data => {

            let html = "";

            data.forEach(modulo => {

                html += `
                    <label
                        class="flex items-center gap-3 border border-slate-200
                               rounded-xl px-4 py-3 cursor-pointer
                               hover:bg-blue-50 transition">

                        <input
                            type="checkbox"
                            name="permisos[]"
                            value="${modulo.id_modulo}"
                            class="permisoModulo w-4 h-4 accent-blue-600">

                        <div>
                            <p class="text-sm font-medium text-slate-700">
                                ${modulo.nombre_modulo}
                            </p>

                            <p class="text-xs text-slate-400">
                                ${modulo.clave_modulo}
                            </p>
                        </div>

                    </label>
                `;

            });

            document.getElementById("contenedorPermisos").innerHTML = html;

        })
        .catch(error => {

            console.error("Error al cargar módulos:", error);

        });

}

// Función para cargar los permisos asignados a un usuario
function cargarPermisosUsuario(id_usuario){

    // Primero desmarcamos todos
    document.querySelectorAll(".permisoModulo")
        .forEach(permiso => {
            permiso.checked = false;
        });

    const formData = new FormData();

    formData.append(
        "id_usuario",
        id_usuario
    );

    fetch("../ajax/usuario.php?op=permisos", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        data.forEach(permiso => {

            const checkbox = document.querySelector(
                `.permisoModulo[value="${permiso.id_modulo}"]`
            );

            if(checkbox){
                checkbox.checked = true;
            }

        });

        document.getElementById("btnSeleccionarTodos").innerText =
            "Seleccionar todos";

    })
    .catch(error => {

        console.error(
            "Error al cargar permisos del usuario:",
            error
        );

    });

}