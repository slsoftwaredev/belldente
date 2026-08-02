const btnNuevo = document.getElementById("btnNuevo");
const formulario = document.getElementById("formTratamiento");
const formProcedimiento = document.getElementById("formProcedimiento");
const btnCancelar = document.getElementById("btnCancelar");

btnNuevo.addEventListener("click", () => {

    formulario.classList.remove("hidden");

    formulario.scrollIntoView({

        behavior: "smooth",
        block: "start"

    });


});
btnCancelar.addEventListener("click", () => {

        formProcedimiento.reset();
        formulario.classList.add("hidden");
});
