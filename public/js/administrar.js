let tabla,id_usuario;
const modaleditar = document.getElementById('modal-editar');

const obtener_datos = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_datos_usuarios');
    
    fetch("app/controller/usuario.php", {
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
                    { data: 'usuario_usuario' }, 
                    { data: 'usuario_apellidos' }, 
                    { data: 'usuario_correo' }, 
                    {
                        data: 'usuario_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-warning w-25 editar-usuario"
                                    data-bs-toggle="modal" data-bs-target="#modal-editar"
                                    data-id="${data}" 
                                    data-nombre="${row.usuario_usuario}" 
                                    data-apellidos="${row.usuario_apellidos}" 
                                    data-correo="${row.usuario_correo}"   
                                >
                                    Editar
                                </button>
                                <button class="btn btn-danger w-25 eliminar-usuario" 
                                    data-id="${data}" 
                                >
                                    Eliminar
                                </button>
                            `;
                        }
                    }
                ],
                "pageLength": 5,
                language: { url: "./public/json/lenguaje.json" }
            });
        }
    });
};

const editar_usuario = () => {
    let data = new FormData(document.getElementById('forumulario-editar'));
    data.append("id_usuario",id_usuario);
    data.append("metodo","editar_usuario");
    fetch("./app/controller/usuario.php",{
        method:"POST",
        body:data
    }).then(respuesta => respuesta.json())
    .then(async respuesta => { 
        if(respuesta[0] == 1){
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalEditar = bootstrap.Modal.getInstance(modaleditar); 
            if (modalEditar) {
                modalEditar.hide();
            }  
            document.getElementById('forumulario-editar').reset();
            obtener_datos();
        }else if (respuesta[0] == 0){
            Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    });
}

const eliminar_usuario = (id) => {
    let data = new FormData();
        data.append("id_usuario",id);
        data.append("metodo","eliminar_usuario");
        fetch("./app/controller/usuario.php",{
            method:"POST",
            body:data
        }).then(respuesta => respuesta.json())
        .then(async respuesta => { 
            if(respuesta[0] == 1){
                await Swal.fire({icon: "success",title:`${respuesta[1]}`});
                obtener_datos();
            }else if(respuesta[0] == 0){
                Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    });
}

document.getElementById('editar-usuario').addEventListener('click',() => {
    editar_usuario();
});

document.addEventListener('DOMContentLoaded', () => {
    obtener_datos();
});

document.getElementById('myTable').addEventListener('click', (e) => {
    const botonEditar = e.target.closest('.editar-usuario');
    const botonEliminar = e.target.closest('.eliminar-usuario');
    if (botonEditar) {
        id_usuario = botonEditar.dataset.id;
        document.getElementById('nombre-editar').value = botonEditar.dataset.nombre;
        document.getElementById('apellidos-editar').value = botonEditar.dataset.apellidos;
        document.getElementById('correo-editar').value = botonEditar.dataset.correo;
    }
    if (botonEliminar) {
        Swal.fire({
            icon: "warning",
            text: "Quieres eliminar este usuario?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar"
          }).then((result) => {
            if (result.isConfirmed) {
                eliminar_usuario(botonEliminar.dataset.id);
            }
        });
    }
});