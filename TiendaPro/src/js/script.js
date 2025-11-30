// ===== UTILIDADES =====
function showSpinner() {
  // Evitar múltiples spinners
  hideSpinner();

  const spinner = document.createElement('div');
  spinner.id = 'spinnerOverlay';
  spinner.className = 'spinner-overlay';
  spinner.innerHTML = `
    <div class="spinner-container">
      <div class="spinner"></div>
      <p class="mb-0">Procesando...</p>
    </div>
  `;
  document.body.appendChild(spinner);
}

function hideSpinner() {
  const spinner = document.getElementById('spinnerOverlay');
  if (spinner) spinner.remove();
}

// ===== NOTIFICACIONES =====
function showToast(message, type = 'success', position = 'right') {
  const colors = {
    success: "linear-gradient(to right, #2ecc71, #27ae60)",
    error: "linear-gradient(to right, #e74c3c, #c0392b)",
    info: "linear-gradient(to right, #3498db, #2980b9)",
    warning: "linear-gradient(to right, #f39c12, #d35400)"
  };

  Toastify({
    text: message,
    duration: 2800,
    close: true,
    gravity: "top",
    position: position,
    style: {
      background: colors[type] || colors.info,
      borderRadius: "10px",
      padding: "16px 24px",
      fontSize: "1rem",
      fontWeight: "500",
      boxShadow: "0 4px 12px rgba(0,0,0,0.2)",
      backdropFilter: "blur(4px)",
      color: "white",
      maxWidth: "350px"
    },
    className: "custom-toast"
  }).showToast();
}

// ===== FUNCIONES ESPECÍFICAS =====

function NotificacionEliminar() {
  showToast("Producto eliminado del carrito", "error", "right");
}

function confirmarVaciadoCarrito() {
  const modal = new bootstrap.Modal(document.getElementById('modalConfirmarVaciado'));
  modal.show();
}

function vaciarCarrito() {
  showSpinner();

  fetch('/Controllers/cart_control.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'action=vaciar'
  })
  .then(response => response.json())
  .then(data => {
    hideSpinner();
    if (data.success) {
      showToast("Carrito vaciado exitosamente", "success", "right");
      setTimeout(() => location.reload(), 1000);
    } else {
      showToast(data.message || "Error al vaciar el carrito", "error", "right");
    }
  })
  .catch(() => {
    hideSpinner();
    showToast("Error de conexión. Intenta nuevamente.", "error", "right");
  });
}

// ===== AGREGAR AL CARRITO (desde formulario) =====
function addToCart(event) {
  event.preventDefault();
  const form = event.target;

  showSpinner();

  const formData = new FormData(form);

  fetch(form.action, {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    hideSpinner();
    if (data.success) {
      showToast("Producto añadido al carrito", "success", "left");

      // Actualizar contador del carrito si existe
      const cartCount = document.getElementById('num_cont');
      if (cartCount) {
        cartCount.textContent = parseInt(cartCount.textContent || '0') + 1;
      }

      // Redirigir suavemente
      setTimeout(() => {
        window.location.href = '/public/carrito.php';
      }, 1500);
    } else {
      showToast(data.message || "No se pudo agregar el producto", "error", "left");
    }
  })
  .catch(() => {
    hideSpinner();
    showToast("Error de red. Verifica tu conexión.", "error", "left");
  });
}
