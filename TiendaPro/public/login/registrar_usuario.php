<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - NAEI Market</title>
    <link rel="shortcut icon" href="/assets/img/logo/users-alt (1).png" type="image/x-icon">
    <link rel="stylesheet" href="/src/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container login" id="loginForms">
        <img src="/assets/img/logo/nae.png" alt="Logo" class="logo">
        <h2 class="text-title">Crear cuenta</h2>
        <p class="text-center text-muted mb-4">Completa tus datos para registrarte</p>

        <!-- Formulario de registro de usuario -->
        <form action="/Controllers/register.php" method="POST" class="LoginFormsDate">
            <div class="top-margin">
                <label for="nombre">
                    <i class="fas fa-user me-2"></i>Nombre
                </label>
                <input type="text" name="nombre" class="form-control" placeholder="Ingresa tu nombre" required>
            </div>
            <div class="top-margin">
                <label for="apellido">
                    <i class="fas fa-user me-2"></i>Apellido
                </label>
                <input type="text" name="apellido" class="form-control" placeholder="Ingresa tu apellido" required>
            </div>
            <div class="top-margin">
                <label for="correo">
                    <i class="fas fa-envelope me-2"></i>Correo Electrónico
                </label>
                <input type="email" name="correo" class="form-control" placeholder="ejemplo@correo.com" required>
            </div>
            <div class="top-margin">
                <label for="contraseña">
                    <i class="fas fa-lock me-2"></i>Contraseña
                </label>
                <input type="password" name="contraseña" class="form-control" placeholder="Crea una contraseña segura"
                    required>
            </div>
            <div class="top-margin">
                <label for="confircontraseña">
                    <i class="fas fa-lock me-2"></i>Confirmar Contraseña
                </label>
                <input type="password" name="confircontraseña" class="form-control" placeholder="Confirma tu contraseña"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Registrarse
            </button>
            <p class="text-center mt-4">
                ¿Ya tienes una cuenta?
                <a href="/public/login/login.php" class="text-decoration-none">Inicia sesión aquí</a>
            </p>
        </form>
    </div>

    <!-- Modal de confirmación de registro -->
    <div class="modal fade" id="registerResultModal" tabindex="-1" aria-labelledby="registerResultLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerResultLabel">
                        <i class="fas fa-info-circle me-2"></i>Estado del Registro
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="modalMessage">
                    <?php
                    if (isset($_GET['success'])) {
                        echo '<div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>' . htmlspecialchars($_GET['success']) . '
                        </div>';
                        header('Location: /public/login/login.php');
                    } elseif (isset($_GET['error'])) {
                        echo '<div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>' . htmlspecialchars($_GET['error']) . '
                        </div>';
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var registerResultModal = new bootstrap.Modal(document.getElementById('registerResultModal'));
        var urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('success') || urlParams.has('error')) {
            registerResultModal.show();
        }
    });
    </script>
</body>

</html>