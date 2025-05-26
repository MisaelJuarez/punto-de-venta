let tabla, id_producto;
const modal = document.getElementById('modal-agregar');
const modaleditar = document.getElementById('modal-editar');
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
        permisos = respuesta[0].rol_productos.split(',');
    });
}

const obtener_datos = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_datos');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        if (tabla) {
            tabla.clear().rows.add(respuesta).draw(); 
        } else {
            tabla = $('#myTable').DataTable({
                data: respuesta, 
                columns: [
                    { data: 'producto_codigo' }, 
                    { data: 'producto_nombre' }, 
                    { 
                        data: 'producto_precio',
                        render: function(data, type, row) {
                            return `$${parseFloat(data).toFixed(2)}`;
                        }
                    }, 
                    { data: 'producto_cantidad' }, 
                    { data: 'producto_cantidad_minima' }, 
                    {
                        data: 'producto_id',
                        render: function(data, type, row) {
                            let botones = ''
                            if (permisos.filter(p => p == 'editar_productos').length > 0) {
                                botones += `
                                    <button class="btn btn-warning editar-producto"
                                        data-bs-toggle="modal" data-bs-target="#modal-editar"
                                        data-id="${data}" 
                                        data-codigo="${row.producto_codigo}" 
                                        data-nombre="${row.producto_nombre}" 
                                        data-ucompra="${row.producto_uCompra}" 
                                        data-uventa="${row.producto_uVenta}" 
                                        data-ucantidad="${row.producto_uCantidad}" 
                                        data-pcompra="${row.producto_pCompra}" 
                                        data-pcosto="${row.producto_pCosto}" 
                                        data-precio="${row.producto_precio}" 
                                        data-cantidad="${row.producto_cantidad}"
                                        data-cantidadminima="${row.producto_cantidad_minima}"
                                        data-cantidadmaxima="${row.producto_cantidad_maxima}"
                                    >
                                        Editar
                                    </button>
                                `;
                            }
                            if (permisos.filter(p => p == 'eliminar_productos').length > 0) {
                                botones += `
                                    <button class="btn btn-danger eliminar-producto" 
                                        data-id="${data}" 
                                    >
                                        Eliminar
                                    </button>
                                `;
                            }
                            return botones;
                        }
                    }
                ],
                "lengthChange": false,
                "pageLength": 7,
                language: { url: "./public/json/lenguaje.json" },
                dom: '<"custom-toolbar"lf>tip', 
                initComplete: () => {
                    if (permisos.filter(p => p == 'agregar_productos').length > 0) {
                        $("div.custom-toolbar").prepend(`
                            <div class="left-section">
                                <button class="btn btn-info"
                                    data-bs-toggle="modal" data-bs-target="#modal-agregar"
                                >
                                    <i class="bi bi-plus-lg fs-5"></i>
                                </button>
                            </div>
                        `);
                    }else {
                        $("div.custom-toolbar").prepend('');
                    }
                    $("div.custom-toolbar .dataTables_filter").appendTo(".custom-toolbar").addClass("right-section");
                }
            });
        }
    });
};

const agregar_producto = () => {
    let data = new FormData(document.getElementById('forumulario-producto'));
    data.append('metodo','agregar_producto');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalAgregar = bootstrap.Modal.getInstance(modal); 
            if (modalAgregar) {
                modalAgregar.hide();
                document.getElementById('forumulario-producto').reset();
            }  
            obtener_datos();
            cantidad_productos();
            cantidad_por_acabarse();
        } else if(respuesta[0] == 0) {
            Swal.fire({
                title: `${respuesta[1]}`,
                icon: "error"
            });
        }
    })
}

const editar_producto = () => {
    let data = new FormData(document.getElementById('forumulario-producto-editar'));
    data.append('id',id_producto);
    data.append('codigo_actual',document.getElementById('codigo-editar').value);
    data.append('nombre_actual',document.getElementById('nombre-editar').value);
    data.append('metodo','editar_producto');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalEditar = bootstrap.Modal.getInstance(modaleditar); 
            if (modalEditar) modalEditar.hide();
            obtener_datos();
            cantidad_por_acabarse();
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    });
} 

const eliminar_producto = (id) => {
    let data = new FormData();
    data.append('id',id);
    data.append('metodo','eliminar_producto')
    fetch('app/controller/home.php', {
        method: 'POST',
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            obtener_datos();
            cantidad_productos();
            cantidad_por_acabarse();
        } else if(respuesta[0] == 0) {
            await Swal.fire({icon: "error",title:`${respuesta[1]}`,text:`${respuesta[2]}`});
        }
    })
}

document.addEventListener('DOMContentLoaded', () => {
    obtener_permisos();
    obtener_datos();
});

document.getElementById('agregar-producto').addEventListener('click', () => {
    agregar_producto();
});

document.getElementById('editar-producto').addEventListener('click', () => {
    editar_producto()
});

document.getElementById('uCompra').addEventListener('change', () => {
    document.getElementById('unidadCompra').textContent = document.getElementById('uCompra').value;
});
document.getElementById('uVenta').addEventListener('change', () => {
    document.getElementById('unidadCosto').textContent = document.getElementById('uVenta').value;
});

document.getElementById('uCompra-editar').addEventListener('change', () => {
    document.getElementById('unidadCompra-editar').textContent = document.getElementById('uCompra-editar').value;
});
document.getElementById('uVenta-editar').addEventListener('change', () => {
    document.getElementById('unidadCosto-editar').textContent = document.getElementById('uVenta-editar').value;
});

document.getElementById('pCompra').addEventListener('input', () => {
    document.getElementById('pCosto').value = parseFloat(document.getElementById('pCompra').value / document.getElementById('uCantidad').value).toFixed(2); 
});
document.getElementById('pCompra-editar').addEventListener('input', () => {
    document.getElementById('pCosto-editar').value = parseFloat(document.getElementById('pCompra-editar').value / document.getElementById('uCantidad-editar').value).toFixed(2); 
});

document.getElementById('myTable').addEventListener('click', (e) => {
    const botonEditar = e.target.closest('.editar-producto');
    const botonEliminar = e.target.closest('.eliminar-producto');
    if (botonEditar) {
        id_producto = botonEditar.dataset.id;
        document.getElementById('codigo-editar').value = botonEditar.dataset.codigo;
        document.getElementById('nombre-editar').value = botonEditar.dataset.nombre;
        document.getElementById('uCompra-editar').value = botonEditar.dataset.ucompra;
        document.getElementById('uVenta-editar').value = botonEditar.dataset.uventa;
        document.getElementById('uCantidad-editar').value = botonEditar.dataset.ucantidad;
        document.getElementById('pCompra-editar').value = botonEditar.dataset.pcompra;
        document.getElementById('pCosto-editar').value = botonEditar.dataset.pcosto;
        document.getElementById('precio-editar').value = botonEditar.dataset.precio;
        document.getElementById('cantidad_minima-editar').value = botonEditar.dataset.cantidadminima;
        document.getElementById('cantidad_maxima-editar').value = botonEditar.dataset.cantidadmaxima;
        document.getElementById('unidadCompra-editar').textContent = botonEditar.dataset.ucompra;
        document.getElementById('unidadCosto-editar').textContent = botonEditar.dataset.uventa;
    }
    if (botonEliminar) {
        Swal.fire({
            icon: "warning",
            text: "Quieres eliminar este Producto?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar"
          }).then((result) => {
            if (result.isConfirmed) {
                eliminar_producto(botonEliminar.dataset.id);
            }
        });
    }
});