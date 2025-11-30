<?php
session_start();
include '../config/connection.php';

// Verificar si el carrito está vacío
if (empty($_SESSION['carrito'])) {
    header('Location: /public/carrito.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = null; // Inicializar como null
    $transaccionIniciada = false; // Bandera para controlar transacciones
    
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=comercio_electronico", "root", "informatica");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->beginTransaction();
        $transaccionIniciada = true; // Marcar que la transacción se inició

        // Verificar stock antes de procesar la compra
        foreach ($_SESSION['carrito'] as $item) {
            $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id = ?");
            $stmt->execute([$item['id']]);
            $stock_actual = $stmt->fetchColumn();

            if ($stock_actual < $item['cantidad']) {
                throw new Exception("Stock insuficiente para el producto: " . $item['nombre']);
            }
        }

        // Insertar cliente
        $stmt = $pdo->prepare("INSERT INTO Clientes (nombre, email, telefono, direccion) 
                              VALUES (:nombre, :email, :telefono, :direccion)");
        $stmt->execute([
            ':nombre' => $_POST['nombre'],
            ':email' => $_POST['email'],
            ':telefono' => $_POST['telefono'],
            ':direccion' => $_POST['direccion']
        ]);
        $cliente_id = $pdo->lastInsertId();

        // Calcular total del carrito
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        // Insertar venta
        $stmt = $pdo->prepare("INSERT INTO Ventas (cliente_id, id_producto, cantidad, precio_total, fecha) 
                              VALUES (:cliente_id, :id_producto, :cantidad, :precio_total, NOW())");
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':id_producto' => array_values($_SESSION['carrito'])[0]['id'],
            ':cantidad' => array_values($_SESSION['carrito'])[0]['cantidad'],
            ':precio_total' => $total
        ]);
        $venta_id = $pdo->lastInsertId();

        // Insertar pedido
        $stmt = $pdo->prepare("INSERT INTO Pedidos (id_cliente, venta_id, estado, fecha) 
                              VALUES (:cliente_id, :venta_id, 'pendiente', NOW())");
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':venta_id' => $venta_id
        ]);
        $pedido_id = $pdo->lastInsertId();

        // Insertar detalles del pedido
        $stmt = $pdo->prepare("INSERT INTO Detalles_Pedido (id_pedido, id_producto, cantidad) 
                              VALUES (:id_pedido, :id_producto, :cantidad)");
        foreach ($_SESSION['carrito'] as $item) {
            $stmt->execute([
                ':id_pedido' => $pedido_id,
                ':id_producto' => $item['id'],
                ':cantidad' => $item['cantidad'],
                ':precio' => $item['precio']
            ]);
        }

        // Insertar pago
        $metodo_pago = $_POST['metodo_pago'];
        $tipo_tarjeta = '';

        if ($metodo_pago === 'paypal') {
            $tipo_tarjeta = $_POST['tipo_paypal'];
        } else {
            $tipo_tarjeta = $_POST['tipo_tarjeta'];
        }

        $stmt = $pdo->prepare("INSERT INTO pagos (id_venta, metodo_pago, tipo_tarjeta, numero_cuenta, monto, estado_pago, fecha_pago) 
                              VALUES (:id_venta, :metodo_pago, :tipo_tarjeta, :numero_cuenta, :monto, 'pendiente', NOW())");
        $stmt->execute([
            ':id_venta' => $venta_id,
            ':metodo_pago' => $metodo_pago,
            ':tipo_tarjeta' => $tipo_tarjeta,
            ':numero_cuenta' => $_POST['numero_cuenta'],
            ':monto' => $total
        ]);

        // Insertar detalles de entrega
        $stmt = $pdo->prepare("INSERT INTO Entregas (id_venta, metodo_entrega, fecha_entrega, hora_entrega, tipo_envio, estado_entrega) 
                              VALUES (:id_venta, :metodo_entrega, :fecha_entrega, :hora_entrega, :tipo_envio, 'pendiente')");
        $stmt->execute([
            ':id_venta' => $venta_id,
            ':metodo_entrega' => $_POST['metodo_entrega'],
            ':fecha_entrega' => $_POST['fecha_entrega'],
            ':hora_entrega' => $_POST['hora_entrega'],
            ':tipo_envio' => $_POST['tipo_envio']
        ]);

        // Actualizar stock de productos
        $stmt = $pdo->prepare("UPDATE Productos SET stock = stock - :cantidad WHERE id = :id_producto");
        foreach ($_SESSION['carrito'] as $item) {
            $stmt->execute([
                ':cantidad' => $item['cantidad'],
                ':id_producto' => $item['id']
            ]);
        }

        $pdo->commit();

        // Vaciar el carrito y redirigir al usuario
        unset($_SESSION['carrito']);
        header('Location: /public/home_product.php?success=compra_exitosa');
        exit;

    } catch (Exception $e) {
        // SOLUCIÓN: Verificar que $pdo no sea null y que la transacción se haya iniciado
        if ($transaccionIniciada && $pdo !== null) {
            try {
                $pdo->rollBack();
            } catch (Exception $rollbackEx) {
                // Log del error de rollback pero no interrumpir
                error_log("Error en rollback: " . $rollbackEx->getMessage());
            }
        }
        
        // Log del error principal
        error_log("Error en procesamiento de orden: " . $e->getMessage());
        
        header('Location: /public/carrito.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}
?>