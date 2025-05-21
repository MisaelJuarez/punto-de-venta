let productos = '', tablaProvedor, tableProducto, tablaProductoAcabarse,total_compras = 0,id_producto;
const modal = document.getElementById('generar-compra');

const obtener_provedores = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_provedores');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        if (tablaProvedor) {
            tablaProvedor.clear().rows.add(respuesta).draw(); 
        } else {
            tablaProvedor = $('#tableProvedor').DataTable({
                data: respuesta, 
                columns: [
                    { data: 'provedor_nombre' }, 
                    { data: 'provedor_empresa' }, 
                    { data: 'provedor_telefono' }, 
                    { data: 'provedor_email' }, 
                    {
                        data: 'provedor_id',
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-success seleccionar_provedor" 
                                    data-bs-dismiss="modal"
                                    data-id="${data}" 
                                    data-nombre="${row.provedor_nombre}" 
                                    data-empresa="${row.provedor_empresa}" 
                                >
                                    Seleccionar
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

const obtener_productos = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_datos');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        if (tableProducto) {
            tableProducto.clear().rows.add(respuesta).draw(); 
        } else {
            tableProducto = $('#tableProducto').DataTable({
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
                                <button class="btn btn-success comprar-producto" id="comprar" 
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal" data-bs-target="#comprar-producto"
                                    data-id="${data}" 
                                    data-codigo="${row.producto_codigo}" 
                                    data-nombre="${row.producto_nombre}" 
                                    data-pcompra="${row.producto_pCompra}" 
                                    data-pcosto="${row.producto_pCosto}" 
                                    data-ucompra="${row.producto_uCompra}"
                                    data-uventa="${row.producto_uVenta}"
                                    data-cantidad="${row.producto_cantidad}" 
                                    data-precio="${row.producto_precio}"  
                                >
                                    Comprar
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

const productos_por_comprar = () => {
    let data = new FormData();
    data.append('metodo', 'productos_por_comprar');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        if (tablaProductoAcabarse) {
            tablaProductoAcabarse.clear().rows.add(respuesta).draw(); 
        } else {
            tablaProductoAcabarse = $('#tableAcabarse').DataTable({
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
                                <button class="btn btn-success comprar-producto" id="comprar" 
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal" data-bs-target="#comprar-producto"
                                    data-id="${data}" 
                                    data-codigo="${row.producto_codigo}" 
                                    data-nombre="${row.producto_nombre}" 
                                    data-pcompra="${row.producto_pCompra}" 
                                    data-pcosto="${row.producto_pCosto}"
                                    data-ucompra="${row.producto_uCompra}"
                                    data-uventa="${row.producto_uVenta}"
                                    data-cantidad="${row.producto_cantidad}" 
                                    data-precio="${row.producto_precio}"  
                                >
                                    Comprar
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

const agregar_lista_producto = () => {
    let data = new FormData();
    data.append('id',id_producto);
    data.append('codigo',document.getElementById('codigo').value);
    data.append('nombre-producto',document.getElementById('nombre-producto').value);
    data.append('cantidad-comprar',parseInt(document.getElementById('cantidad-comprar').value));
    data.append('precio-comprar',parseFloat(document.getElementById('precio-comprar').value).toFixed(2));
    data.append('metodo','agregar_lista_producto');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            document.getElementById('formulario-comprar').reset();
            obtener_lista_comprar();
        } else if(respuesta[0] == 0) {
            Swal.fire({
                title: `${respuesta[1]}`,
                icon: "error"
            });
        }
    })
}

const obtener_lista_comprar = () => {
    productos = '';
    total_compras = 0;
    let data = new FormData();
    data.append('metodo', 'obtener_lista_comprar');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        document.getElementById('realizar-compra').disabled  = (respuesta == 0) ? true : false;
        respuesta.map((producto) => {
            total_compras += producto['lista_total'];
            productos += `
                <tr>
                    <td>${producto['lista_cantidad']}</td>
                    <td>${producto['lista_codigo']}</td>
                    <td>${producto['lista_producto']}</td>
                    <td>$${producto['lista_precio']}</td>                    
                    <td>$${producto['lista_total']}</td>
                    <td>
                        <button type="button" class="btn btn-danger w-50 eliminar_producto" data-id="${producto['lista_id']}">
                            <i class="bi bi-trash-fill fs-5" data-id="${producto['lista_id']}"></i>
                        </button>
                    </td>
                </tr>
            `
        });
        document.getElementById('lista-comprar').innerHTML = productos;
        document.getElementById('total-compras').textContent = parseFloat(total_compras).toFixed(2);
    });
}

const eliminar_producto_lista = (id) => {
    let data = new FormData();
    data.append('id',id);
    data.append('metodo','eliminar_producto_lista')
    fetch('app/controller/home.php', {
        method: 'POST',
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            obtener_lista_comprar();
        } else if(respuesta[0] == 0) {
            await Swal.fire({icon: "error",title:`${respuesta[1]}`});
        }
    })
}

const finalizar_compra = () => {
    let data = new FormData();
    data.append('provedor',document.getElementById('provedor-seleccionado').value);
    data.append('total-pagar',document.getElementById('cantidad-pagar').value);
    data.append('forma-pago',document.getElementById('forma-pago').value);
    data.append('metodo','finalizar_compra');
    fetch("app/controller/home.php",{
        method:"POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({icon: "success",title:`${respuesta[1]}`});
            const modalGenerarCompra = bootstrap.Modal.getInstance(modal);
            if (modalGenerarCompra) {
                modalGenerarCompra.hide();
            }  
            document.getElementById('provedor').value = 'Sin provedor';
            obtener_lista_comprar();
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

document.getElementById('seleccionar-provedor').addEventListener('click', () => {
    obtener_provedores();
});

document.getElementById('seleccionar-producto').addEventListener('click', () => {
    obtener_productos();
});

document.getElementById('obtener-productos-acabarse').addEventListener('click', () => {
    productos_por_comprar();
});

document.getElementById('tableProvedor').addEventListener('click', (e) => {
    if (e.target.closest('.seleccionar_provedor')) {
        document.getElementById('provedor').value = `${e.target.dataset.nombre}, ${e.target.dataset.empresa}`;
    }
});

document.getElementById('aceptar').addEventListener('click', () => {
    agregar_lista_producto();
});

document.getElementById('aceptar_compra').addEventListener('click', () => {
    finalizar_compra();
});

document.getElementById('realizar-compra').addEventListener('click', () => {
    document.getElementById('provedor-seleccionado').value = document.getElementById('provedor').value;
    document.getElementById('total-final').textContent = document.getElementById('total-compras').textContent;
    document.getElementById('cantidad-pagar').value = parseFloat(document.getElementById('total-compras').textContent).toFixed(2);
});

document.getElementById('tableProducto').addEventListener('click', (e) => {
    if (e.target.closest('.comprar-producto')) {
        document.getElementById('codigo').value = e.target.dataset.codigo;
        document.getElementById('nombre-producto').value = e.target.dataset.nombre;
        document.getElementById('pCompra').value = e.target.dataset.pcompra;
        document.getElementById('pCosto').value = e.target.dataset.pcosto;
        document.getElementById('cantidad').value = e.target.dataset.cantidad;
        document.getElementById('precio').value = e.target.dataset.precio;
        document.getElementById('uCompra').textContent = e.target.dataset.ucompra;
        document.getElementById('uVenta').textContent = e.target.dataset.uventa;
        id_producto = e.target.dataset.id;
    }
});

document.getElementById('tableAcabarse').addEventListener('click', (e) => {
    if (e.target.closest('.comprar-producto')) {
        document.getElementById('codigo').value = e.target.dataset.codigo;
        document.getElementById('nombre-producto').value = e.target.dataset.nombre;
        document.getElementById('pCompra').value = e.target.dataset.pcompra;
        document.getElementById('pCosto').value = e.target.dataset.pcosto;
        document.getElementById('cantidad').value = e.target.dataset.cantidad;
        document.getElementById('precio').value = e.target.dataset.precio;
        document.getElementById('uCompra').textContent = e.target.dataset.ucompra;
        document.getElementById('uVenta').textContent = e.target.dataset.uventa;
        id_producto = e.target.dataset.id;
    }
});

document.getElementById('lista-comprar').addEventListener('click', (e) => {
    if (e.target.closest('.eliminar_producto')) {
        eliminar_producto_lista(e.target.dataset.id);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    obtener_lista_comprar();
})