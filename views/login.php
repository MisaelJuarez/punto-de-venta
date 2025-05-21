<?php
if (isset($_SESSION['usuario'])) {
    header("location:inicio");
    exit();
}
?>
<head>
    <link rel="stylesheet" href="<?=CSS."login.css"?>">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <img src="./public/img/login_ilustracion.jpg" alt="Secure Illustration" class="img-fluid">
        </div>
        <div class="right-panel">
            <h2>Bienvenido!</h2>
            <form id="formulario_login">
                <div class="mb-4 mt-5">
                    <input type="text" class="form-control" placeholder="Ingresa tu usuario" name="usuario">
                </div>
                <div class="mb-4">
                    <input type="password" class="form-control" placeholder="Ingresa tu contraseña" name="pass">
                </div>
                <div class="d-flex justify-content-between mt-5">
                    <button id="btn-ingresar" type="button" class="btn btn-outline-light btn-custom w-100">Ingresar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?=JS."login.js"?>"></script>
</body>