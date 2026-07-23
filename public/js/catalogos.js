const btnNuevoCIE10 = document.getElementById("btnNuevoCIE10");
const modalCIE10 = document.getElementById("modalCIE10");
btnNuevoCIE10.addEventListener("click", () => {

    limpiarFormulario();

    document.getElementById("tituloModalCIE10").textContent = "Nuevo Diagnóstico";

    modalCIE10.classList.remove("hidden");
    modalCIE10.classList.add("flex");

});
// Función para cerrar el modal
function cerrarModalCIE10(){

    modalCIE10.classList.remove("flex");
    modalCIE10.classList.add("hidden");

}