<?php
session_start();

include '../config/connection.php';

$error = ''; // Variable para almacenar el mensaje de error


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, apellido, rol, contraseña FROM Usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $user['contraseña'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['correo'] = $user['correo'];
            $_SESSION['apellido'] = $user['apellido'];
            $_SESSION['rol'] = !empty($user['rol']) ? $user['rol'] : 'cliente';
            header("Location: /public/home_product.php?success=Login Exito..");
            exit();
        } else {
            header("Location: /public/login/login.php?error=Contraseña incorrecta");
            exit();
        }
    } else {
        header("Location: /public/login/login.php?error=Email incorrecta ");
        exit();
    }
    $stmt->close();
}

$conn->close();