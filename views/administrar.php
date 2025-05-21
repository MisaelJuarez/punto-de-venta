<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=CSS."table.css";?>">
    <link rel="stylesheet" href="<?=CSS."administrar.css"?>">
    <title>Administrar</title>
</head>
<body>
    <div class="container mt-4 p-3" id="contenedor-tabla">
        <table id="myTable" class="table table-dark table-striped p-5">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Correo electronico</th>
                    <th scope="col">Acciones</th> 
                </tr>
            </thead>
            <tbody id="tabla_libros">
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modal-editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate id="forumulario-editar">
                    <div class="col-md-3">
                        <label for="titulo" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre-editar" id="nombre-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="autor" class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="apellidos-editar" id="apellidos-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="publicacion" class="form-label">Correo electronico</label>
                        <input type="text" class="form-control" name="correo-editar" id="correo-editar" required>
                    </div>
                    <div class="col-md-3">
                        <label for="editorial" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="pass-editar" id="pass-editar" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="editar-usuario">Editar Usuario</button>
            </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."table.js"?>"></script>
    <script src="<?=JS."administrar.js"?>"></script>
</body>
</html>