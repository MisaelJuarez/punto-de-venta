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
    <link rel="stylesheet" href="<?=CSS."informacion.css"?>">
    <title>Información</title>
</head>
<body>
    <div class="container p-5 d-flex justify-content-around">
        <div class="contenedor">
            <div class="text-center mb-3">
                <i class="bi bi-person-circle principal-icon"></i>
            </div>
            <p class="text-center nombre-usuario">
                <?php
                    echo $_SESSION['usuario']['usuario_usuario']." ".$_SESSION['usuario']['usuario_apellidos'];
                ?>
            </p>
        </div>
        <form class="contenedor p-3" id="formulario_usuario">
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="">
                <label for="nombre" class="text-black">Ingrese su nombre</label>
            </div> 
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="apellidos" id="apellidos" placeholder="">
                <label for="apellidos" class="text-black">Ingrese sus apellidos</label>
            </div> 
            <div class="form-floating mb-3">
                <input class="form-control" type="email" name="correo" id="correo" placeholder="">
                <label for="usuario" class="text-black">Ingrese su correo</label>
            </div> 
            <div class="form-floating mb-3">
                <input class="form-control" type="password" name="pass" id="pass" placeholder="">
                <label for="pass" class="text-black">Ingrese su nueva contraseña</label>
            </div> 
            <button type="button" class="btn btn-secondary w-100 text-dark" id="btn-actualizar">Acualizar informacion</button>
        </form>
    </div>

    <script src="<?=JS."usuarios.js"?>"></script>
</body>
</html>