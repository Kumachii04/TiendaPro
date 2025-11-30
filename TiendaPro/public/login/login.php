<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - NAEI Market</title>
    <link rel="shortcut icon" href="/assets/img/logo/users-alt (1).png" type="image/x-icon">
    <link rel="stylesheet" href="/src/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container login" id="loginForms">
        <img src="/assets/img/logo/nae.png" alt="Logo" class="logo">
        <h2 class="text-title">Bienvenido de nuevo</h2>
        <p class="text-center text-muted mb-4">Ingresa tus credenciales para continuar</p>

        <!-- Formulario de inicio de sesión -->
        <form method="post" action="/Controllers/authentication.php" class="LoginFormsDate">
            <div class="top-margin">
                <label for="correo">
                    <i class="fas fa-envelope me-2"></i>Correo Electrónico
                </label>
                <input type="email" class="form-control" name="correo" placeholder="ejemplo@correo.com" required>
            </div>
            <div class="top-margin">
                <label for="password">
                    <i class="fas fa-lock me-2"></i>Contraseña
                </label>
                <input type="password" class="form-control me-2" name="password" placeholder="Ingresa tu contraseña"
                    required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
                <a href="/public/login/recuperar_password.php" class="text-decoration-none">¿Olvidaste tu
                    contraseña?</a>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
            </button>
            <p class="text-center mt-4">
                ¿No tienes una cuenta?
                <a href="/public/login/registrar_usuario.php" class="text-decoration-none">Regístrate aquí</a>
            </p>
        </form>
    </div>

    <!-- Modal de confirmación de inicio de sesión -->
    <div class="modal fade" id="loginResultModal" tabindex="-1" aria-labelledby="loginResultLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginResultLabel">
                        <i class="fas fa-info-circle me-2"></i>Estado de Inicio de Sesión
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="modalMessage">
                    <!-- El mensaje se insertará aquí dinámicamente -->
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
        var loginResultModal = new bootstrap.Modal(document.getElementById('loginResultModal'));
        var modalMessage = document.getElementById('modalMessage');
        var urlParams = new URLSearchParams(window.location.search);
        var errorMessage = urlParams.get('error');
        var successMessage = urlParams.get('success');

        if (errorMessage) {
            modalMessage.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>${errorMessage}
                </div>`;
            loginResultModal.show();
        } else if (successMessage) {
            modalMessage.innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>¡Inicio de sesión exitoso! Bienvenido.
                </div>`;
            loginResultModal.show();
        }

        // Limpiar los parámetros de la URL después de mostrar el modal
        window.history.replaceState({}, document.title, window.location.pathname);
    });
    </script>
</body>

</html>