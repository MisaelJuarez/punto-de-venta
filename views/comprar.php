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
    <link rel="stylesheet" href="<?=CSS."comprar.css"?>">
    <title>Comprar</title>
</head>
<body>
    <div class="container">
        <div class="row mt-2">
            <div class="col-8 d-flex ">
                <button class="btn btn-success fs-3" id="realizar-compra" data-bs-toggle="modal" data-bs-target="#generar-compra">
                    Realizar compra
                    <i class="bi bi-cart3 ms-2"></i>
                </button>
            </div>
            <div class="col-4 d-flex align-items-center">
                <button class="btn btn-info" id="seleccionar-producto" data-bs-toggle="modal" data-bs-target="#buscar-producto">
                    <i class="bi bi-search me-2"></i>
                    Buscar poducto
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-8 d-flex align-items-center">
                <button class="btn btn-secondary me-3" id="seleccionar-provedor" data-bs-toggle="modal" data-bs-target="#buscar-provedor">
                    <i class="bi bi-truck me-2"></i>
                    Seleccionar provedor
                </button>
                <input class="form-control w-50" type="text" value="Sin provedor" id="provedor" disabled readonly>
            </div>
            <div class="col-4 d-flex align-items-center">
                <button class="btn btn-danger" id="obtener-productos-acabarse" data-bs-toggle="modal" data-bs-target="#productos-acabarse">
                    <i class="bi bi-box-seam me-2"></i>
                    Productos por acabarse
                </button>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col mt-3 border border-info border-2" id="table-comprar">
                <table class="table border-primary">
                    <thead class="table-danger">
                        <tr>
                            <th scope="col">Cantidad</th>
                            <th scope="col">codigo</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Total</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="lista-comprar">
                        
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-4 d-flex">
                <p class="me-3 fs-3">TOTAL:</p>
                <p class="fs-3">$<span id="total-compras">0</span></p>
            </div>
            <div class="col-8"></div>
        </div>
    </div>

    <div class="modal fade" id="buscar-provedor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header h-buscar">
                <h5 class="modal-title" id="staticBackdropLabel">Selecciona un provedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-buscar">
                <table id="tableProvedor" class="table table-secondary table-striped p-5">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Correo electronico</th>
                            <th scope="col">Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="buscar-producto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header h-buscar">
                <h5 class="modal-title" id="staticBackdropLabel">Comprar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-buscar">
                <table id="tableProducto" class="table table-secondary table-striped p-5">
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

    <div class="modal fade" id="comprar-producto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header h-buscar">
                <h5 class="modal-title" id="staticBackdropLabel">Detalles de la compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-buscar">
                <form class="row g-3 needs-validation" novalidate id="formulario-comprar">
                    <div class="col-md-12 bg-secondary text-white">
                        <p class="pt-2">Datos del producto</p> 
                    </div>
                  
                    <div class="col-md-4">
                        <label for="codigo" class="form-label">Codigo del producto</label>
                        <input type="text" class="form-control form-control-sm" name="codigo" id="codigo" required disabled readonly>
                    </div>
                  
                    <div class="col-md-4">
                        <label for="nombre-producto" class="form-label">Nombre del producto</label>
                        <input type="text" class="form-control form-control-sm" name="nombre-producto" id="nombre-producto" required disabled readonly>
                    </div>

                    <div class="col-md-4">
                        <label for="cantidad" class="form-label">En existencia</label>
                        <input type="text" class="form-control form-control-sm" name="cantidad" id="cantidad" required disabled readonly>
                    </div>

                    <div class="col-md-12 bg-secondary text-white">
                        <p class="pt-2">Precios</p> 
                    </div>

                    <div class="col-md-4">
                        <label for="uCompra" class="form-label">Precio X <span id="uCompra"></span></label>
                        <input type="text" class="form-control form-control-sm" name="pCompra" id="pCompra" required disabled readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="pCosto" class="form-label">Precio X <span id="uVenta"></span></span></label>
                        <input type="text" class="form-control form-control-sm" name="pCosto" id="pCosto" required disabled readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="precio" class="form-label">Precio al publico</span></label>
                        <input type="text" class="form-control form-control-sm" name="precio" id="precio" required disabled readonly>
                    </div>

                    <div class="col-md-12 bg-secondary text-white">
                        <p class="pt-2">Detalles de la compra</p> 
                    </div>

                    <div class="col-md-4">
                        <label for="cantidad-comprar" class="form-label">Cantidad</label>
                        <input type="number" class="form-control form-control-sm" name="cantidad-comprar" id="cantidad-comprar" required>
                    </div>
                    <div class="col-md-4">
                        <label for="precio-comprar" class="form-label">Costo</label>
                        <input type="number" class="form-control form-control-sm" name="precio-comprar" id="precio-comprar" required>
                    </div>

                    <hr>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-info" id="aceptar" data-bs-dismiss="modal">
                            Aceptar
                        </button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productos-acabarse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header h-buscar">
                <h5 class="modal-title" id="staticBackdropLabel">Comprar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-buscar">
                <table id="tableAcabarse" class="table table-secondary table-striped p-5">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Comprar</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="generar-compra" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header h-buscar">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center mb-5">
                            <h3>Total de la compra</h3>
                            <h4>$<span id="total-final"></span></h4>
                        </div>
        
                        <div class="col-md-3">
                            <h5 class="">Provedor:</h5>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control form-control-sm" name="provedor-seleccionado" id="provedor-seleccionado" required disabled readonly>
                        </div>
                        <div class="col-md-3"></div>

                        <div class="col-md-3 mt-5">
                            <h5 class="">Cantidad a pagar:</h5>
                        </div>
                        <div class="col-md-6 mt-5">
                            <input type="text" class="form-control form-control-sm text-end w-50" name="cantidad-pagar" id="cantidad-pagar">
                        </div>
                        <div class="col-md-3 mt-5"></div>
                        
                        <div class="col-md-3 mt-5">
                            <h5>Pagar con:</h5>
                        </div>
                        <div class="col-md-6 mt-5">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="forma-pago" id="forma-pago">
                                <option selected disabled>Forma en la que se va a pagar</option>
                                <option value="caja">Caja</option>
                                <option value="otro">Otra forma de pago</option>
                            </select>
                        </div>
                        <div class="col-md-3 mt-5"></div>

                        <div class="col-md-4 mt-5">
                            <button class="btn btn-info w-100" id="aceptar_compra">Aceptar</button>
                        </div>
                        <div class="col-md-8 mt-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."comprar.js"?>"></script>
</body>
</html>