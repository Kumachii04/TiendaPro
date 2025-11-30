<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../config/connection.php';

    try {
        // Acción: vaciar carrito
        if (isset($_POST['action']) && $_POST['action'] === 'vaciar') {
            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                // Restaurar stock de cada producto en el carrito
                $stmt = $conn->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
                foreach ($_SESSION['carrito'] as $item) {
                    // Asegurar tipos para bind_param
                    $cantidad = (int)($item['cantidad'] ?? 0);
                    $id = (int)($item['id'] ?? 0);
                    if ($cantidad > 0 && $id > 0) {
                        $stmt->bind_param("ii", $cantidad, $id);
                        $stmt->execute();
                    }
                }
                $stmt->close();
            }

            unset($_SESSION['carrito']);
            unset($_SESSION['total_carrito']);

            echo json_encode(['success' => true, 'message' => 'Carrito vaciado exitosamente']);
            exit();
        }

        // Validar que el ID sea numérico y positivo
        if (!isset($_POST['id']) || !is_numeric($_POST['id']) || (int)$_POST['id'] <= 0) {
            throw new Exception('ID de producto inválido');
        }

        $producto_id = (int)$_POST['id'];

        // Obtener datos reales del producto desde la base de datos (¡no confiar en POST!)
        $stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto_db = $result->fetch_assoc();

        if (!$producto_db) {
            throw new Exception('Producto no encontrado');
        }

        if ($producto_db['stock'] <= 0) {
            throw new Exception('Producto sin stock disponible');
        }

        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        if (!isset($_SESSION['total_carrito'])) {
            $_SESSION['total_carrito'] = 0;
        }

        // Buscar si el producto ya está en el carrito
        $producto_existe = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ((int)$item['id'] === $producto_id) {
                // Verificar si hay stock suficiente para incrementar
                if ($item['cantidad'] < $producto_db['stock']) {
                    $item['cantidad']++;
                    $_SESSION['total_carrito']++;
                    $producto_existe = true;
                } else {
                    throw new Exception('Stock insuficiente para agregar más unidades');
                }
                break;
            }
        }

        // Si no existe en el carrito, agregarlo
        if (!$producto_existe) {
            // Obtener datos completos del producto desde la base de datos
            $stmt_full = $conn->prepare("SELECT id, nombre, precio, descripcion, stock, categoria_id, imagen FROM productos WHERE id = ?");
            $stmt_full->bind_param("i", $producto_id);
            $stmt_full->execute();
            $producto_full = $stmt_full->get_result()->fetch_assoc();

            if (!$producto_full) {
                throw new Exception('Producto no disponible');
            }

            $nuevo_item = [
                'id' => (int)$producto_full['id'],
                'nombre' => htmlspecialchars($producto_full['nombre'], ENT_QUOTES, 'UTF-8'),
                'precio' => (float)$producto_full['precio'],
                'descripcion' => htmlspecialchars($producto_full['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'),
                'stock' => (int)$producto_full['stock'],
                'categoria_id' => $producto_full['categoria_id'] ?? '',
                'imagen' => htmlspecialchars($producto_full['imagen'] ?? '', ENT_QUOTES, 'UTF-8'),
                'cantidad' => 1
            ];

            $_SESSION['carrito'][] = $nuevo_item;
            $_SESSION['total_carrito']++;
        }

        // Actualizar stock en la base de datos (solo -1, ya validado)
        $stmt_update = $conn->prepare("UPDATE productos SET stock = stock - 1 WHERE id = ?");
        $stmt_update->bind_param("i", $producto_id);
        $stmt_update->execute();
        $stmt_update->close();

        echo json_encode([
            'success' => true,
            'message' => 'Producto agregado al carrito exitosamente',
            'total_carrito' => $_SESSION['total_carrito']
        ]);

    } catch (Exception $e) {
        // Registrar error en logs (opcional pero recomendado)
        error_log("Error en carrito: " . $e->getMessage());

        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

    exit();
} else {
    header("Location: /public/home_product.php");
    exit();
}