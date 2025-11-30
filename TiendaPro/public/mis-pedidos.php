<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /public/login/login.php");
    exit();
}

$id_cliente = $_SESSION['usuario_id'];

// Solo obtenemos datos de PEDIDOS (sin JOIN con ventas si no sabemos su estructura)
$sql = "
    SELECT 
        id_pedido,
        fecha AS fecha_pedido,
        estado
    FROM pedidos
    WHERE id_cliente = ?
    ORDER BY fecha DESC
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la consulta de pedidos: " . $conn->error);
}
$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

$pedidos = [];
while ($pedido = $result->fetch_assoc()) {
    // Obtener productos y calcular total
    $sql_prod = "
        SELECT 
            dp.cantidad,
            pr.nombre,
            pr.precio,
            pr.imagen
        FROM detalles_pedido dp
        INNER JOIN productos pr ON dp.id_producto = pr.id
        WHERE dp.id_pedido = ?
    ";
    $stmt_prod = $conn->prepare($sql_prod);
    $total_pedido = 0;
    $productos = [];
    
    if ($stmt_prod) {
        $stmt_prod->bind_param('i', $pedido['id_pedido']);
        $stmt_prod->execute();
        $result_prod = $stmt_prod->get_result();
        
        while ($prod = $result_prod->fetch_assoc()) {
            $subtotal = $prod['cantidad'] * $prod['precio'];
            $total_pedido += $subtotal;
            $productos[] = $prod;
        }
        $stmt_prod->close();
    }

    // Ahora obtenemos datos de ENTREGA (si existen)
    $sql_entrega = "
        SELECT metodo_entrega, fecha_entrega, hora_entrega, tipo_envio
        FROM entregas e
        INNER JOIN ventas v ON e.id_venta = v.id
        INNER JOIN pedidos p ON v.id = p.venta_id
        WHERE p.id_pedido = ?
    ";
    $stmt_ent = $conn->prepare($sql_entrega);
    $entrega = null;
    if ($stmt_ent) {
        $stmt_ent->bind_param('i', $pedido['id_pedido']);
        $stmt_ent->execute();
        $result_ent = $stmt_ent->get_result();
        $entrega = $result_ent->fetch_assoc();
        $stmt_ent->close();
    }

    $pedido['productos'] = $productos;
    $pedido['total'] = $total_pedido;
    $pedido['metodo_entrega'] = $entrega['metodo_entrega'] ?? null;
    $pedido['fecha_entrega'] = $entrega['fecha_entrega'] ?? null;
    $pedido['hora_entrega'] = $entrega['hora_entrega'] ?? null;
    $pedido['tipo_envio'] = $entrega['tipo_envio'] ?? null;
    $pedido['metodo_pago'] = null; // No lo mostramos hasta saber su ubicación

    $pedidos[] = $pedido;
}
$stmt->close();
$conn->close();
?>

<!-- HTML Y CSS IGUAL -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - N.A.E.I Market</title>
    <link rel="shortcut icon" href="/assets/img/logo/nae.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .header-pedidos {
            background: linear-gradient(135deg, var(--dark) 0%, #232f3e 100%);
            color: white;
            padding: 50px 0;
            text-align: center;
            margin-bottom: 40px;
        }
        .order-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: none;
            margin-bottom: 24px;
            transition: transform 0.2s;
        }
        .order-card:hover {
            transform: translateY(-3px);
        }
        .order-header {
            background-color: white;
            padding: 18px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .order-status {
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .status-pendiente { background-color: #fff3cd; color: #856404; }
        .status-completado { background-color: #d1e7dd; color: #0f5132; }
        .status-cancelado { background-color: #f8d7da; color: #721c24; }
        .product-item {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 16px;
            background: #f8f9fa;
        }
        .product-info {
            flex: 1;
        }
        .product-name {
            font-weight: 600;
            color: #212529;
        }
        .product-details {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .order-footer {
            background-color: #f8f9fa;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .total-badge {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }
        .empty-orders {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .empty-orders i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #e9ecef;
        }
    </style>
</head>
<body>
    <?php include '../src/components/header.php'; ?>

    <div class="header-pedidos">
        <h1><i class="fas fa-shopping-bag me-2"></i>Mis Pedidos</h1>
        <p class="lead">Historial de tus compras en N.A.E.I Market</p>
    </div>

    <div class="container">
        <?php if (empty($pedidos)): ?>
            <div class="empty-orders">
                <i class="fas fa-box-open"></i>
                <h3>No tienes pedidos aún</h3>
                <p>¡Compra tus primeros productos y aparecerán aquí!</p>
                <a href="/public/home_product.php" class="btn btn-primary mt-3">
                    <i class="fas fa-shopping-cart me-2"></i>Ir a la tienda
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="card order-card">
                    <div class="order-header">
                        <div>
                            <h5 class="mb-1">Pedido #<?php echo htmlspecialchars($pedido['id_pedido']); ?></h5>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                <?php echo date('d M Y', strtotime($pedido['fecha_pedido'])); ?>
                            </small>
                        </div>
                        <span class="order-status status-<?php echo htmlspecialchars($pedido['estado']); ?>">
                            <?php echo ucfirst(htmlspecialchars($pedido['estado'])); ?>
                        </span>
                    </div>

                    <div class="card-body">
                        <!-- Método de pago se omite hasta conocer su ubicación -->

                        <?php if (!empty($pedido['metodo_entrega'])): ?>
                        <div class="mb-2">
                            <strong>Entrega:</strong> 
                            <span><?php echo htmlspecialchars($pedido['metodo_entrega']); ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($pedido['fecha_entrega'])): ?>
                        <div class="mb-3">
                            <strong>Fecha de entrega:</strong> 
                            <span>
                                <?php echo date('d M Y', strtotime($pedido['fecha_entrega'])); ?>
                                <?php if (!empty($pedido['hora_entrega'])): ?>
                                    a las <?php echo date('H:i', strtotime($pedido['hora_entrega'])); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php endif; ?>

                        <h6 class="mt-3">Productos:</h6>
                        <?php if (!empty($pedido['productos'])): ?>
                            <?php foreach ($pedido['productos'] as $prod): ?>
                                <div class="product-item">
                                    <img src="<?php echo !empty($prod['imagen']) ? htmlspecialchars($prod['imagen']) : '/assets/img/placeholder.png'; ?>" 
                                         alt="<?php echo htmlspecialchars($prod['nombre']); ?>" 
                                         class="product-img"
                                         onerror="this.src='/assets/img/placeholder.png'">
                                    <div class="product-info">
                                        <div class="product-name"><?php echo htmlspecialchars($prod['nombre']); ?></div>
                                        <div class="product-details">
                                            Cantidad: <?php echo $prod['cantidad']; ?> × 
                                            $<?php echo number_format($prod['precio'], 2); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No se encontraron productos.</p>
                        <?php endif; ?>
                    </div>

                    <div class="order-footer">
                        <div class="total-badge">
                            Total: $<?php echo number_format($pedido['total'], 2); ?>
                        </div>
                        <button class="btn btn-sm btn-primary" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#detalle-<?php echo $pedido['id_pedido']; ?>">
                            <i class="fas fa-info-circle me-1"></i> Detalles
                        </button>
                    </div>

                    <div class="collapse" id="detalle-<?php echo $pedido['id_pedido']; ?>">
                        <div class="card-body border-top">
                            <p><strong>Estado:</strong> <?php echo ucfirst(htmlspecialchars($pedido['estado'])); ?></p>
                            <p><strong>Fecha de pedido:</strong> <?php echo $pedido['fecha_pedido']; ?></p>
                            <?php if (!empty($pedido['tipo_envio'])): ?>
                                <p><strong>Tipo de envío:</strong> <?php echo htmlspecialchars($pedido['tipo_envio']); ?></p>
                            <?php endif; ?>
                            <?php if ($pedido['estado'] === 'completado'): ?>
                                <p class="text-success"><i class="fas fa-check-circle me-1"></i> ¡Gracias por tu compra!</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include '../src/components/footer.html'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>