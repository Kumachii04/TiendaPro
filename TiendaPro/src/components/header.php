<?php
include '../config/connection.php';

// Inicializar variables de usuario
$rol = 'cliente';
$nombre = "Invitado";
$apellido = "";
$correo = "No disponible";
$avatar = "/assets/img/logo/profile-1.png";
$user = null;

// Obtener información del usuario si está autenticado
if (isset($_SESSION['usuario_id'])) {
    $user_id = $_SESSION['usuario_id'];
    
    try {
        $sql = "SELECT nombre, apellido, correo, foto_perfil, rol FROM Usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $nombre = htmlspecialchars($user['nombre'] ?? 'Invitado');
                $apellido = htmlspecialchars($user['apellido'] ?? '');
                $correo = htmlspecialchars($user['correo'] ?? 'No disponible');
                $avatar = htmlspecialchars($user['foto_perfil'] ?? '/assets/img/logo/profile-1.png');
                $rol = $user['rol'] ?? 'cliente';
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        error_log("Error al obtener datos del usuario: " . $e->getMessage());
    }
}

// Total de items en el carrito
$totalCarrito = function_exists('obtenerTotalCarrito') ? obtenerTotalCarrito() : 0;
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark py-3" role="navigation" aria-label="Navegación principal">
        <div class="container-fluid">
            <!-- Logo y Nombre del sitio -->
            <a href="/" class="navbar-brand d-flex align-items-center" aria-label="Ir a inicio">
                <img src="/assets/img/logo/nae.png" alt="Logo N.A.E.I Market" height="45" loading="lazy">
                <span class="ms-2 fw-bold fs-4">NAE Store</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Alternar menú de navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Menú principal -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="/public/home_product.php" class="nav-link" aria-label="Ir a inicio">
                            <i class="fas fa-home me-2"></i>Inicio
                        </a>
                    </li>

                    <?php if ($rol === 'admin'): ?>
                    <li class="nav-item">
                        <a href="/public/admin/dashboard.php" class="nav-link" aria-label="Panel de usuarios">
                            <i class="fas fa-users me-2"></i>Usuarios
                        </a>
                    </li>
                    <?php elseif ($rol === 'contador'): ?>
                    <li class="nav-item">
                        <a href="/public/admin/ventas.php" class="nav-link" aria-label="Ver ventas">
                            <i class="fas fa-chart-line me-2"></i>Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/public/admin/finanzas.php" class="nav-link" aria-label="Ver finanzas">
                            <i class="fas fa-money-bill-wave me-2"></i>Finanzas
                        </a>
                    </li>
                    <?php elseif ($rol === 'ayudante'): ?>
                    <li class="nav-item">
                        <a href="/public/admin/pedidos.php" class="nav-link" aria-label="Ver inventario">
                            <i class="fas fa-box me-2"></i>Inventario
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a href="/public/acerca.php" class="nav-link" aria-label="Acerca de nosotros">
                            <i class="fas fa-info-circle me-2"></i>Acerca de
                        </a>
                    </li>
                </ul>

                <!-- Acciones del usuario -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Carrito -->
                    <a href="/public/carrito.php" class="btn btn-light btn-cart position-relative"
                        aria-label="Ver carrito de compras" title="Mi Carrito">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="d-none d-md-inline ms-2">Carrito</span>
                        <?php if ($totalCarrito > 0): ?>
                        <span class="badge-cart" id="num_cont"
                            aria-label="<?php echo $totalCarrito; ?> artículos en el carrito">
                            <?php echo $totalCarrito; ?>
                        </span>
                        <?php endif; ?>
                    </a>

                    <?php if (isset($_SESSION['usuario_id']) && $user): ?>
                    <!-- Usuario autenticado -->
                    <div class="dropdown">
                        <button class="btn btn-user dropdown-toggle" type="button" id="userMenu"
                            data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menú de usuario"
                            title="Mi cuenta">
                            <img src="<?php echo $avatar; ?>" alt="Foto de perfil de <?php echo $nombre; ?>"
                                class="user-avatar" loading="lazy">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end user-dropdown" aria-labelledby="userMenu">
                            <li class="dropdown-header-compact">
                                <img src="<?php echo $avatar; ?>" alt="Avatar" class="user-avatar-compact">
                                <div class="user-details-compact">
                                    <div class="user-name-compact"><?php echo $nombre . " " . $apellido; ?></div>
                                    <div class="user-email-compact"><?php echo $correo; ?></div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider-compact">
                            </li>
                            <li>
                                <a class="dropdown-item-compact" href="/public/perfil.php">
                                    <i class="fas fa-user icon-primary"></i>
                                    <span>Mi perfil</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item-compact" href="/public/mis-pedidos.php">
                                    <i class="fas fa-shopping-bag icon-success"></i>
                                    <span>Mis pedidos</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider-compact">
                            </li>
                            <li>
                                <a class="dropdown-item-compact logout-item" href="/public/login/logout.php">
                                    <i class="fas fa-sign-out-alt icon-danger"></i>
                                    <span>Cerrar sesión</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <!-- Usuario no autenticado -->
                    <a href="/public/login/login.php" class="btn btn-login" aria-label="Iniciar sesión">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        <span>Iniciar sesión</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </nav>
</header>

<style>
/* ===== HEADER / NAVBAR ===== */
header {
    position: sticky;
    top: 0;
    z-index: 1030;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
}

.navbar {
    background-color: #131921 !important;
    padding: 0.75rem 0;
}

/* Logo y nombre de la tienda */
.navbar-brand {
    color: white !important;
    font-weight: 700;
    font-size: 1.45rem;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.navbar-brand:hover {
    opacity: 0.95;
}

.navbar-brand img {
    object-fit: contain;
    margin-right: 8px;
}

/* Enlaces del menú */
.nav-link {
    color: #cccccc !important;
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
}

.nav-link:hover,
.nav-link:focus {
    color: #FFD814 !important;
    background-color: rgba(255, 216, 20, 0.12) !important;
    transform: none;
}

.nav-link i {
    width: 20px;
    text-align: center;
    font-size: 0.95rem;
}

/* Botón del carrito */
.btn-cart {
    position: relative;
    background-color: transparent !important;
    border: 1px solid #374151 !important;
    color: white !important;
    padding: 0.45rem 1rem !important;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.25s ease;
}

.btn-cart:hover {
    background-color: rgba(255, 216, 20, 0.18) !important;
    border-color: #FFD814 !important;
    color: #FFD814 !important;
    transform: translateY(-1px);
}

.btn-cart i {
    font-size: 1.1rem;
}

/* Badge del carrito (círculo rojo con número) */
.badge-cart {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #B12704;
    color: white;
    font-size: 0.75rem;
    font-weight: 700;
    min-width: 19px;
    height: 19px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 2px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    font-family: Arial, sans-serif;
}

/* Botón de login para invitados */
.btn-login {
    background-color: transparent !important;
    border: 1px solid #374151 !important;
    color: white !important;
    padding: 0.45rem 1rem !important;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.25s ease;
    font-size: 0.95rem;
}

.btn-login:hover {
    background-color: rgba(255, 216, 20, 0.18) !important;
    border-color: #FFD814 !important;
    color: #FFD814 !important;
}

/* Avatar del usuario */
.user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid transparent;
    transition: border-color 0.2s, transform 0.2s;
}

.btn-user {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    padding: 0 !important;
    border-radius: 50% !important;
    background: transparent !important;
    border: 1px solid #374151 !important;
    transition: all 0.2s ease;
}

.btn-user:hover .user-avatar {
    border-color: #FFD814;
    transform: scale(1.05);
}

/* Dropdown de usuario */
.user-dropdown {
    background-color: #1f2937 !important;
    border: 1px solid #374151 !important;
    border-radius: 10px !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35) !important;
    min-width: 280px !important;
    padding: 0 !important;
    margin-top: 8px !important;
    font-size: 0.95rem;
}

.dropdown-header-compact {
    display: flex;
    align-items: center;
    padding: 16px !important;
    background-color: #111827 !important;
    border-bottom: 1px solid #374151 !important;
}

.user-avatar-compact {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 14px;
}

.user-details-compact {
    color: white;
}

.user-name-compact {
    font-weight: 600;
    font-size: 1rem;
    color: #f9fafb;
    margin-bottom: 4px;
}

.user-email-compact {
    font-size: 0.85rem;
    color: #9ca3af;
    word-break: break-word;
}

.dropdown-divider-compact {
    margin: 8px 0 !important;
    border-color: #374151 !important;
}

.dropdown-item-compact {
    display: flex;
    align-items: center;
    padding: 11px 18px !important;
    color: #e5e7eb !important;
    transition: background-color 0.2s, color 0.2s;
    gap: 10px;
}

.dropdown-item-compact:hover {
    background-color: #374151 !important;
    color: white !important;
}

.dropdown-item-compact i {
    width: 22px;
    text-align: center;
    font-size: 1rem;
}

.icon-primary {
    color: #60a5fa;
}

.icon-success {
    color: #34d399;
}

.icon-danger {
    color: #f87171;
}

.logout-item:hover i {
    color: #f87171 !important;
}

/* Toggler en móvil */
.navbar-toggler {
    border: 1px solid #4b5563;
    padding: 0.25rem;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.75%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

/* Ajustes responsivos */
@media (max-width: 991px) {
    .navbar-nav.mx-auto {
        margin-top: 16px;
    }

    /* Ocultar texto en botones en móviles */
    .btn-cart span.d-none.d-md-inline,
    .btn-login span {
        display: none !important;
    }

    .btn-cart,
    .btn-login {
        padding: 0.45rem !important;
    }

    .btn-cart i,
    .btn-login i {
        margin-right: 0 !important;
    }
}
</style>