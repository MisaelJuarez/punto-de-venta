<?php
if (!isset($_SESSION['usuario'])) {
    header("location:login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=CSS."table.css";?>">
    <link rel="stylesheet" href="<?=CSS."caja.css"?>">
    <title>Caja registradora</title>
</head>
<body>

    <div class="container">
        <div class="row ms-4 me-4 mb-3 py-2 bg-primary text-white">
            <h2>Nueva compra</h2>
        </div>
        <div class="row mb-3 ps-5">
            <div class="d-flex justify-content-between">
                <div class="c-buscador">
                    <button type="button" id="btn-buscar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#buscar">
                        <i class="bi bi-search"></i>
                        Buscar producto
                    </button>
                </div>
                <div class="d-flex c-buscador">
                    <!-- <label for="" class="d-flex me-3">
                        <i class="bi bi-upc fs-3"></i>
                        <p class="fs-4">Código de barras</p>
                    </label>
                    <input class="form-control me-3 codigo" type="text" placeholder="Código de barras">
                    <button type="button" class="btn btn-info"><i class="bi bi-search"></i></button> -->
                </div>
            </div>
        </div>
        <div class="row ms-5 me-5">
            <div id="table-vender" class="p-3 mb-3 border border-2 border-info rounded-2">
                <table class="table table-info table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="productos_vender">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row ms-5 me-5">
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary fs-5 btn-generar" data-bs-toggle="modal" data-bs-target="#vender" id="generar_venta">
                    Generar compra
                </button>
                <p class="fs-1">$<span id="precio_total"></span></p>
            </div>
        </div>
    </div>


    <div class="modal fade" id="vender" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header h-vender">
                <h5 class="modal-title" id="staticBackdropLabel">Vender productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-vender">
                <div class="row mb-5">
                    <div class="col-6 d-flex justify-content-center align-items-center flex-column">
                        <label for="" class="mb-2">
                            Efectivo
                            <input class="form-control mb-3" type="text" placeholder="0.000" id="pagar_efectivo">
                        </label>
                        <label for="" class="mb-2">
                            Tarjeta
                            <input class="form-control mb-3" type="text" value="0.00" id="pagar_tarjeta">
                        </label>
                        <label for="" class="mb-2">
                            Transferencia
                            <input class="form-control" type="text" value="0.00" id="pagar_transferencia">
                        </label>
                    </div>    
                    <div class="col-6 d-flex justify-content-center align-items-center flex-column">
                        <h2 class="">Total a pagar</h2>
                        <p class="fs-1 text-primary">$<span id="total_pagar">0.00</span></p>
                        <hr class="fs-1">
                        <h2 class="">Cambio</h2>
                        <p class="fs-1 text-success" id="contenedor-cambio">$<span id="cambio">0.00</span></p>
                    </div>    
                </div>
                <div class="row d-flex justify-content-center">
                    <button type="button" class="btn btn-success w-50 mb-3" id="vender_productos">
                        Aceptar
                    </button>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="buscar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header h-buscar">
                <h5 class="modal-title" id="staticBackdropLabel">Buscar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-buscar">
                <table id="myTable" class="table table-secondary table-striped p-5">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."caja.js"?>"></script>
</body>
</html>