let tabla,compras = '';

let detalles_permiso;
const redireccionar = () => {
    let data = new FormData();
    data.append('metodo','obtener_permisos');
    fetch("app/controller/usuario.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        detalles_permiso = respuesta[0].rol_detalles.split(',');        
        
        if (detalles_permiso.filter(p => p == 'ver_detalles').length <= 0){
            window.location.href = 'inicio';
        } 
    });
}

const obtener_cortes_caja = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_cortes_caja');
    
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
                    { data: 'corte_fecha' }, 
                    { data: 'corte_hora' }, 
                    { data: 'corte_usuario' }, 
                    {
                        data: 'corte_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-success visualizar_producto" 
                                    data-id="${data}" 
                                    data-bs-dismiss="modal"
                                >
                                    visualizar
                                </button>
                            `;
                        }
                    }
                ],
                "lengthChange": false,
                "pageLength": 5,
                "info": false,
                language: { url: "./public/json/lenguaje.json" },
                dom: '<"custom-toolbar"lf>tip',
                initComplete: () => {
                    $("div.custom-toolbar .dataTables_filter").prependTo(".custom-toolbar").addClass("left-section");
                }
            });
        }
    });
};

const obtener_compras_por_fecha = (fecha) => {
    compras = '';
    let data = new FormData();
    data.append('metodo','obtener_compras_por_fecha');
    data.append('fecha',fecha);
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        respuesta.map((compra => {
            compras += `
                <div class="col-1">
                    <p class="mb-3">Fecha:</p>
                    <p class="mb-3">Hora:</p>
                    <p class="mb-3">Usuario:</p>
                </div>
                <div class="col-2">
                    <input class="form-control form-control-sm text-end mb-2" value="${compra['comprar_fecha']}" disabled readonly>
                    <input class="form-control form-control-sm text-end mb-2" value="${compra['comprar_hora']}" disabled readonly>
                    <input class="form-control form-control-sm text-end mb-2" value="${compra['comprar_usuario']}" disabled readonly>
                </div>
                <div class="col-1">
                    <p class="mb-3">Provedor:</p>
                    <p class="mb-3">Total:</p>
                </div>
                <div class="col-2">
                    <input class="form-control form-control-sm text-end mb-2" value="${compra['comprar_provedor']}" disabled readonly>
                    <input class="form-control form-control-sm text-end mb-2" value="${compra['comprar_total']}" disabled readonly>
                </div>
                <div class="col-6"></div>
                <hr>
            `;
        }));
        document.getElementById('compras_hechas').innerHTML = compras;
    });
}

const visualizar_corte = (id) => {
    let data = new FormData();
    data.append('metodo','visualizar_corte');
    data.append('id_corte',id);
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        console.log(respuesta);
        document.getElementById('fecha').value = respuesta[0]['corte_fecha'];
        document.getElementById('hora').value = respuesta[0]['corte_hora'];
        document.getElementById('usuario').value = respuesta[0]['corte_usuario'];
        
        document.getElementById('contado').value = respuesta[0]['corte_contado'];
        document.getElementById('calculado').value = respuesta[0]['corte_calculado'];
        document.getElementById('diferencia').value = respuesta[0]['corte_diferencia'];

        document.getElementById('total').value =  respuesta[0]['corte_contado'];
        
        obtener_compras_por_fecha(respuesta[0]['corte_fecha']);
    });
}

document.getElementById('btn-buscar-corte').addEventListener('click', () => {
    obtener_cortes_caja();
});

document.getElementById('myTable').addEventListener('click', (e) => {
    if (e.target.closest('.visualizar_producto')) {
        visualizar_corte(e.target.dataset.id);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    redireccionar();
})