CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario`(
    IN p_accion VARCHAR(20),
    IN p_id_usuario INT,
    IN p_nombre VARCHAR(50),
    IN p_apellido VARCHAR(50),
    IN p_correo VARCHAR(100),
    IN p_cedula VARCHAR(20),
    IN p_usuario VARCHAR(50),
    IN p_password VARCHAR(255),
    IN p_domicilio VARCHAR(255),
    IN p_telefono VARCHAR(20),
    IN p_rol INT,
    IN p_estado TINYINT
)
BEGIN

    CASE p_accion
	-- Listamos los usuarios
        WHEN 'listar' THEN

            SELECT
                u.id_usuario,
                CONCAT(
                    u.nombre_usuario,
                    ' ',
                    u.apellido_usuario
                ) AS nombre_completo,
                u.correo_usuario,
                u.usu_usuario,
                r.nombre_rol,
                u.estado_usuario
            FROM usuarios u
            INNER JOIN roles r
                ON u.rol_id = r.id_rol
            ORDER BY u.id_usuario DESC;
	-- Registramos el usuario
        WHEN 'guardar' THEN

            INSERT INTO usuarios(
                nombre_usuario,
                apellido_usuario,
                correo_usuario,
                cedula_usuario,
                usu_usuario,
                pass_usuario,
                domicilio_usuario,
                telefono_usuario,
                rol_id
            )
            VALUES(
                p_nombre,
                p_apellido,
                p_correo,
                p_cedula,
                p_usuario,
                p_password,
                p_domicilio,
                p_telefono,
                p_rol
            );

        WHEN 'estado' THEN

            UPDATE usuarios
            SET estado_usuario = p_estado
            WHERE id_usuario = p_id_usuario;
	-- Obtenemos los roles	
        WHEN 'roles' THEN
        SELECT
            id_rol,
            nombre_rol
        FROM roles
        ORDER BY nombre_rol;
	-- Obtenemos el usuario
		WHEN 'obtener' THEN

			SELECT
				id_usuario,
				nombre_usuario,
				apellido_usuario,
				correo_usuario,
				cedula_usuario,
				usu_usuario,
				domicilio_usuario,
				telefono_usuario,
				rol_id
			FROM usuarios
			WHERE id_usuario = p_id_usuario;
	-- Editamos el usuario
    WHEN 'editar' THEN

    UPDATE usuarios
    SET
        nombre_usuario = p_nombre,
        apellido_usuario = p_apellido,
        correo_usuario = p_correo,
        cedula_usuario = p_cedula,
        usu_usuario = p_usuario,
        domicilio_usuario = p_domicilio,
        telefono_usuario = p_telefono,
        rol_id = p_rol
    WHERE id_usuario = p_id_usuario;
    END CASE;

END