<?php
session_start();
require_once '../config/connection.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /public/login/login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];
$mensaje = '';

// =============== OBTENER DATOS DEL USUARIO ===============
$sql = "SELECT id, nombre, apellido, correo, rol FROM Usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);

// ✅ Verificación crítica: si prepare() falla, no sigue
if (!$stmt) {
    error_log("Error en prepare (perfil.php): " . $conn->error);
    die("Error interno. No se pudo cargar tu perfil.");
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: /public/login/login.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

$avatar = '/assets/img/logo/profile-1.png'; // Sin foto_perfil, usamos fallback

// =============== ACTUALIZAR PERFIL ===============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_perfil') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $correo = trim($_POST['correo']);

    if (empty($nombre) || empty($correo)) {
        $mensaje = '<div class="alert alert-warning">Nombre y correo son obligatorios.</div>';
    } else {
        $sql = "UPDATE Usuarios SET nombre = ?, apellido = ?, correo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $mensaje = '<div class="alert alert-danger">Error en la base de datos. Inténtalo más tarde.</div>';
        } else {
            $stmt->bind_param('sssi', $nombre, $apellido, $correo, $user_id);
            if ($stmt->execute()) {
                $mensaje = '<div class="alert alert-success">Perfil actualizado correctamente.</div>';
                // Actualizar sesión
                $_SESSION['usuario_nombre'] = $nombre;
                $_SESSION['usuario_apellido'] = $apellido;
                // Recargar datos en $user
                $user['nombre'] = $nombre;
                $user['apellido'] = $apellido;
                $user['correo'] = $correo;
            } else {
                $mensaje = '<div class="alert alert-danger">Error al actualizar el perfil.</div>';
            }
            $stmt->close();
        }
    }
}

// =============== CAMBIAR CONTRASEÑA ===============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cambiar_password') {
    $password_actual = $_POST['password_actual'];
    $nueva_password = $_POST['nueva_password'];
    $confirmar_password = $_POST['confirmar_password'];

    if (empty($password_actual) || empty($nueva_password) || empty($confirmar_password)) {
        $mensaje = '<div class="alert alert-warning">Todos los campos son obligatorios.</div>';
    } elseif ($nueva_password !== $confirmar_password) {
        $mensaje = '<div class="alert alert-warning">Las contraseñas no coinciden.</div>';
    } elseif (strlen($nueva_password) < 6) {
        $mensaje = '<div class="alert alert-warning">La nueva contraseña debe tener al menos 6 caracteres.</div>';
    } else {
        // Verificar contraseña actual
        $sql = "SELECT password FROM Usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $mensaje = '<div class="alert alert-danger">Error al verificar la contraseña.</div>';
        } else {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $userData = $result->fetch_assoc();
            $stmt->close();

            if ($userData && password_verify($password_actual, $userData['password'])) {
                $hash_nueva = password_hash($nueva_password, PASSWORD_DEFAULT);
                $sql = "UPDATE Usuarios SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    $mensaje = '<div class="alert alert-danger">Error al preparar la actualización.</div>';
                } else {
                    $stmt->bind_param('si', $hash_nueva, $user_id);
                    if ($stmt->execute()) {
                        $mensaje = '<div class="alert alert-success">Contraseña actualizada correctamente.</div>';
                    } else {
                        $mensaje = '<div class="alert alert-danger">Error al actualizar la contraseña.</div>';
                    }
                    $stmt->close();
                }
            } else {
                $mensaje = '<div class="alert alert-danger">La contraseña actual es incorrecta.</div>';
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - N.A.E.I Market</title>
    <link rel="shortcut icon" href="/assets/img/logo/nae.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css ">
    <style>
    :root {
        --primary: #0d6efd;
        --success: #28a745;
        --warning: #ffc107;
        --dark: #131921;
        --light: #f8f9fa;
    }

    body {
        background-color: var(--light);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--dark) 0%, #232f3e 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 40px;
    }

    .avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.3);
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .profile-card {
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 30px;
    }

    .profile-card .card-header {
        background: white;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        font-size: 1.2rem;
        padding: 18px 24px;
        color: var(--dark);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
        padding: 10px 20px;
        font-weight: 600;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        border: none;
        padding: 10px 20px;
        font-weight: 600;
        color: #212529;
    }

    .btn-warning:hover {
        color: white;
    }
    </style>
</head>

<body>
    <?php include '../src/components/header.php'; ?>

    <div class="profile-header">
        <img src="<?php echo $avatar; ?>" alt="Foto de perfil" class="avatar-large"
            onerror="this.src='/assets/img/logo/profile-1.png'">
        <h1><?php echo htmlspecialchars($user['nombre'] . ' ' . $user['apellido']); ?></h1>
    </div>

    <div class="container">
        <?php echo $mensaje; ?>

        <div class="row">
            <!-- Formulario de perfil -->
            <div class="col-lg-8">
                <div class="card profile-card">
                    <div class="card-header">
                        <i class="fas fa-user-edit me-2"></i>Información Personal
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="update_perfil">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control"
                                        value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" name="apellido" class="form-control"
                                        value="<?php echo htmlspecialchars($user['apellido']); ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control"
                                    value="<?php echo htmlspecialchars($user['correo']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Cambio de contraseña -->
                <div class="card profile-card">
                    <div class="card-header">
                        <i class="fas fa-lock me-2"></i>Seguridad
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="cambiar_password">
                            <div class="mb-3">
                                <label class="form-label">Contraseña Actual</label>
                                <input type="password" name="password_actual" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" name="nueva_password" class="form-control" minlength="6"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" name="confirmar_password" class="form-control" minlength="6"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>Cambiar Contraseña
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="col-lg-4">
                <div class="card profile-card">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-2"></i>Información de Cuenta
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>ID de Usuario</span>
                                <span class="badge bg-secondary"><?php echo $user['id']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Último acceso</span>
                                <span class="text-muted">Hoy</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Estado</span>
                                <span class="badge bg-success">Activo</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card profile-card">
                    <div class="card-header">
                        <i class="fas fa-user-shield me-2"></i>Privacidad
                    </div>
                    <div class="card-body">
                        <p>Tu información personal está protegida con cifrado de alta seguridad.</p>
                        <p class="text-muted small">Nunca compartiremos tus datos sin tu consentimiento.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../src/components/footer.html'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js "></script>
</body>

</html>