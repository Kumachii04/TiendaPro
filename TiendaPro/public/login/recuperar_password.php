<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Fastify</title>
    <link rel="shortcut icon" href="/assets/img/logo/users-alt (1).png" type="image/x-icon">
    <link rel="stylesheet" href="/src/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container login" id="loginForms">
        <img src="/assets/img/logo/Fastify_light.svg" alt="Logo" class="logo">
        <h2 class="text-title">Recuperar Contraseña</h2>
        <p class="text-center text-muted mb-4">Ingresa tu correo electrónico para recuperar tu contraseña</p>

        <!-- Formulario de recuperación de contraseña -->
        <form action="/Controllers/recuperar_password.php" method="POST" class="LoginFormsDate">
            <div class="top-margin">
                <label for="correo">
                    <i class="fas fa-envelope me-2"></i>Correo Electrónico
                </label>
                <input type="email" name="correo" class="form-control" 
                    placeholder="ejemplo@correo.com" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>Enviar Instrucciones
            </button>
            <p class="text-center mt-4">
                ¿Recordaste tu contraseña? 
                <a href="/public/login/login.php" class="text-decoration-none">Inicia sesión aquí</a>
            </p>
        </form>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="recoveryResultModal" tabindex="-1" aria-labelledby="recoveryResultLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recoveryResultLabel">
                        <i class="fas fa-info-circle me-2"></i>Estado de la Solicitud
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="modalMessage">
                    <?php 
                    if (isset($_GET['success'])) {
                        echo '<div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>' . htmlspecialchars($_GET['success']) . '
                        </div>';
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
        var recoveryResultModal = new bootstrap.Modal(document.getElementById('recoveryResultModal'));
        var urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('success') || urlParams.has('error')) {
            recoveryResultModal.show();
        }
    });
    </script>
</body>

</html>
