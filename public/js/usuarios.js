const redireccionar = () => {
    let data = new FormData();
    data.append('metodo','obtener_permisos');
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        permisos = respuesta[0].rol_usuarios.split(',');        
        
        if (permisos.filter(p => p == 'informacion').length <= 0){
            window.location.href = 'inicio';
        } 
    });
}

const obtener_informacion = () => {
    let data = new FormData();
    data.append('metodo','obtener_informacion');
    fetch("app/controller/usuario.php",{
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        document.getElementById('nombre').value = respuesta['usuario_usuario'];
        document.getElementById('apellidos').value = respuesta['usuario_apellidos'];
        document.getElementById('correo').value = respuesta['usuario_correo'];
    });
}

const actualizar_informacion = () => {
    let data = new FormData(document.getElementById('formulario_usuario'));
    data.append('metodo','actualizar_informacion')
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`, text: `${respuesta[2]}`});
            cerrar_session();
        } else {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

document.addEventListener('DOMContentLoaded',() => {
    redireccionar();
    obtener_informacion();
});

document.getElementById('btn-actualizar').addEventListener('click',() => {
    actualizar_informacion();
});