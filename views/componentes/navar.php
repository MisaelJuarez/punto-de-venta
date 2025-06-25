<link rel="stylesheet" href="<?=CSS."navar.css"?>">
<ul class="nav">
    <div class="d-flex bd-highlight w-100">
        <div class="p-1 flex-grow-1 bd-highlight d-flex justify-content-start">
            <button id="inicio" type="button" class="btn btn-outline-secondary opcion">
                <div>
                    <i class="bi bi-person-circle fs-3"></i>
                    <p>Usuario</p>
                </div>
            </button>
            <button id="caja" type="button" class="btn btn-outline-secondary opcion">
                <div>
                    <i class="bi bi-pc-display-horizontal fs-3"></i>
                    <p>Caja</p>
                </div>
            </button>
            <button id="productos" type="button" class="btn btn-outline-secondary opcion">
                <div>
                    <i class="bi bi-boxes fs-3"></i>
                    <div class="d-flex justify-content-center">
                        <p class="me-2">Productos</p>
                        <span class="badge bg-info text-dark mt-1" id="cantidad-productos">0</span>
                    </div>
                </div>
            </button>
            <button id="comprar" type="button" class="btn btn-outline-secondary opcion">
                <div>
                    <i class="bi bi-cart4 fs-3"></i>
                    <div class="d-flex justify-content-center">
                        <p class="me-2">Compras</p>
                        <div id="contenedor-cantidad">
                        </div>
                    </div>
                </div>
            </button>
            <button id="provedores" type="button" class="btn btn-outline-secondary opcion">
                <div>
                    <i class="bi bi-truck fs-3"></i>
                    <p>Provedores</p>
                </div>
            </button>
            <button id="corte" type="button" class="btn btn-outline-secondary opcion">
                <div>
                    <i class="bi bi-cash-coin fs-3"></i>
                    <p>Corte de caja</p>
                </div>
            </button>
            <button id="detalles" type="button" class="btn btn-outline-secondary opcion">
                <div>
                    <i class="bi bi-journals fs-3"></i>
                    <p>Visualizar datos</p>
                </div>
            </button>
            <button id="cerrar_session" type="button" class="btn btn-danger salir">
                <div>
                    <i class="bi bi-door-open-fill fs-1"></i>
                </div>
            </button>
        </div>
    </div>
</ul>

<script src="<?=JS."navar.js"?>"></script>