let tabla, productos = '',precio = 0, cambio = 0, pagos = 0, efectivo = 0, tarjeta = 0, transferencia = 0;

const obtener_datos_caja = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_datos_caja');
    
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
                    {
                        data: 'producto_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-success agregar_producto" id="agregar" 
                                    data-id="${data}" 
                                >
                                    Agregar
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

const productos_vender = () => {
    let data = new FormData();
    data.append('metodo', 'productos_vender');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        productos = '', precio = 0;
        document.getElementById('generar_venta').disabled  = (respuesta == 0) ? true : false;
        respuesta.map((producto) => {
            productos += `
                <tr>
                    <td>${producto['producto_codigo']}</td>
                    <td>${producto['producto_nombre']}</td>
                    <td>
                        <input type="number" value="${producto['venta_cantidad']}" class="w-25 cantidad_producto" 
                               data-venta="${producto['venta_id']}"
                        >
                    </td>
                    <td>$<span id="precio_producto_${producto['venta_id']}">${producto['venta_cantidad'] * producto['producto_precio']}</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger w-50 eliminar_producto" data-id="${producto['venta_id']}">
                            <i class="bi bi-trash-fill fs-5" data-id="${producto['venta_id']}"></i>
                        </button>
                    </td>
                </tr>
            `
            precio += producto['venta_cantidad'] * producto['producto_precio'];
        });
        document.getElementById('productos_vender').innerHTML = productos;
        document.getElementById('precio_total').textContent = parseFloat(precio).toFixed(2);
        document.getElementById('total_pagar').textContent = parseFloat(precio).toFixed(2);
        document.getElementById('pagar_efectivo').value = parseFloat(precio).toFixed(2);
        document.getElementById('pagar_tarjeta').value = '0.00';
        document.getElementById('pagar_transferencia').value = '0.00';
    });
}

const agregar_producto_vender = (id_producto) => {
    let data = new FormData();
    data.append('metodo','agregar_producto_vender');
    data.append('id_producto',id_producto);
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({
                position: "top-end",
                icon: "success",
                title: `${respuesta[1]}`,
                showConfirmButton: false,
                timer: 500
            });
            productos_vender();
        } else if(respuesta[0] == 0){
            await Swal.fire({
                icon: "warning",
                title: `${respuesta[1]}`,
            });
        }
    });
}

const eliminar_producto = (id_venta) => {
    let data = new FormData();
    data.append('metodo','eliminar_producto_vender');
    data.append('id_venta',id_venta);
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({
                position: "top-end",
                icon: "success",
                title: `${respuesta[1]}`,
                showConfirmButton: false,
                timer: 500
            });
            productos_vender();
        }
    });
}

const aumentar_cantidad = (id,cantidad) => { 
    let data = new FormData();
    data.append('id',id);
    data.append('cantidad',cantidad);
    data.append('metodo','aumentar_cantidad');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            productos_vender();
        }
    });
}

const reiniciando_ventas = () => {
    let data = new FormData();
    data.append('metodo','reiniciando_ventas');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            productos_vender();
            cantidad_por_acabarse();
        }
    });
}

const calculando_total_venta = (efectivo,tarjeta,transferencia) => {
    let data = new FormData();
    data.append('efectivo',efectivo);
    data.append('tarjeta',tarjeta);
    data.append('transferencia',transferencia);
    data.append('metodo','calculando_total_venta');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({
                position: "top-end",
                icon: "success",
                title: `${respuesta[1]}`,
                showConfirmButton: false,
                timer: 1000
            });
            const modal =  bootstrap.Modal.getInstance(document.getElementById('vender'));
            modal.hide();
            reiniciando_ventas()
        }
    });
}

document.addEventListener('DOMContentLoaded',() => {
    productos_vender();
});

document.getElementById('btn-buscar').addEventListener('click',() => {
    obtener_datos_caja();
});

document.getElementById('productos_vender').addEventListener('focus',(e) => {
    if (e.target.matches('.cantidad_producto')) {
        e.target.select();
    }
}, true);
document.getElementById('productos_vender').addEventListener('click',(e) => {
    if (e.target.closest('.eliminar_producto')) {
        eliminar_producto(e.target.dataset.id);
    }
});
document.getElementById('productos_vender').addEventListener('input',(e) => {
    if (e.target.matches('.cantidad_producto')) {
        if (e.target.value <= 0) {
            e.target.value = 1;
        }
        aumentar_cantidad(e.target.dataset.venta,e.target.value);
    }
});

document.getElementById('buscar').addEventListener('click', (e) => {
    if (e.target.matches('.agregar_producto')) {
        agregar_producto_vender(e.target.dataset.id);
    }
});

document.getElementById('pagar_efectivo').addEventListener('focus', (e) => {
    e.target.select();
});
document.getElementById('pagar_tarjeta').addEventListener('focus', (e) => {
    e.target.select();
});
document.getElementById('pagar_transferencia').addEventListener('focus', (e) => {
    e.target.select();
});

document.getElementById('pagar_efectivo').addEventListener('input', (e) => {
    pagos = (parseFloat(e.target.value) + parseFloat(document.getElementById('pagar_tarjeta').value) + parseFloat(document.getElementById('pagar_transferencia').value)).toFixed(2)
    cambio = (pagos - parseFloat(document.getElementById('total_pagar').textContent)).toFixed(2);
   
    if (isNaN(cambio)) {
        document.getElementById('vender_productos').disabled  = true;
        document.getElementById('contenedor-cambio').classList.remove('text-success');
        document.getElementById('contenedor-cambio').classList.add('text-danger');
    }else if (cambio < 0) {
        document.getElementById('vender_productos').disabled  = true;
        document.getElementById('contenedor-cambio').classList.remove('text-success');
        document.getElementById('contenedor-cambio').classList.add('text-danger');
    }else {

        document.getElementById('vender_productos').disabled  = false;
        document.getElementById('contenedor-cambio').classList.remove('text-danger');
        document.getElementById('contenedor-cambio').classList.add('text-success');
    }
    document.getElementById('cambio').textContent = cambio;
});

document.getElementById('pagar_tarjeta').addEventListener('input', (e) => {
    pagos = (parseFloat(e.target.value) + parseFloat(document.getElementById('pagar_efectivo').value) + parseFloat(document.getElementById('pagar_transferencia').value)).toFixed(2)
    cambio = (pagos - parseFloat(document.getElementById('total_pagar').textContent)).toFixed(2);
   
    if (isNaN(cambio)) {
        document.getElementById('vender_productos').disabled  = true;
        document.getElementById('contenedor-cambio').classList.remove('text-success');
        document.getElementById('contenedor-cambio').classList.add('text-danger');
    }else if (cambio < 0) {
        document.getElementById('vender_productos').disabled  = true;
        document.getElementById('contenedor-cambio').classList.remove('text-success');
        document.getElementById('contenedor-cambio').classList.add('text-danger');
    }else {

        document.getElementById('vender_productos').disabled  = false;
        document.getElementById('contenedor-cambio').classList.remove('text-danger');
        document.getElementById('contenedor-cambio').classList.add('text-success');
    }
    document.getElementById('cambio').textContent = cambio;
});

document.getElementById('pagar_transferencia').addEventListener('input', (e) => {
    pagos = (parseFloat(e.target.value) + parseFloat(document.getElementById('pagar_tarjeta').value) + parseFloat(document.getElementById('pagar_efectivo').value)).toFixed(2)
    cambio = (pagos - parseFloat(document.getElementById('total_pagar').textContent)).toFixed(2);
   
    if (isNaN(cambio)) {
        document.getElementById('vender_productos').disabled  = true;
        document.getElementById('contenedor-cambio').classList.remove('text-success');
        document.getElementById('contenedor-cambio').classList.add('text-danger');
    }else if (cambio < 0) {
        document.getElementById('vender_productos').disabled  = true;
        document.getElementById('contenedor-cambio').classList.remove('text-success');
        document.getElementById('contenedor-cambio').classList.add('text-danger');
    }else {

        document.getElementById('vender_productos').disabled  = false;
        document.getElementById('contenedor-cambio').classList.remove('text-danger');
        document.getElementById('contenedor-cambio').classList.add('text-success');
    }
    document.getElementById('cambio').textContent = cambio;
});
document.getElementById('vender_productos').addEventListener('click', () => {
    efectivo = document.getElementById('pagar_efectivo').value;
    tarjeta = document.getElementById('pagar_tarjeta').value;
    transferencia = document.getElementById('pagar_transferencia').value;

    efectivo = efectivo - cambio;

    calculando_total_venta(parseFloat(efectivo).toFixed(2),parseFloat(tarjeta).toFixed(2),parseFloat(transferencia).toFixed(2));
});