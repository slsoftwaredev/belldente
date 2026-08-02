const btnNuevo = document.getElementById("btnNuevo");
const formulario = document.getElementById("formCIE");
const formCIE10 = document.getElementById("formCIE10");
const btnCancelar = document.getElementById("btnCancelar");
const txtBuscar = document.getElementById("buscarCIE10");
const tablaCIE10 = document.querySelectorAll("#tbllistadoCie10 tr");
const cardsCIE10 = document.querySelectorAll("#cardCIE10 > div");

btnNuevo.addEventListener("click", () => {

    formulario.classList.remove("hidden");

    formulario.scrollIntoView({

        behavior: "smooth",
        block: "start"

    });


});
btnCancelar.addEventListener("click", () => {

        formCIE10.reset();
        formulario.classList.add("hidden");
});
txtBuscar.addEventListener("keyup", buscarCIE10);

function buscarCIE10(){

    const filtro = txtBuscar.value.toLowerCase();

    let visiblesTabla = 0;
    let visiblesCards = 0;

    tablaCIE10.forEach(fila => {

        const texto = fila.textContent.toLowerCase();

        if(texto.includes(filtro)){

            fila.style.display = "";
            visiblesTabla++;

        }else{

            fila.style.display = "none";

        }

    });

    cardsCIE10.forEach(card => {

        const texto = card.textContent.toLowerCase();

        if(texto.includes(filtro)){

            card.style.display = "";
            visiblesCards++;

        }else{

            card.style.display = "none";

        }

    });

}
