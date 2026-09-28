const formLogin = document.getElementById("formLogin");

const modalLogin = document.getElementById("modalLogin");
const mensajeLogin = document.getElementById("mensajeLogin");
const btnCerrarModalLogin = document.getElementById("btnCerrarModalLogin");


// ========================================
// ABRIR MODAL
// ========================================
function mostrarModalLogin(mensaje) {

    mensajeLogin.textContent =
        mensaje || "Usuario o contraseña incorrectos.";

    modalLogin.classList.remove("hidden");
    modalLogin.classList.add("flex");
}


// ========================================
// CERRAR MODAL
// ========================================
function cerrarModalLogin() {

    modalLogin.classList.add("hidden");
    modalLogin.classList.remove("flex");

}


// ========================================
// BOTÓN CERRAR
// ========================================
btnCerrarModalLogin.addEventListener("click", () => {

    cerrarModalLogin();

    // Regresamos el cursor al usuario
    document
        .querySelector('input[name="usuario"]')
        .focus();

});


// ========================================
// LOGIN
// ========================================
formLogin.addEventListener("submit", function(e) {

    e.preventDefault();

    const formData = new FormData(formLogin);

    fetch("../ajax/login.php", {

        method: "POST",
        body: formData

    })
    .then(response => response.json())
    .then(data => {

        if (data.status) {

            window.location.href =
                "../views/escritorio.php";

        } else {

            mostrarModalLogin(
                data.message ||
                "Usuario o contraseña incorrectos."
            );

        }

    })
    .catch(error => {

        console.error(error);

        mostrarModalLogin(
            "Ocurrió un error al intentar iniciar sesión. Intente nuevamente."
        );

    });

});