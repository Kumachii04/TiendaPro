<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proceso de Pago</title>
    <link rel="stylesheet" href="/src/css/check.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/src/js/script.js"></script>
    <script>
    function togglePaymentOptions() {
        const metodoPago = document.getElementById('metodo_pago').value;
        const tarjetaOptions = document.getElementById('tipo_tarjeta');
        const paypalOptions = document.getElementById('tipo_paypal');

        tarjetaOptions.classList.add('hidden');
        paypalOptions.classList.add('hidden');

        if (metodoPago === 'tarjeta') {
            tarjetaOptions.classList.remove('hidden');
        } else if (metodoPago === 'paypal') {
            paypalOptions.classList.remove('hidden');
        }
    }
    </script>
</head>

<body>
    <!-- Spinner de carga -->
    <div class="spinner-overlay" id="spinnerOverlay">
        <div class="spinner-container">
            <div class="spinner"></div>
            <p class="mb-0">Procesando tu compra...</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout-form">
                    <h2 class="mb-4">Información de Pago</h2>

                    <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                    <?php endif; ?>

                    <form action="/Controllers/orden_control.php" method="POST" onsubmit="return validarFormulario()">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre completo</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="metodo_pago" class="form-label">Método de Pago</label>
                            <select class="form-control" id="metodo_pago" name="metodo_pago"
                                onchange="togglePaymentOptions()" required>
                                <option value="">Seleccione un método de pago</option>
                                <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>

                        <div id="tipo_tarjeta" class="mb-3 hidden">
                            <label for="tipo_tarjeta" class="form-label">Tipo de Tarjeta</label>
                            <select class="form-control" name="tipo_tarjeta">
                                <option value="visa">Visa</option>
                                <option value="mastercard">Mastercard</option>
                                <option value="amex">American Express</option>
                            </select>
                        </div>

                        <div id="tipo_paypal" class="mb-3 hidden">
                            <label for="tipo_paypal" class="form-label">Tipo de Cuenta PayPal</label>
                            <select class="form-control" name="tipo_paypal">
                                <option value="personal">Personal</option>
                                <option value="business">Business</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="numero_cuenta" class="form-label">Número de Cuenta</label>
                            <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" required>
                        </div>

                        <div class="mb-3">
                            <label for="metodo_entrega" class="form-label">Método de Entrega</label>
                            <select class="form-control" id="metodo_entrega" name="metodo_entrega" required>
                                <option value="envio">Envío a domicilio</option>
                                <option value="recoger">Recoger en tienda</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                                    <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hora_entrega" class="form-label">Hora de Entrega</label>
                                    <input type="time" class="form-control" id="hora_entrega" name="hora_entrega"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_envio" class="form-label">Tipo de Envío</label>
                            <select class="form-control" id="tipo_envio" name="tipo_envio" required>
                                <option value="estandar">Envío Estándar</option>
                                <option value="express">Envío Express</option>
                                <option value="premium">Envío Premium</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Confirmar Compra</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="cart-summary">
                    <h3>Resumen del Carrito</h3>
                    <?php
                    $total = 0;
                    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                        foreach ($_SESSION['carrito'] as $item) {
                            $subtotal = $item['precio'] * $item['cantidad'];
                            $total += $subtotal;
                    ?>
                    <div class="cart-item">
                        <span><?php echo htmlspecialchars($item['nombre']); ?> x <?php echo $item['cantidad']; ?></span>
                        <span>$<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <div class="cart-total">
                        Total: $<?php echo number_format($total, 2); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePaymentOptions() {
        const metodoPago = document.getElementById('metodo_pago').value;
        const tarjetaOptions = document.getElementById('tipo_tarjeta');
        const paypalOptions = document.getElementById('tipo_paypal');

        tarjetaOptions.classList.add('hidden');
        paypalOptions.classList.add('hidden');

        if (metodoPago === 'tarjeta') {
            tarjetaOptions.classList.remove('hidden');
        } else if (metodoPago === 'paypal') {
            paypalOptions.classList.remove('hidden');
        }
    }

    function validarFormulario() {
        // Mostrar spinner
        document.getElementById('spinnerOverlay').style.display = 'flex';

        // Validar fecha de entrega
        const fechaEntrega = new Date(document.getElementById('fecha_entrega').value);
        const hoy = new Date();
        if (fechaEntrega < hoy) {
            alert('La fecha de entrega debe ser posterior a hoy');
            document.getElementById('spinnerOverlay').style.display = 'none';
            return false;
        }

        // Validar número de cuenta
        const numeroCuenta = document.getElementById('numero_cuenta').value;
        const metodoPago = document.getElementById('metodo_pago').value;

        if (metodoPago === 'tarjeta') {
            if (!/^\d{16}$/.test(numeroCuenta)) {
                alert('El número de tarjeta debe tener 16 dígitos');
                document.getElementById('spinnerOverlay').style.display = 'none';
                return false;
            }
        } else if (metodoPago === 'paypal') {
            if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(numeroCuenta)) {
                alert('Por favor, ingrese un email válido para PayPal');
                document.getElementById('spinnerOverlay').style.display = 'none';
                return false;
            }
        }

        return true;
    }
    </script>
</body>

</html>