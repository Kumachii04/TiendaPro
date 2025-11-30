<?php
require_once '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $confircontraseña = $_POST['confircontraseña'];
    
    // ⚠️ FORZAMOS el rol a 'cliente' (NO usamos $_POST['rol'])
    $rol = 'cliente';
    
    // Validar correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: /public/login/registrar_usuario.php?error=Correo electrónico inválido");
        exit();
    }

    // Verificar si el correo ya existe
    $sql_check = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $correo);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        header("Location: /public/login/registrar_usuario.php?error=El correo ya está registrado");
        exit();
    }

    // Verificar si las contraseñas coinciden
    if ($contraseña !== $confircontraseña) {
        header("Location: /public/login/registrar_usuario.php?error=Las contraseñas no coinciden");
        exit();
    }

    // Hashear la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Insertar usuario usando una consulta preparada
    $sql = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, rol) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $correo, $contraseña_hash, $rol);

    if ($stmt->execute()) {
        header("Location: /public/login/registrar_usuario.php?success=Usuario registrado correctamente");
        exit();
    } else {
        header("Location: /public/login/registrar_usuario.php?error=Error al registrar usuario");
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>