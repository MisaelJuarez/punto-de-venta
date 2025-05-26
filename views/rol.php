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
    <title>Roles</title>
</head>
<body>
    <div class="container">
        <div class="row pt-4">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nombre-rol" placeholder="">
                    <label for="nombre-rol">Ingresa el nombre del rol</label>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            Permisos de usuarios
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="informacion" name="pUsuarios" id="informacion">
                                <label class="form-check-label" for="informacion">
                                    Editar informacion
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="registrar" name="pUsuarios" id="registrar">
                                <label class="form-check-label" for="registrar">
                                    Registrar usuarios
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="administrar" name="pUsuarios" id="administrar">
                                <label class="form-check-label" for="administrar">
                                    Administrar usuario
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="crear_roles" name="pUsuarios" id="crear_roles">
                                <label class="form-check-label" for="crear_roles">
                                    Crear roles
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            Permisos de productos
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="agregar_productos" name="pProductos" id="agregar_productos">
                                <label class="form-check-label" for="agregar_productos">
                                    Agregar productos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="editar_productos" name="pProductos" id="editar_productos">
                                <label class="form-check-label" for="editar_productos">
                                    Editar productos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="eliminar_productos" name="pProductos" id="eliminar_productos">
                                <label class="form-check-label" for="eliminar_productos">
                                    Eliminar productos
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                            Permiso de compras
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="realizar_compras" name="pCompras" id="realizar_compras">
                                <label class="form-check-label" for="realizar_compras">
                                    Realizar compras
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                            Permiso de provedores
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                        <div class="accordion-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="agregar_provedores" name="pProvedor" id="agregar_provedores">
                                <label class="form-check-label" for="agregar_provedores">
                                    Agregar provedores
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="editar_provedores" name="pProvedor" id="editar_provedores">
                                <label class="form-check-label" for="editar_provedores">
                                    Editar provedores
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="eliminar_provedores" name="pProvedor" id="eliminar_provedores">
                                <label class="form-check-label" for="eliminar_provedores">
                                    Eliminar provedores
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                            Permiso de detalles
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive">
                        <div class="accordion-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="ver_detalles" name="pDetalles" id="ver_detalles">
                                <label class="form-check-label" for="ver_detalles">
                                    Visualizar detalles
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
        <div class="row mt-4">
            <div class="col-3"></div>
            <div class="col-6 mb-4">
                <button class="btn btn-info" id="crear-rol">Crear rol</button>
            </div>
            <div class="col-3"></div>
        </div>
    </div>

    <script src="<?=JS."rol.js"?>"></script>
</body>
</html>