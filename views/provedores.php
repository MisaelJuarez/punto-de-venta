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
    <link rel="stylesheet" href="<?=CSS."provedores.css";?>">
    <title>Provedores</title>
</head>
<body>
    <div class="ms-4 me-4">
        <div class="container-fluid mt-3 p-3" id="contenedor-tabla">
            <table id="myTable" class="table table-secondary table-striped p-5">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Email</th>
                        <th scope="col">Direccion</th>
                        <th scope="col">rfc</th>
                        <th scope="col">pago</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-agregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header h-agregar">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar un nuevo provedor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body b-agregar">
                <form class="row g-3 needs-validation" novalidate id="forumulario-provedor">

                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del provedor</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label for="empresa" class="form-label">Nombre de la empresa</label>
                        <input type="text" class="form-control" name="empresa" id="empresa" required>
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="col-md-12">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" name="direccion" id="direccion" required>
                    </div>

                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <label for="rfc" class="form-label">Rfc</label>
                        <input type="text" class="form-control" name="rfc" id="rfc" required>
                    </div>
                    <div class="col-md-4">
                        <label for="pago" class="form-label">Forma de pago</label>
                        <input type="text" class="form-control" name="pago" id="pago" required>
                    </div>
                    <div class="col-md-2"></div>
                </form>
            </div>
            <div class="modal-footer f-agregar">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="agregar-provedor">Agregar provedor</button>
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
                <form class="row g-3 needs-validation" novalidate id="forumulario-provedor-editar">
                    <div class="col-md-6">
                        <label for="nombre-editar" class="form-label">Nombre del provedor</label>
                        <input type="text" class="form-control" name="nombre-editar" id="nombre-editar" required>
                    </div>
                    <div class="col-md-6">
                        <label for="empresa-editar" class="form-label">Nombre de la empresa</label>
                        <input type="text" class="form-control" name="empresa-editar" id="empresa-editar" required>
                    </div>

                    <div class="col-md-6">
                        <label for="telefono-editar" class="form-label">Telefono</label>
                        <input type="text" class="form-control" name="telefono-editar" id="telefono-editar" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email-editar" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email-editar" id="email-editar" required>
                    </div>
                    <div class="col-md-12">
                        <label for="direccion-editar" class="form-label">Direccion</label>
                        <input type="text" class="form-control" name="direccion-editar" id="direccion-editar" required>
                    </div>

                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <label for="rfc-editar" class="form-label">Rfc</label>
                        <input type="text" class="form-control" name="rfc-editar" id="rfc-editar" required>
                    </div>
                    <div class="col-md-4">
                        <label for="pago-editar" class="form-label">Forma de pago</label>
                        <input type="text" class="form-control" name="pago-editar" id="pago-editar" required>
                    </div>
                    <div class="col-md-2"></div>
                </form>
            </div>
            <div class="modal-footer f-editar">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="editar-provedor">Editar producto</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."provedores.js"?>"></script>
</body>
</html>