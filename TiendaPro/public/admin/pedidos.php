<?php
session_start();
include_once '../../config/connection.php';


if (!isset($_SESSION['usuario_id'])) {
    header("Location: /public/login/login.php");
    exit();
}

// Validación de rol admin
if ($_SESSION['rol'] !== 'admin') {
    header("Location: /public/admin/dashboard.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT 
        Pedidos.id_pedido, 
        Clientes.nombre AS nombre_cliente, 
        Clientes.email AS email_cliente,
        Clientes.telefono AS telefono_cliente, 
        Clientes.direccion AS direccion_cliente,
        Ventas.precio_total AS total_venta, 
        Pedidos.fecha, 
        Pedidos.estado 
    FROM Pedidos
    LEFT JOIN Clientes ON Pedidos.id_cliente = Clientes.id_cliente
    LEFT JOIN Ventas ON Pedidos.venta_id = Ventas.id
");

if ($stmt && $stmt->execute()) {
    $result = $stmt->get_result();
    $pedidos = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error en la consulta: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/src/css/styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Lista de Pedidos</title>
</head>

<body>
    <div class="container">
        <header>
            <h1>Lista de Pedidos</h1>
            <nav>
                <ul>
                    <li><a href="/public/admin/dashboard.php"><i class="fas fa-home bg-dark"></i> Dashboard</a>
                    </li>
                    <li><a href="/public/login/logout.php"><i class="fas fa-sign-out-alt bg-dark"></i> Cerrar
                            sesión</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="description">
                <h2>Descripción</h2>
                <p>Esta sección muestra todos los pedidos realizados, junto con el nombre del cliente y el total de la
                    venta asociada a cada pedido.</p>
            </section>

            <section class="pedido-list">
                <h2>Pedidos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Nombre Cliente</th>
                            <th>Email Cliente</th>
                            <th>Teléfono Cliente</th>
                            <th>Dirección Cliente</th>
                            <th>Total Venta</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos)): ?>
                        <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['id_pedido']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['nombre_cliente']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['email_cliente']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['telefono_cliente']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['direccion_cliente']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['total_venta']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9">No hay pedidos para mostrar.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>