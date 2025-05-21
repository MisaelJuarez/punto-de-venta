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
    <link rel="stylesheet" href="<?=CSS."productos.css";?>">
    <title>Productos</title>
</head>
<body>
    <div class="ms-4 me-4">
        <div class="container-fluid mt-3 p-2" id="contenedor-tabla">
            <table id="myTable" class="table table-secondary table-striped">
                <thead>
                    <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Existencia</th>
                        <th scope="col">Cantidad Minima</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="">
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-agregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header h-agregar">
                <h1 class="modal-title fs-5 text-dark" id="staticBackdropLabel">Agregar un nuevo producto</h1>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-agregar">
                <form class="row g-3 needs-validation" novalidate id="forumulario-producto">
                    <div class="col-md-6">
                        <label for="codigo" class="form-label">Codigo de Barras</label>
                        <input type="text" class="form-control" name="codigo" id="codigo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del producto</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div>

                    <hr>

                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <label for="uCompra" class="form-label">Unidad de compra</label>
                        <select class="form-select" aria-label="Default select example" name="uCompra" id="uCompra">
                            <option selected disabled>Unidades</option>
                            <option value="CAJA">CAJA</option>
                            <option value="PZA">PZA</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="uVenta" class="form-label">Unidad de venta</label>
                        <select class="form-select" aria-label="Default select example" name="uVenta" id="uVenta">
                            <option selected disabled>Unidades</option>
                            <option value="CAJA">CAJA</option>
                            <option value="PZA">PZA</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="uCantidad" class="form-label">Cantiad</label>
                        <input type="number" value="1" class="form-control" name="uCantidad" id="uCantidad" required>
                    </div>
                    <div class="col-md-2"></div>

                    <hr>

                    <div class="col-md-2"></div>
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="pCompra" class="form-label me-3">Precio de compra:</label>
                        <input type="number" class="form-control w-25 me-3" name="pCompra" id="pCompra" required>
                        <span class="text-dark fs-4">X <span id="unidadCompra"></span></span>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="pCosto" class="form-label me-3">Costo:</label>
                        <input type="number" class="form-control w-25 me-3" name="pCosto" id="pCosto" required disabled readonly>
                        <span class="text-dark fs-4">X <span id="unidadCosto"></span></span>
                    </div>
                    <div class="col-md-2"></div>
                    
                    <hr>

                    <div class="col-md-4 d-flex align-items-end">
                        <label for="precio" class="form-label me-3">Precio de venta</label>
                        <input type="text" class="form-control w-25" name="precio" id="precio" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="cantidad_minima" class="form-label me-3">Cantidad minima</label>
                        <input type="number" class="form-control w-25" name="cantidad_minima" id="cantidad_minima" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="cantidad_maxima" class="form-label me-3">Cantidad maxima</label>
                        <input type="number" class="form-control w-25" name="cantidad_maxima" id="cantidad_maxima" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer f-agregar">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="agregar-producto">Agregar producto</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header h-editar">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-editar">
                <form class="row g-3 needs-validation" novalidate id="forumulario-producto-editar">
                    <div class="col-md-6">
                        <label for="codigo-editar" class="form-label">Codigo de Barras</label>
                        <input type="text" class="form-control" name="codigo-editar" id="codigo-editar" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nombre-editar" class="form-label">Nombre del producto</label>
                        <input type="text" class="form-control" name="nombre-editar" id="nombre-editar" required>
                    </div>

                    <hr>

                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <label for="uCompra-editar" class="form-label">Unidad de compra</label>
                        <select class="form-select" aria-label="Default select example" name="uCompra-editar" id="uCompra-editar">
                            <option selected disabled>Unidades</option>
                            <option value="CAJA">CAJA</option>
                            <option value="PZA">PZA</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="uVenta-editar" class="form-label">Unidad de venta</label>
                        <select class="form-select" aria-label="Default select example" name="uVenta-editar" id="uVenta-editar">
                            <option selected disabled>Unidades</option>
                            <option value="CAJA">CAJA</option>
                            <option value="PZA">PZA</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="uCantidad-editar" class="form-label">Cantiad</label>
                        <input type="number" value="1" class="form-control" name="uCantidad-editar" id="uCantidad-editar" required>
                    </div>
                    <div class="col-md-2"></div>

                    <hr>

                    <div class="col-md-2"></div>
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="pCompra-editar" class="form-label me-3">Precio de compra:</label>
                        <input type="number" class="form-control w-25 me-3" name="pCompra-editar" id="pCompra-editar" required>
                        <span class="text-dark fs-4">X <span><span id="unidadCompra-editar"></span></span></span>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="pCosto-editar" class="form-label me-3">Costo:</label>
                        <input type="number" class="form-control w-25 me-3" name="pCosto-editar" id="pCosto-editar" required disabled readonly>
                        <span class="text-dark fs-4">X <span id="unidadCosto-editar"></span></span>
                    </div>
                    <div class="col-md-2"></div>
                    
                    <hr>

                    <div class="col-md-4 d-flex align-items-end">
                        <label for="precio-editar" class="form-label me-3">Precio de venta</label>
                        <input type="text" class="form-control w-25" name="precio-editar" id="precio-editar" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="cantidad_minima-editar" class="form-label me-3">Cantidad minima</label>
                        <input type="number" class="form-control w-25" name="cantidad_minima-editar" id="cantidad_minima-editar" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <label for="cantidad_maxima-editar" class="form-label me-3">Cantidad maxima</label>
                        <input type="number" class="form-control w-25" name="cantidad_maxima-editar" id="cantidad_maxima-editar" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer f-editar">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="editar-producto">Editar producto</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."productos.js"?>"></script>
</body>
</html>