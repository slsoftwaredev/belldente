-- Crear roles
CREATE TABLE roles (
    id_rol SERIAL PRIMARY KEY,
    nombre_rol VARCHAR(50) UNIQUE NOT NULL
);
-- Crear tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    apellido_usuario VARCHAR(50) NOT NULL,
    correo_usuario VARCHAR(100) UNIQUE NOT NULL,
    cedula_usuario VARCHAR(20) UNIQUE NOT NULL,
    usu_usuario VARCHAR(50) UNIQUE NOT NULL,
    pass_usuario VARCHAR(255) NOT NULL,
    domicilio_usuario VARCHAR(255) NOT NULL,
    telefono_usuario VARCHAR(20) NOT NULL,
    rol_id INT NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES roles(id_rol)
);
-- 
--
-- Tabla estado citas
CREATE TABLE estados_cita(
    id_estado_cita INT AUTO_INCREMENT PRIMARY KEY,
    nombre_estado VARCHAR(50) NOT NULL,
);

-- Tabla atención clínica
CREATE TABLE atencion(

    id_atencion INT AUTO_INCREMENT PRIMARY KEY,

    cita_id INT NOT NULL,

    fecha_atencion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    motivo_consulta TEXT,

    enfermedad_actual TEXT,

    observaciones TEXT,

    estado_atencion ENUM(
        'En atención',
        'Finalizada'
    ) DEFAULT 'En atención',

    usuario_id INT NOT NULL,

    FOREIGN KEY(cita_id)
        REFERENCES cita(id_cita),

    FOREIGN KEY(usuario_id)
        REFERENCES usuario(id_usuario)

);

-- Tabla antecedentes médicos
CREATE TABLE paciente_antecedentes(

    id_paciente_antecedente INT AUTO_INCREMENT PRIMARY KEY,

    paciente_id INT NOT NULL,

    antecedente_id INT NOT NULL,

    observacion VARCHAR(255) NULL,

    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (paciente_id)
        REFERENCES pacientes(id_paciente),

    FOREIGN KEY (antecedente_id)
        REFERENCES catalogo_antecedentes(id_antecedente),

    UNIQUE (paciente_id, antecedente_id)

);

-- Tabla constantes vitales
CREATE TABLE constantes_vitales(

    id_constante INT AUTO_INCREMENT PRIMARY KEY,

    atencion_id INT NOT NULL,

    presion_arterial VARCHAR(20),

    frecuencia_cardiaca VARCHAR(10),

    frecuencia_respiratoria VARCHAR(10),

    temperatura DECIMAL(4,1),

    peso DECIMAL(5,2),

    talla DECIMAL(5,2),

    FOREIGN KEY(atencion_id)
        REFERENCES atencion(id_atencion)

);

-- tabla examen estomatognatico
CREATE TABLE examen_estomatognatico(

    id_examen INT AUTO_INCREMENT PRIMARY KEY,

    atencion_id INT NOT NULL,

    labios TEXT,

    mejillas TEXT,

    lengua TEXT,

    paladar TEXT,

    piso_boca TEXT,

    glandulas_salivales TEXT,

    maxilares TEXT,

    articulacion_temporomandibular TEXT,

    ganglios TEXT,

    observaciones TEXT,

    FOREIGN KEY(atencion_id)
        REFERENCES atencion(id_atencion)

);

-- Tabla indides bucales
CREATE TABLE indices_bucales(

    id_indice INT AUTO_INCREMENT PRIMARY KEY,

    atencion_id INT NOT NULL,

    cpo INT,

    ceo INT,

    higiene_oral TEXT,

    placa TEXT,

    gingival TEXT,

    observaciones TEXT,

    FOREIGN KEY(atencion_id)
        REFERENCES atencion(id_atencion)

);

-- Tabla diagnostico
CREATE TABLE diagnostico(

    id_diagnostico INT AUTO_INCREMENT PRIMARY KEY,

    atencion_id INT NOT NULL,

    cie10 VARCHAR(20),

    descripcion VARCHAR(255),

    tipo ENUM(
        'Presuntivo',
        'Definitivo'
    ),

    observaciones TEXT,

    FOREIGN KEY(atencion_id)
        REFERENCES atencion(id_atencion)

);

-- Tabla tratamiento
CREATE TABLE tratamiento(

    id_tratamiento INT AUTO_INCREMENT PRIMARY KEY,

    atencion_id INT NOT NULL,

    procedimiento VARCHAR(255),

    cantidad INT DEFAULT 1,

    observaciones TEXT,

    estado ENUM(
        'Pendiente',
        'Realizado'
    ) DEFAULT 'Pendiente',

    FOREIGN KEY(atencion_id)
        REFERENCES atencion(id_atencion)

);