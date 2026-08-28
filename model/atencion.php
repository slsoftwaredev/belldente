<?php
require_once __DIR__ . "/../config/conexion.php";
class Atencion{
    // Método para obtener la información de una cita específica
    public function obtenerCita($id_cita){
        $sql = "CALL sp_cita('obtener','$id_cita',NULL,NULL,NULL)";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }

    // Crear u obtener la atención asociada a una cita
    public function crear($id_cita, $id_usuario){
        $id_cita = intval($id_cita);
        $id_usuario = intval($id_usuario);
        $sql = "CALL sp_atencion('crear',0,0,'$id_usuario','$id_cita',NULL)";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }

    // Método para listar los antecedentes de un paciente
    public function listarAntecedentes(){
    $sql = "CALL sp_atencion('listar_antecedentes',NULL,NULL,NULL,NULL,NULL)";
    return ejecutarConsulta($sql);
    }

    //Método para listar el examen estomatognático de un paciente
    public function listarEstomatognatico(){
    $sql = "CALL sp_atencion('listar_estomatognatico',NULL,NULL,NULL,NULL,NULL)";
    return ejecutarConsulta($sql);
    }

    //Método para listar los indicadores de salud bucal de un paciente
    public function listarIndicadores(){
    $sql = "CALL sp_atencion('listar_indicadores',NULL,NULL,NULL,NULL,NULL)";
    return ejecutarConsulta($sql);
    }

    //Combo CIE-10 - Procedimientos o protocolos de atención
    public function comboCIE10(){
    $sql = "CALL sp_atencion('combo_cie10',0,0,0,0,NULL)";
    return ejecutarConsultaSP($sql);
    }

    // Combo de tratamientos
    public function comboTratamientos(){
    $sql = "CALL sp_atencion('combo_tratamientos',0,0,0,0,NULL)";
    return ejecutarConsultaSP($sql);
    }

    // Listar simbologías
    public function listarSimbologias(){
        $sql = "CALL sp_odontograma('simbologias', NULL)";
        return ejecutarConsultaSP($sql);
    }

    // Listar piezas según dentición
    public function listarPiezas($tipo_denticion){
        $tipo_denticion = intval($tipo_denticion);
        $sql = "CALL sp_odontograma('piezas',$tipo_denticion)";
        return ejecutarConsultaSP($sql);
    }

    //Finalizamos la atención
    public function finalizar($id_atencion,$id_cita,$id_usuario,$datos){
        global $conexion;
        $id_atencion = intval($id_atencion);
        $id_cita = intval($id_cita);
        $id_usuario = intval($id_usuario);

        // Escapar JSON para enviarlo completo al SP
        $datos = mysqli_real_escape_string($conexion,$datos);
        $sql = "CALL sp_atencion('finalizar','$id_atencion',0,'$id_usuario','$id_cita','$datos')";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }

    // Obtener datos para generar el consentimiento informado
    public function obtenerConsentimiento($id_atencion){
        $id_atencion = intval($id_atencion);
        $sql = "CALL sp_atencion('obtener_consentimiento','$id_atencion',0,0,0,NULL)";
        return ejecutarConsultaSimpleFilaAssoc($sql);
    }

    //Funcion para listar las historias clínicas
    public function listarHistorias(){
    $sql = "CALL sp_atencion('listar_historias',0,0,0,0,NULL)";
    return ejecutarConsulta($sql);
    }

// Listar atenciones finalizadas de un paciente
    public function listarAtencionesPaciente($id_paciente){
        $id_paciente = intval($id_paciente);
        $sql = "CALL sp_atencion('listar_atenciones_paciente',0,'$id_paciente',0,0,NULL)";
        return ejecutarConsulta($sql);
    }

//Consultamos las historias y damos las acciones a los WHEN que están en el SP de atención
    private function consultarHistoria($accion, $id_atencion){
    $id_atencion = intval($id_atencion);
    $accionesPermitidas = [
        'obtener_historia_atencion',
        'historia_estomatognatico',
        'historia_indicadores',
        'historia_higiene_oral',
        'historia_examenes_complementarios',
        'historia_informes_examenes',
        'historia_odontograma',
        'historia_odontograma_protesis',
        'historia_diagnosticos',
        'historia_tratamientos',
        'historia_complicaciones',
        'historia_prescripcion',
        'historia_fotografias'
    ];
    if (!in_array($accion, $accionesPermitidas, true)) {
        throw new Exception("Acción de historia no válida");
    }
    $sql = "CALL sp_atencion('$accion','$id_atencion',0,0,0,NULL)";
    return ejecutarConsultaSPArray($sql);
    }

    public function obtenerHistoriaAtencion($id_atencion){
        return $this->consultarHistoria('obtener_historia_atencion',$id_atencion);
    }

    public function historiaEstomatognatico($id_atencion){
        return $this->consultarHistoria('historia_estomatognatico',$id_atencion);
    }

    public function historiaIndicadores($id_atencion){
        return $this->consultarHistoria('historia_indicadores',$id_atencion);
    }

    public function historiaHigieneOral($id_atencion){
        return $this->consultarHistoria('historia_higiene_oral',$id_atencion);
    }

    public function historiaExamenesComplementarios($id_atencion){
        return $this->consultarHistoria('historia_examenes_complementarios',$id_atencion);
    }

    public function historiaInformesExamenes($id_atencion){
        return $this->consultarHistoria('historia_informes_examenes',$id_atencion);
    }

    public function historiaOdontograma($id_atencion){
        return $this->consultarHistoria('historia_odontograma',$id_atencion);
    }

    public function historiaOdontogramaProtesis($id_atencion){
        return $this->consultarHistoria('historia_odontograma_protesis',$id_atencion);
    }

    public function historiaDiagnosticos($id_atencion){
        return $this->consultarHistoria('historia_diagnosticos',$id_atencion);
    }

    public function historiaTratamientos($id_atencion){
        return $this->consultarHistoria('historia_tratamientos',$id_atencion);
    }

    public function historiaComplicaciones($id_atencion){
        return $this->consultarHistoria('historia_complicaciones',$id_atencion);
    }

    public function historiaPrescripcion($id_atencion){
        return $this->consultarHistoria('historia_prescripcion',$id_atencion);
    }

    public function historiaFotografias($id_atencion){
        return $this->consultarHistoria('historia_fotografias',$id_atencion);
    }

//Obtenemos la historia completa
public function obtenerHistoriaCompleta($id_atencion){
    $id_atencion = intval($id_atencion);
    if ($id_atencion <= 0) {
        throw new Exception("ID de atención no válido");
    }

    // Información principal de la atención
    $cabecera = $this->obtenerHistoriaAtencion($id_atencion);
    return [
        "cabecera" => $cabecera[0] ?? null,
        "estomatognatico" => $this->historiaEstomatognatico($id_atencion),
        "indicadores" => $this->historiaIndicadores($id_atencion),
        "higiene_oral" => $this->historiaHigieneOral($id_atencion),
        "examenes_complementarios" => $this->historiaExamenesComplementarios($id_atencion),
        "informes_examenes" => $this->historiaInformesExamenes($id_atencion),
        "odontograma" => [
            "registros" => $this->historiaOdontograma($id_atencion),
            "protesis" => $this->historiaOdontogramaProtesis($id_atencion)
        ],
        "diagnosticos" => $this->historiaDiagnosticos($id_atencion),
        "tratamientos" => $this->historiaTratamientos($id_atencion),
        "complicaciones" => $this->historiaComplicaciones($id_atencion),
        "prescripcion" => $this->historiaPrescripcion($id_atencion),
        "fotografias" => $this->historiaFotografias($id_atencion)
    ];
    }
}