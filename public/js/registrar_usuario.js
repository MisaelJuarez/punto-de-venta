let roles = '<option selected disabled>Ingrese el rol del usuario</option>';
let permisos;

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
        
        if (permisos.filter(p => p == 'registrar').length <= 0){
            window.location.href = 'inicio';
        } 
    });
}

const obtener_roles = () => {
    let data = new FormData();
    data.append('metodo','obtener_roles');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {

        respuesta.map(rol => {
            roles += `
                <option value="${rol.rol_id}">${rol.rol_nombre}</option>
            `;
        });
        document.getElementById('rol').innerHTML = roles;
    });
}
 
const registrar_usuario = () => {
    let data = new FormData(document.getElementById('formulario_registro_usuario'));
    data.append('metodo','registrar_usuario');
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            window.location = "inicio";
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

document.getElementById('btn-registrar').addEventListener('click', () => {
    registrar_usuario();
});

document.addEventListener('DOMContentLoaded', () => {
    redireccionar();
    obtener_roles();
})