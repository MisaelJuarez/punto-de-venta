const logear_usuario = () => {
    let data = new FormData(document.getElementById('formulario_login'));
    fetch("app/controller/login.php",{
        method:"POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({
                position: "top-end",
                icon: "success",
                title: `${respuesta[1]}`,
                showConfirmButton: false,
                timer: 1500
              });
            window.location="inicio";
        }else {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    });
}

document.getElementById('btn-ingresar').addEventListener('click', () => {
    logear_usuario();
});