let tabla, id_provedor;
const modal = document.getElementById('modal-agregar');
const modaleditar = document.getElementById('modal-editar');

const obtener_provedores = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_provedores');
    
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
                    { data: 'provedor_nombre' }, 
                    { data: 'provedor_empresa' }, 
                    { data: 'provedor_telefono' }, 
                    { data: 'provedor_email' }, 
                    { data: 'provedor_direccion' }, 
                    { data: 'provedor_rfc' }, 
                    { data: 'provedor_pago' }, 
                    {
                        data: 'provedor_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-warning editar-provedor"
                                    data-bs-toggle="modal" data-bs-target="#modal-editar"
                                    data-id="${data}" 
                                    data-nombre="${row.provedor_nombre}" 
                                    data-empresa="${row.provedor_empresa}" 
                                    data-telefono="${row.provedor_telefono}" 
                                    data-email="${row.provedor_email}"
                                    data-direccion="${row.provedor_direccion}"
                                    data-rfc="${row.provedor_rfc}"
                                    data-pago="${row.provedor_pago}"
                                >
                                    Editar
                                </button>
                                <button class="btn btn-danger eliminar-provedor" 
                                    data-id="${data}" 
                                >
                                    Eliminar
                                </button>
                            `;
                        }
                    }
                ],
                "lengthChange": false,
                "pageLength": 5,
                language: { url: "./public/json/lenguaje.json" },
                dom: '<"custom-toolbar"lf>tip', 
                initComplete: () => {
                    $("div.custom-toolbar").prepend(`
                        <div class="left-section">
                            <button class="btn btn-info"
                                data-bs-toggle="modal" data-bs-target="#modal-agregar"
                            >
                                <i class="bi bi-plus-lg fs-5"></i>
                            </button>
                        </div>
                    `);
                    $("div.custom-toolbar .dataTables_filter").appendTo(".custom-toolbar").addClass("right-section");
                }
            });
        }
    });
};

const agregar_provedor = () => {
    let data = new FormData(document.getElementById('forumulario-provedor'));
    data.append('metodo','agregar_provedor');
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
                document.getElementById('forumulario-provedor').reset();
            }  
            obtener_provedores();
        } else if(respuesta[0] == 0) {
            Swal.fire({
                title: `${respuesta[1]}`,
                icon: "error"
            });
        }
    })
}

const editar_provedor = () => {
    let data = new FormData(document.getElementById('forumulario-provedor-editar'));
    data.append('id',id_provedor);
    data.append('metodo','editar_provedor');
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
            obtener_provedores();
        } else if(respuesta[0] == 0) {
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    });
} 

const eliminar_provedor = (id) => {
    let data = new FormData();
    data.append('id',id);
    data.append('metodo','eliminar_provedor')
    fetch('app/controller/home.php', {
        method: 'POST',
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            obtener_provedores();
        } else if(respuesta[0] == 0) {
            await Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

document.addEventListener('DOMContentLoaded', () => {
    obtener_provedores();
});

document.getElementById('agregar-provedor').addEventListener('click', () => {
    agregar_provedor();
});

document.getElementById('editar-provedor').addEventListener('click', () => {
    editar_provedor()
});

document.getElementById('myTable').addEventListener('click', (e) => {
    const botonEditar = e.target.closest('.editar-provedor');
    const botonEliminar = e.target.closest('.eliminar-provedor');
    if (botonEditar) {
        id_provedor = botonEditar.dataset.id;
        document.getElementById('nombre-editar').value = botonEditar.dataset.nombre;
        document.getElementById('empresa-editar').value = botonEditar.dataset.empresa;
        document.getElementById('telefono-editar').value = botonEditar.dataset.telefono;
        document.getElementById('email-editar').value = botonEditar.dataset.email;
        document.getElementById('direccion-editar').value = botonEditar.dataset.direccion;
        document.getElementById('rfc-editar').value = botonEditar.dataset.rfc;
        document.getElementById('pago-editar').value = botonEditar.dataset.pago;
    }
    if (botonEliminar) {
        Swal.fire({
            icon: "warning",
            text: "¿Quieres eliminar este provedor?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, eliminar",
          }).then((result) => {
            if (result.isConfirmed) {
                eliminar_provedor(botonEliminar.dataset.id);
                console.log('eliminar');
                
            }
        });
    }
});