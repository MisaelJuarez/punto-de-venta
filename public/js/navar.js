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
    cantidad_productos();
    cantidad_por_acabarse();
})