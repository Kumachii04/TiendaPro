<!-- HTML del Modal de inicio de sesion login-->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="  border-radius: 10px;">
            <div class="modal-header" style="  background-color: #28a745;
    color: white;">
                <h5 class="modal-title" id="welcomeModalLabel">Bienvenido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-success">
                ¡Bienvenido,<strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong>! Has iniciado sesión
                exitosamente. </div>
            <div class="modal-footer" style=" background-color: #f8f9fa;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Error de Sesión al carrito -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-danger" id="errorModalLabel">Error</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-danger">
                Debes iniciar sesión para realizar una compra.
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal de Loader product -->
<div class="modal fade" id="loaderModal" tabindex="-1" aria-labelledby="loaderModal" aria-hidden="true"
    style="background-color:rgba(0, 0, 0, 0.2) ;">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="loader"></span>
        </div>
    </div>
</div>


<!-- Modal de Confirmación de Compra -->
<div class="modal fade" id="confirCompra" tabindex="-2" aria-labelledby="confirModallabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmar Compra</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas confirmar la compra?
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="continuarCompra()">Continuar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación del carrito vaciado -->
<div class="modal fade" id="modalConfirmarVaciado" tabindex="-1" aria-labelledby="modalConfirmarVaciadoLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalConfirmarVaciadoLabel">Confirmar Vaciado de Carrito</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas vaciar todo el carrito?
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="vaciarCarrito()">Confirmar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para editar -->
<div class="modal fade" id="editOrden" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_producto" id="edit-id-producto">
                    <label for="edit-cantidad">Cantidad</label>
                    <input type="number" id="edit-cantidad" name="cantidad" class="form-control mb-3" required>
                    <label for="edit-estado">Estado</label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal para esperar la compra -->
<div class="modal fade" id="errorModalCheck" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="alert modal-header">
                <h1 class="alert-primary text-success" id=" errorModalLabel">Comprando</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75"
                aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 75%"></div>
            </div><span class="sr-only">Loading...</span>
            <div class="col-auto pl-0">
                <p class="m-4"> Será redireccionado en 3 segundos...</p>
            </div>
        </div>
    </div>
</div>

<!-- modal para confirmar el pago -->
<div class="modal fade" id="PagoCheck" tabindex="-1" aria-labelledby="sucecessModaldate" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="alert modal-header">
                <h1 class="alet-primary text-success" id="sucecessModaldate">Exitosamente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- contenido -->
            <div class="modal-body mx-auto text-center">
                <div class="my-3">
                    <!-- Icono de Gancho -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor"
                        class="bi bi-check-circle-fill text-success mx-auto d-block" viewBox="0 0 16 16"
                        style="align-items: center;">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.08.02l4-4a.75.75 0 1 0-1.08-1.04L7.5 9.293 5.525 7.32a.75.75 0 1 0-1.05 1.06l2.5 2.5z" />
                    </svg>
                </div>
                <p class="fs-4 fw-bold text-success">¡Datos registrados con éxito!</p>
            </div>
            <div class="modal-footer justify-content-center bg-light">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>