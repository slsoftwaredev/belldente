CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cita`(

    IN p_accion VARCHAR(20),

    IN p_id_cita INT,

    IN p_paciente_id INT,

    IN p_fecha_cita DATE,

    IN p_estado TINYINT

)
BEGIN

    CASE p_accion

        -- Listar citas
        WHEN 'listar' THEN

            SELECT

                c.id_cita,

                CONCAT(
                    p.nombre_paciente,
                    ' ',
                    p.apellido_paciente
                ) AS paciente,

                c.fecha_cita,

                c.estado_cita

            FROM citas c

            INNER JOIN pacientes p
                ON c.paciente_id = p.id_paciente

            ORDER BY c.fecha_cita DESC;

        -- Guardar cita
        WHEN 'guardar' THEN

            INSERT INTO citas(

                paciente_id,
                fecha_cita

            )
            VALUES(

                p_paciente_id,
                p_fecha_cita

            );

            SELECT LAST_INSERT_ID() AS id_cita;

        -- Obtener cita
        WHEN 'obtener' THEN

            SELECT

                id_cita,
                paciente_id,
                fecha_cita,
                estado_cita

            FROM citas

            WHERE id_cita = p_id_cita;

        -- Editar cita
        WHEN 'editar' THEN

            UPDATE citas

            SET

                paciente_id = p_paciente_id,
                fecha_cita = p_fecha_cita,
                estado_cita = p_estado

            WHERE id_cita = p_id_cita;

        -- Cambiar estado
        WHEN 'estado' THEN

            UPDATE citas

            SET estado_cita = p_estado

            WHERE id_cita = p_id_cita;

        -- Citas del día
        WHEN 'citas_hoy' THEN

            SELECT

                c.id_cita,

                CONCAT(
                    p.nombre_paciente,
                    ' ',
                    p.apellido_paciente
                ) AS paciente,

                c.fecha_cita,

                c.estado_cita

            FROM citas c

            INNER JOIN pacientes p
                ON c.paciente_id = p.id_paciente

            WHERE c.fecha_cita = CURDATE()

            ORDER BY paciente;

        -- Citas atrasadas
        WHEN 'citas_atrasadas' THEN

            SELECT

                c.id_cita,

                CONCAT(
                    p.nombre_paciente,
                    ' ',
                    p.apellido_paciente
                ) AS paciente,

                c.fecha_cita,

                DATEDIFF(
                    CURDATE(),
                    c.fecha_cita
                ) AS dias_atraso

            FROM citas c

            INNER JOIN pacientes p
                ON c.paciente_id = p.id_paciente

            WHERE

                DATEDIFF(
                    CURDATE(),
                    c.fecha_cita
                ) BETWEEN 3 AND 5

            ORDER BY c.fecha_cita ASC;

    END CASE;

END