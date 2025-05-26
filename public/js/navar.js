let permisos_comprar;
let permisos_detalles;

const obtener_permisos_comprar = () => {
    let data = new FormData();
    data.append('metodo','obtener_permisos');
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        permisos_comprar = respuesta[0].rol_compras.split(',');
        document.getElementById('comprar').style.pointerEvents = permisos_comprar.filter(p => p == 'realizar_compras').length > 0 ? 'auto' : 'none'; 
    });
}
const obtener_permisos_detalles = () => {
    let data = new FormData();
    data.append('metodo','obtener_permisos');
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        permisos_detalles = respuesta[0].rol_detalles.split(',');
        document.getElementById('detalles').style.pointerEvents = permisos_detalles.filter(p => p == 'ver_detalles').length > 0 ? 'auto' : 'none'; 
    });
}

const cerrar_session = () => {
    fetch("app/controller/cerrar_sesion.php")
    .then(respuesta => respuesta.json())
    .then(async (respuesta) => {
        await await Swal.fire({
            position: "top-end",
            icon: "success",
            title: `${respuesta[1]}`,
            showConfirmButton: false,
            timer: 1500
          });
        window.location = "login";
    });
}

const cantidad_productos = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_datos');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        document.getElementById('cantidad-productos').innerText = respuesta.length; 
    });
};

const cantidad_por_acabarse = () => {
    let data = new FormData();
    data.append('metodo', 'productos_por_comprar');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        if (respuesta.length > 0) {
            document.getElementById('contenedor-cantidad').innerHTML = `<span class="badge bg-danger text-dark mt-1" id="contidad_por_comprar">${respuesta.length}</span>`
        } else {
            document.getElementById('contenedor-cantidad').innerHTML = ""
        }
    });
}

document.querySelectorAll('.opcion').forEach((btn) => {
    btn.addEventListener("click", function() {
        window.location = `${this.id}`;
    });
});

document.getElementById('cerrar_session').addEventListener('click',() => {
    cerrar_session();
});

document.addEventListener('DOMContentLoaded', () => {
    obtener_permisos_comprar();
    obtener_permisos_detalles();
    cantidad_productos();
    cantidad_por_acabarse();
})