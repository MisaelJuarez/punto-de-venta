let permisos;

const obtener_permisos = () => {
    let data = new FormData();
    data.append('metodo','obtener_permisos');
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        permisos = respuesta[0].rol_usuarios.split(',');
        // console.log(respuesta[0].rol_usuarios.split(','));
        document.getElementById('informacion').style.pointerEvents = permisos.filter(p => p == 'informacion').length > 0 ? 'auto' : 'none';  
        document.getElementById('registrar_usuario').style.pointerEvents = permisos.filter(p => p == 'registrar').length > 0 ? 'auto' : 'none';  
        document.getElementById('administrar').style.pointerEvents = permisos.filter(p => p == 'administrar').length > 0 ? 'auto' : 'none';  
        document.getElementById('rol').style.pointerEvents = permisos.filter(p => p == 'crear_roles').length > 0 ? 'auto' : 'none';  
    });
}

document.querySelectorAll('.card').forEach((btn) => {
    btn.addEventListener("click", function() {
        window.location = `${this.id}`;
    });
});

document.addEventListener('DOMContentLoaded', () => {
    obtener_permisos();
});