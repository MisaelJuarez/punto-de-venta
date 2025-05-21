let tabla;

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
        document.getElementById('fecha').value = respuesta[0]['corte_fecha'];
        document.getElementById('hora').value = respuesta[0]['corte_hora'];
        document.getElementById('usuario').value = respuesta[0]['corte_usuario'];
        
        document.getElementById('contado').value = respuesta[0]['corte_contado'];
        document.getElementById('calculado').value = respuesta[0]['corte_calculado'];
        document.getElementById('diferencia').value = respuesta[0]['corte_diferencia'];

        document.getElementById('total').value =  respuesta[0]['corte_contado'];

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