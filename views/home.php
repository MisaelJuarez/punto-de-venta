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
    <link rel="stylesheet" href="<?=CSS."home.css"?>">
    <link rel="stylesheet" href="<?=CSS."navar.css"?>">
    <title>Usuario</title>
</head>
<body>
    
    <div class="container">
        <div class="contenedor-card p-5 d-flex justify-content-evenly">

            <div class="card mb-3" id="informacion" style="width: 12rem;">
                <div class="card-header header-informacion">Informacion</div>
                <div class="card-body">
                    <h5 class="card-title w-100"><i class="bi bi-person-lines-fill card-icon"></i></i></h5>
                    <p class="card-text"></p>
                 </div>
            </div>

            <div class="card mb-3" id="registrar_usuario" style="width: 12rem;">
                <div class="card-header header-registrar_usuario">Registrar usuario</div>
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person-fill-add card-icon"></i></h5>
                    <p class="card-text"></p>
                 </div>
            </div>

            <div class="card mb-3" id="administrar" style="width: 12rem;">
                <div class="card-header header-inventario">Administrar</div>
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-people-fill card-icon"></i></h5>
                    <p class="card-text"></p>
                 </div>
            </div>
            
            <div class="card mb-3" id="rol" style="width: 12rem;">
                <div class="card-header header-rol">Rol</div>
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person-fill-gear card-icon"></i></i></h5>
                    <p class="card-text"></p>
                 </div>
            </div>
        </div>
    </div>

    <script src="<?=JS."home.js"?>"></script>
</body>
</html>