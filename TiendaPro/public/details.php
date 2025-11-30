<?php
require_once '../Controllers/function.php';
require_once '../config/connection.php';
session_start();
// Obtenemos el ID del producto desde la URL
$id_producto = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id_producto === null) {
    echo "No se ha proporcionado un ID válido.";
    exit();
}

// Consulta SQL optimizada con JOIN para obtener la categoría en una sola consulta
$sql = "SELECT p.id, p.nombre, p.descripcion, p.descripcion_larga, p.precio, p.stock, p.categoria_id, p.imagen, c.nombre AS categoria_nombre 
        FROM productos p 
        LEFT JOIN categorias c ON p.categoria_id = c.id 
        WHERE p.id = ?";

$total_ventas = 0;

// Datos simulados del vendedor (puedes conectarlos a una tabla de vendedores más adelante)
$vendedor = [
    'nombre' => 'TechStore Pro',
    'porcentaje_recomendacion' => 98,
    'tiempo_vendiendo' => 1, // años
    'total_ventas' => $total_ventas > 0 ? $total_ventas : 1275, // Usa ventas reales o valor por defecto
    'calificacion_promedio' => 4.8, // Calificación promedio (puede venir de una tabla de reviews)
    'calificaciones_detalle' => [
        'calidad' => 4.9,
        'precio' => 4.6,
        'entrega' => 4.8,
        'atencion' => 4.9,
        'valor' => 4.7
    ],
    'total_resenas' => rand(50, 200)
];

// Añadimos manejo de errores para la preparación
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("i", $id_producto);

// Ejecutamos la consulta con manejo de errores
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}

$result = $stmt->get_result();
$producto = $result->fetch_assoc();

// Verificamos si se encontró el producto
if (!$producto) {
    die("No se encontró el producto especificado.");
}

// Cerramos el statement y la conexión
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/img/logo/users-alt (1).png">
    <title>Detalles del Producto - N.A.E.I Market</title>
    <link rel="stylesheet" href="/src/css/datalles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amazon+Ember:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="/src/js/script.js"></script>
</head>

<body>
    <!-- Spinner de carga -->
    <div class="spinner-overlay" id="spinnerOverlay">
        <div class="spinner-container">
            <div class="spinner"></div>
            <p class="mb-0">Agregando al carrito...</p>
        </div>
    </div>

    <?php include '../src/components/header.php'; ?>

    <main id="details" class="details-content">
        <div class="container-detall">
            <section class="py-5 content-main">
                <div class="row gx-4 gx-lg-5 align-items-center ">
                    <div class="col-md-6">
                        <div class="product-image-container">
                            <?php if (!empty($producto['imagen'])): ?>
                            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>"
                                alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="product-image"
                                onerror="this.onerror=null; this.src='/assets/img/placeholder.png';">
                            <?php else: ?>
                            <i class="fas fa-image product-image-placeholder"></i>
                            <?php endif; ?>
                            <div class="product-image-overlay"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-info">
                            <div class="product-category">
                                <i class="fas fa-tag me-2"></i>Categoría:
                                <?php echo htmlspecialchars($producto['categoria_nombre'] ?? 'Sin categoría'); ?>
                            </div>
                            <h1 class="product-title"><?php echo htmlspecialchars($producto['nombre']); ?></h1>

                            <!-- Calificaciones del producto con tooltip -->
                            <div class="product-rating">
                                <div class="rating-stars">
                                    <?php 
                                    $calificacion = $vendedor['calificacion_promedio'];
                                    $estrellas_llenas = floor($calificacion);
                                    $tiene_media = ($calificacion - $estrellas_llenas) >= 0.5;
                                    for ($i = 1; $i <= 5; $i++): 
                                        if ($i <= $estrellas_llenas):
                                    ?>
                                    <i class="fas fa-star star"></i>
                                    <?php elseif ($i == $estrellas_llenas + 1 && $tiene_media): ?>
                                    <i class="fas fa-star-half-alt star"></i>
                                    <?php else: ?>
                                    <i class="far fa-star star empty"></i>
                                    <?php endif; endfor; ?>
                                </div>
                                <span class="rating-text"><?php echo number_format($calificacion, 1); ?>
                                    (<?php echo $vendedor['total_resenas']; ?> reseñas)</span>

                                <!-- Tooltip con desglose de calificaciones -->
                                <div class="rating-tooltip">
                                    <div class="rating-tooltip-header">
                                        <h4 class="rating-tooltip-title">Calificaciones Detalladas</h4>
                                        <div class="rating-tooltip-average">
                                            <span
                                                class="rating-tooltip-average-value"><?php echo number_format($calificacion, 1); ?></span>
                                            <div class="rating-tooltip-average-stars">
                                                <?php 
                                                for ($i = 1; $i <= 5; $i++): 
                                                    if ($i <= $estrellas_llenas):
                                                ?>
                                                <i class="fas fa-star star"></i>
                                                <?php elseif ($i == $estrellas_llenas + 1 && $tiene_media): ?>
                                                <i class="fas fa-star-half-alt star"></i>
                                                <?php else: ?>
                                                <i class="far fa-star star empty"></i>
                                                <?php endif; endfor; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rating-tooltip-details">
                                        <?php 
                                        $categorias_calificaciones = [
                                            'calidad' => ['icon' => 'fa-award', 'label' => 'Calidad'],
                                            'precio' => ['icon' => 'fa-dollar-sign', 'label' => 'Precio'],
                                            'entrega' => ['icon' => 'fa-shipping-fast', 'label' => 'Entrega'],
                                            'atencion' => ['icon' => 'fa-headset', 'label' => 'Atención'],
                                            'valor' => ['icon' => 'fa-star', 'label' => 'Valor']
                                        ];
                                        
                                        foreach ($categorias_calificaciones as $key => $info): 
                                            $valor = $vendedor['calificaciones_detalle'][$key];
                                            $estrellas = floor($valor);
                                            $tiene_media_est = ($valor - $estrellas) >= 0.5;
                                        ?>
                                        <div class="rating-tooltip-item">
                                            <div class="rating-tooltip-item-label">
                                                <i class="fas <?php echo $info['icon']; ?>"></i>
                                                <span><?php echo $info['label']; ?></span>
                                            </div>
                                            <div class="rating-tooltip-item-value">
                                                <div class="rating-tooltip-item-stars">
                                                    <?php for ($j = 1; $j <= 5; $j++): 
                                                            if ($j <= $estrellas):
                                                        ?>
                                                    <i class="fas fa-star star"></i>
                                                    <?php elseif ($j == $estrellas + 1 && $tiene_media_est): ?>
                                                    <i class="fas fa-star-half-alt star"></i>
                                                    <?php else: ?>
                                                    <i class="far fa-star star empty"></i>
                                                    <?php endif; endfor; ?>
                                                </div>
                                                <span
                                                    class="rating-tooltip-item-number"><?php echo number_format($valor, 1); ?></span>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="product-price">
                                $<?php echo number_format($producto['precio'], 2); ?>
                            </div>
                            <div class="product-stock">
                                <i class="fas fa-box me-2"></i>Stock Disponible: <?php echo $producto['stock']; ?>
                            </div>
                            <p class="product-description"><?php echo htmlspecialchars($producto['descripcion']); ?></p>

                            <div class="product-features">
                                <h4 class="mb-3">Características del Producto</h4>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle feature-icon"></i>
                                    <span>Garantía de calidad</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-truck feature-icon"></i>
                                    <span>Envío rápido</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-undo feature-icon"></i>
                                    <span>Devoluciones fáciles</span>
                                </div>
                            </div>

                            <button class="btn btn-add-cart w-100" id="BtnAddCarrito" type="button"
                                onclick="addToCart(event)">
                                <i class="fas fa-shopping-cart me-2"></i>Agregar al carrito
                            </button>


                            <div class="seller-info">
                                <div class="seller-header">
                                    <h3 class="seller-title">
                                        <i class="fas fa-store me-2"></i>Información sobre el vendedor
                                    </h3>
                                    <p class="seller-title">Vendedor: <?php echo $vendedor['nombre']; ?></p>
                                </div>

                                <div class="seller-stats">
                                    <div class="seller-stat">
                                        <div class="seller-stat-value">
                                            <?php echo $vendedor['porcentaje_recomendacion']; ?>%</div>
                                        <div class="seller-stat-label">
                                            <i class="fas fa-thumbs-up"></i>
                                            de compradores lo recomiendan
                                        </div>
                                    </div>

                                    <div class="seller-stat">
                                        <div class="seller-stat-value"><?php echo $vendedor['tiempo_vendiendo']; ?>
                                            año<?php echo $vendedor['tiempo_vendiendo'] > 1 ? 's' : ''; ?></div>
                                        <div class="seller-stat-label">
                                            <i class="fas fa-calendar-alt"></i>
                                            vendiendo en N.A.E.I Market
                                        </div>
                                    </div>

                                    <div class="seller-stat">
                                        <div class="seller-stat-value">
                                            <?php echo number_format($vendedor['total_ventas']); ?></div>
                                        <div class="seller-stat-label">
                                            <i class="fas fa-shopping-bag"></i>
                                            ventas
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
        </div>
        </section>
        </div>

        <!-- Formulario oculto para agregar al carrito -->
        <form id="addCartForm" action="/Controllers/cart_control.php" method="POST" style="display: none;">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
            <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
            <input type="hidden" name="descripcion" value="<?php echo htmlspecialchars($producto['descripcion']); ?>">
            <input type="hidden" name="stock" value="<?php echo $producto['stock']; ?>">
            <input type="hidden" name="categoria_id" value="<?php echo $producto['categoria_id']; ?>">
            <input type="hidden" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>">
        </form>
    </main>

    <script>
    function addToCart(event) {
        event.preventDefault();
        const form = document.getElementById('addCartForm');
        const formData = new FormData(form);

        // Mostrar el spinner
        document.getElementById('spinnerOverlay').style.display = 'flex';

        fetch('/Controllers/cart_control.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Ocultar el spinner
                document.getElementById('spinnerOverlay').style.display = 'none';

                if (data.success) {
                    // Mostrar notificación de éxito
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        className: "custom-toast",
                        style: {
                            background: "linear-gradient(45deg, #2ecc71, #27ae60)",
                            borderRadius: "10px",
                            padding: "15px 25px",
                            fontSize: "1.1rem",
                            fontWeight: "500",
                            boxShadow: "0 5px 15px rgba(0,0,0,0.2)"
                        }
                    }).showToast();

                    // Actualizar el contador del carrito
                    const cartCount = document.getElementById('num_cont');
                    if (cartCount) {
                        cartCount.textContent = parseInt(cartCount.textContent || 0) + 1;
                    }

                    // Redirigir al carrito después de un breve retraso
                    setTimeout(() => {
                        window.location.href = '/public/carrito.php';
                    }, 1500);
                } else {
                    // Mostrar notificación de error
                    Toastify({
                        text: data.message || "Error al agregar el producto al carrito",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        className: "custom-toast",
                        style: {
                            background: "linear-gradient(45deg, #e74c3c, #c0392b)",
                            borderRadius: "10px",
                            padding: "15px 25px",
                            fontSize: "1.1rem",
                            fontWeight: "500",
                            boxShadow: "0 5px 15px rgba(0,0,0,0.2)"
                        }
                    }).showToast();
                }
            })
            .catch(error => {
                // Ocultar el spinner
                document.getElementById('spinnerOverlay').style.display = 'none';

                // Mostrar notificación de error
                Toastify({
                    text: "Error al agregar el producto al carrito",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    className: "custom-toast",
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

    <?php include '../src/components/footer.html'; ?>
</body>

</html>