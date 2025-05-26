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
    <link rel="stylesheet" href="<?=CSS."detalles.css";?>">
    <title>Detalles de corte de caja</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <button id="btn-buscar-corte" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#bucar-cortes">
                    Buscar
                    <i class="bi bi-search ps-3"></i>
                </button>
            </div>
            <div class="col-5"></div>
            <div class="col-5"></div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="p-3 mb-2 bg-secondary text-white">Datos generales</div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-1">
                <p class="mb-3">Fecha:</p>
                <p class="mb-3">Hora:</p>
                <p class="mb-3">Usuario:</p>
            </div>
            <div class="col-2">
                <input class="form-control form-control-sm text-end mb-2" value="---" type="text" id="fecha" disabled readonly>
                <input class="form-control form-control-sm text-end mb-2" value="---" type="text" id="hora" disabled readonly>
                <input class="form-control form-control-sm text-end mb-2" value="---" type="text" id="usuario" disabled readonly>
            </div>
            <div class="col-1">
                <p class="mb-3">Contado:</p>
                <p class="mb-3">Calculado:</p>
                <p class="mb-3">Diferencia:</p>
                <p class="mb-3">Total:</p>
            </div>
            <div class="col-2">
                <input class="form-control form-control-sm text-end mb-2" value="---" type="text" id="contado" disabled readonly>
                <input class="form-control form-control-sm text-end mb-2" value="---" type="text" id="calculado" disabled readonly>
                <input class="form-control form-control-sm text-end mb-2" value="---" type="text" id="diferencia" disabled readonly>
                <input class="form-control form-control-sm text-end mb-2" value="---" type="text" id="total" disabled readonly>
            </div>
            <div class="col-6"></div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="p-3 mb-2 bg-secondary text-white">Datos de compras</div>
            </div>
        </div>
        
        <div class="row mt-3" id="compras_hechas">
        </div>

    </div>

    <div class="modal fade" id="bucar-cortes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header h-buscar">
                <h5 class="modal-title" id="staticBackdropLabel">Cortes de caja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="myTable" class="table table-secondary table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Accion</th>
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
    <script src="<?=JS."detalles.js"?>"></script>
</body>
</html>