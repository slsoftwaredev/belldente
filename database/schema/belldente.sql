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