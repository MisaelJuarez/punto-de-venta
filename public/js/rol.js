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
        
        if (permisos.filter(p => p == 'crear_roles').length <= 0){
            window.location.href = 'inicio';
        } 
    });
}

const crear_rol = () => {
    const checkboxUsuarios = document.querySelectorAll('input[name="pUsuarios"]:checked');
    const pUsuarios = Array.from(checkboxUsuarios).map(cb => cb.value);

    const checkboxProductos = document.querySelectorAll('input[name="pProductos"]:checked');
    const pProductos = Array.from(checkboxProductos).map(cb => cb.value);

    const checkboxCompras = document.querySelector('input[name="pCompras"]');   
    
    const checkboxProvedor = document.querySelectorAll('input[name="pProvedor"]:checked');
    const pProvedor = Array.from(checkboxProvedor).map(cb => cb.value);

    const checkboxDetalles = document.querySelector('input[name="pDetalles"]');   

    let data = new FormData();
    data.append('pUsuarios', pUsuarios.length == 0 ? 'sin_permiso' : pUsuarios.join(','));
    data.append('pProductos', pProductos.length == 0 ? 'sin_permiso': pProductos.join(','));
    data.append('pCompras', !checkboxCompras.checked ? 'sin_permiso': checkboxCompras.value);
    data.append('pProvedores', pProvedor.length == 0 ? 'sin_permiso': pProvedor.join(','));
    data.append('pDetalles', !checkboxDetalles.checked ? 'sin_permiso': checkboxDetalles.value);
    data.append('nombre_rol', document.getElementById('nombre-rol').value);
    data.append('metodo','crear_rol');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            document.getElementById('nombre-rol').value = '';
            Array.from(checkboxUsuarios).map(cb => cb.checked = false);
            Array.from(checkboxProductos).map(cb => cb.checked = false);
            checkboxCompras.checked = false;
            Array.from(checkboxProvedor).map(cb => cb.checked = false);
            checkboxDetalles.checked = false;
        } else if(respuesta[0] == 0) {
            Swal.fire({
                title: `${respuesta[1]}`,
                icon: "error"
            });
        }
    })
}

document.getElementById('crear-rol').addEventListener('click', () => {
    crear_rol();
});

document.addEventListener('DOMContentLoaded', () => {
    redireccionar();
})