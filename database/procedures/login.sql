CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login_usuario`(
    IN p_usuario VARCHAR(50)
)
BEGIN

    SELECT 
        u.id_usuario,
        u.nombre_usuario,
        u.apellido_usuario,
        u.correo_usuario,
        u.usu_usuario,
        u.pass_usuario,
        r.id_rol,
        r.nombre_rol
    FROM usuarios u
    INNER JOIN roles r
        ON u.rol_id = r.id_rol
    WHERE u.usu_usuario = p_usuario
    LIMIT 1;

END