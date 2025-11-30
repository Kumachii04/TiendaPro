<?php
require '../Controllers/function.php';
require_once '../config/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Consulta para productos
$sql = "SELECT id, nombre, descripcion, precio, stock, categoria_id, imagen FROM productos";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$productos = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

// Consulta para reseñas POSITIVAS
$sql_resenas = "
    SELECT r.id_reseña, r.calificacion, r.comentario, r.fecha_reseña, 
           c.nombre as cliente_nombre, p.nombre as producto_nombre
    FROM reseñas r
    JOIN clientes c ON r.id_cliente = c.id_cliente
    JOIN productos p ON r.id_producto = p.id
    WHERE r.estado = 'activa' AND r.calificacion >= 4
    ORDER BY r.calificacion DESC, r.fecha_reseña DESC 
    LIMIT 3
";

$result_resenas = mysqli_query($conn, $sql_resenas);
$resenas = $result_resenas ? mysqli_fetch_all($result_resenas, MYSQLI_ASSOC) : [];
mysqli_free_result($result_resenas ?? null);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/logo/nae.png">
    <title>NAE Store - Tu Tienda Online</title>
    <link rel="stylesheet" href="/src/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" defer></script>
    <script src="/src/js/script.js" defer></script>
</head>

<body>
    <!-- Spinner de carga -->
    <div class="spinner-overlay" id="spinnerOverlay" style="display: none;">
        <div class="spinner-container">
            <div class="spinner"></div>
            <p class="mb-0">Agregando al carrito...</p>
        </div>
    </div>

    <?php include '../src/components/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="hero-title">Bienvenido NAE Store</h1>
            <p class="hero-subtitle">Descubre nuestra selección de productos de alta calidad</p>
        </div>
    </section>

    <!-- Modal de bienvenida -->
    <?php if (isset($_GET['success']) && $_GET['success'] === 'Login Exito..'): ?>
    <?php include '../src/components/modal_confirmar.php'; ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = new bootstrap.Modal(document.getElementById('welcomeModal'));
        modal.show();
        const url = new URL(window.location);
        url.searchParams.delete('success');
        window.history.replaceState({}, document.title, url);
    });
    </script>
    <?php endif; ?>

    <!-- Modal de pago -->
    <?php if (isset($_GET['true']) && $_GET['true'] === 'Pago confirmado'): ?>
    <?php include '../src/components/modal_confirmar.php'; ?>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = new bootstrap.Modal(document.getElementById('PagoCheck'));
        modal.show();
        setTimeout(() => document.getElementById("formularioPago")?.submit(), 3000);
    });
    </script>
    <?php endif; ?>

    <main id="home-page" class="home-page">
        <div class="container">
            <div class="grid-container">
                <?php if (empty($productos)): ?>
                <div class="alert alert-info" role="alert">
                    No hay productos disponibles en este momento.
                </div>
                <?php else: ?>
                <?php foreach ($productos as $producto): ?>
                <div class="product-card"
                    onclick="window.location.href='/public/details.php?id=<?= $producto['id']; ?>';"
                    style="cursor: pointer;">
                    <div class="product-image-container">
                        <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?= htmlspecialchars($producto['imagen']) ?>"
                            alt="<?= htmlspecialchars($producto['nombre']) ?>" class="product-image"
                            onerror="this.src='/assets/img/placeholder.png';">
                        <?php else: ?>
                        <i class="fas fa-image product-image-placeholder"></i>
                        <?php endif; ?>
                        <div class="product-image-overlay"></div>
                        <span class="stock-badge">
                            <i class="fas fa-box me-1"></i>Stock: <?= (int)$producto['stock'] ?>
                        </span>
                        <span class="category-badge">
                            <i class="fas fa-tag me-1"></i><?= htmlspecialchars($producto['categoria_id']) ?>
                        </span>
                    </div>
                    <div class="product-info">
                        <h5 class="product-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                        <p class="product-description">
                            <?= htmlspecialchars(mb_substr($producto['descripcion'], 0, 80)) ?>...</p>
                        <div class="product-price">$<?= number_format($producto['precio'], 2) ?></div>
                        <div class="product-actions">
                            <button type="button" class="btn btn-buy" data-product='<?= json_encode([
                                        'id' => $producto['id'],
                                        'nombre' => $producto['nombre'],
                                        'precio' => $producto['precio'],
                                        'descripcion' => $producto['descripcion'],
                                        'stock' => $producto['stock'],
                                        'categoria_id' => $producto['categoria_id'],
                                        'imagen' => $producto['imagen']
                                    ]) ?>'>
                                <i class="fas fa-shopping-cart me-1"></i>Comprar
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Sección de Opiniones -->
    <section class="reviews-section">
        <div class="container">
            <h2 class="section-title">Opiniones de Nuestros Clientes</h2>
            <p class="section-subtitle">Las experiencias positivas de nuestros clientes satisfechos</p>

            <?php if (empty($resenas)): ?>
            <div class="alert alert-info text-center" role="alert">
                <i class="fas fa-comments me-2"></i>
                Aún no hay reseñas positivas. ¡Sé el primero en opinar!
            </div>
            <?php else: ?>
            <div class="reviews-grid">
                <?php foreach ($resenas as $resena): ?>
                <div class="review-card">
                    <div class="positive-badge">
                        <i class="fas fa-thumbs-up"></i> Opinión Positiva
                    </div>
                    <div class="review-header">
                        <div class="review-client">
                            <i class="fas fa-user me-2"></i><?= htmlspecialchars($resena['cliente_nombre']) ?>
                        </div>
                        <div class="review-product">
                            <i class="fas fa-shopping-bag me-2"></i><?= htmlspecialchars($resena['producto_nombre']) ?>
                        </div>
                    </div>
                    <div class="review-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star<?= $i <= $resena['calificacion'] ? '' : '-o' ?>"></i>
                        <?php endfor; ?>
                        <span class="ms-2">(<?= $resena['calificacion'] ?>/5)</span>
                    </div>
                    <div class="review-comment">
                        "<?= htmlspecialchars($resena['comentario']) ?>"
                    </div>
                    <div class="review-date">
                        <i class="far fa-clock me-1"></i>
                        <?= date('d M Y', strtotime($resena['fecha_reseña'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php mysqli_close($conn); ?>
    <?php include '../src/components/footer.html'; ?>

    <script>
    document.querySelectorAll('.btn-buy').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Evita que el clic en el botón active la redirección de la tarjeta
            const productData = JSON.parse(this.dataset.product);
            addToCartFromButton(productData);
        });
    });

    function addToCartFromButton(product) {
        // Mostrar spinner
        document.getElementById('spinnerOverlay').style.display = 'flex';

        const formData = new FormData();
        Object.entries(product).forEach(([key, value]) => {
            formData.append(key, value);
        });
        formData.append('BtnAccion', 'Agregar');

        fetch('/Controllers/cart_control.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('spinnerOverlay').style.display = 'none';

                const toastStyle = {
                    borderRadius: "10px",
                    padding: "15px 25px",
                    fontSize: "1.1rem",
                    fontWeight: "500",
                    boxShadow: "0 5px 15px rgba(0,0,0,0.2)"
                };

                if (data.success) {
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            ...toastStyle,
                            background: "linear-gradient(45deg, #2ecc71, #27ae60)"
                        }
                    }).showToast();

                    const cartCount = document.getElementById('num_cont');
                    if (cartCount) {
                        cartCount.textContent = parseInt(cartCount.textContent || '0') + 1;
                    }

                    setTimeout(() => {
                        window.location.href = '/public/carrito.php';
                    }, 1500);
                } else {
                    Toastify({
                        text: data.message || "Error al agregar al carrito",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            ...toastStyle,
                            background: "linear-gradient(45deg, #e74c3c, #c0392b)"
                        }
                    }).showToast();
                }
            })
            .catch(() => {
                document.getElementById('spinnerOverlay').style.display = 'none';
                Toastify({
                    text: "Error de conexión al agregar al carrito",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(45deg, #e74c3c, #c0392b)",
                        borderRadius: "10px",
                        padding: "15px 25px",
                        fontSize: "1.1rem",
                        fontWeight: "500",
                        boxShadow: "0 5px 15px rgba(0,0,0,0.2)"
                    }
                }).showToast();
            });
    }
    </script>
</body>

</html>