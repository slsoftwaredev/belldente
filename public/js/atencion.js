document.addEventListener("DOMContentLoaded", () => {
    cargarCita();
});

async function cargarCita() {

    const id_cita = document.getElementById("id_cita").value;

    if (!id_cita) return;

    const formData = new FormData();
    formData.append("id_cita", id_cita);

    const respuesta = await fetch("../ajax/atencion.php?op=obtener_cita", {
        method: "POST",
        body: formData
    });

    const data = await respuesta.json();

    document.getElementById("paciente").textContent =
        data.nombre_paciente + " " + data.apellido_paciente;

    document.getElementById("cedula").textContent = data.cedula_paciente;
    document.getElementById("fecha_nacimiento").textContent = data.fecha_nacimiento;
    document.getElementById("edad").textContent = data.edad_paciente;
    document.getElementById("telefono").textContent = data.telefono_paciente;
    document.getElementById("correo").textContent = data.correo_paciente;
    document.getElementById("direccion").textContent = data.direccion_paciente;
    document.getElementById("fecha_cita").textContent = data.fecha_cita;
    document.getElementById("estado_cita").textContent =
        data.nombre_estado ?? data.estado_cita;
}

// Funcionalidad de cancelar
document.getElementById("btnCancelar").addEventListener("click", () => {
    if (confirm("¿Cancelar la atención? Los cambios no guardados se perderán.")) {
        location.href = "citas.php";
    }
});