let con_efectivo = document.getElementById('contado_efectivo'), con_tarjeta = document.getElementById('contado_tarjeta'),
con_transferencia = document.getElementById('contado_transferencia'), con_total = document.getElementById('contado_total');

let cal_efectivo = document.getElementById('calculado_efectivo'), cal_tarjeta = document.getElementById('calculado_tarjeta'),
cal_transferencia = document.getElementById('calculado_transferencia'), cal_total = document.getElementById('calculado_total');

let dif_efectivo = document.getElementById('diferencia_efectivo'), dif_tarjeta = document.getElementById('diferencia_tarjeta'),
dif_transferencia = document.getElementById('diferencia_transferencia'), dif_total = document.getElementById('diferencia_total');

let inputs_cantidad = document.querySelectorAll('.cantidad'), inputs_total = document.querySelectorAll('.total'),cantidad_total = 0;

const obtener_datos_calculado = () => {
    let data = new FormData();
    data.append('metodo', 'obtener_datos_calculado');
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        if (respuesta.length > 0) {
            cal_efectivo.value = parseFloat(respuesta[0]['calculado_efectivo']).toFixed(2);
            cal_tarjeta.value = parseFloat(respuesta[0]['calculado_tarjeta']).toFixed(2);
            cal_transferencia.value = parseFloat(respuesta[0]['calculado_transferencia']).toFixed(2);
            
            calcular_total(cal_efectivo.value,cal_tarjeta.value,cal_transferencia.value,cal_total);
            calcular_total(con_efectivo.value,con_tarjeta.value,con_transferencia.value,con_total);
    
            calcular_diferencia(con_efectivo,cal_efectivo,dif_efectivo);
            calcular_diferencia(con_tarjeta,cal_tarjeta,dif_tarjeta);
            calcular_diferencia(con_transferencia,cal_transferencia,dif_transferencia);
            calcular_diferencia(con_total,cal_total,dif_total);

        } else {
            con_efectivo.value = '0.00';
            con_tarjeta.value = '0.00';
            con_transferencia.value = '0.00';
            con_total.value = '0.00';

            cal_efectivo.value = '0.00';
            cal_tarjeta.value = '0.00';
            cal_transferencia.value = '0.00';
            cal_total.value = '0.00';

            dif_efectivo.value = '0.00';
            dif_tarjeta.value = '0.00';
            dif_transferencia.value = '0.00';
            dif_total.value = '0.00';
        }

    });
}

const calcular_total = (efectivo,tarjeta,transferencia,total) => {
    total.value = 0;
    total.value = parseFloat(parseFloat(efectivo) + parseFloat(tarjeta) + parseFloat(transferencia)).toFixed(2);
}

const calcular_diferencia = (contado,calculado,diferencia) => {
    diferencia.value = parseFloat(contado.value - calculado.value).toFixed(2);
    if (diferencia.value < 0) {
        diferencia.classList.remove('text-primary');
        diferencia.classList.add('text-danger');
    }else {
        diferencia.classList.remove('text-danger');
        diferencia.classList.add('text-primary');
    }
}

const corte_caja = () => {
    let data = new FormData();
    data.append('metodo', 'corte_caja');
    data.append('contado', document.getElementById('contado_total').value);
    data.append('calculado', document.getElementById('calculado_total').value);
    data.append('diferencia', document.getElementById('diferencia_total').value);
    
    fetch("app/controller/home.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async (respuesta) => {
        if (respuesta[0] == 1) {
            await Swal.fire({
                position: "top-end",
                icon: "success",
                title: `${respuesta[1]}`,
                showConfirmButton: false,
                timer: 1500
              });
            obtener_datos_calculado();
        }else {
            console.log(respuesta[0]);
        }
    });
}

document.getElementById('contado_efectivo').addEventListener('input', () => {
    calcular_diferencia(con_efectivo,cal_efectivo,dif_efectivo);
    calcular_total(con_efectivo.value,con_tarjeta.value,con_transferencia.value,con_total);
    calcular_diferencia(con_total,cal_total,dif_total);
});
document.getElementById('contado_tarjeta').addEventListener('input', () => {
    calcular_diferencia(con_tarjeta,cal_tarjeta,dif_tarjeta);
    calcular_total(con_efectivo.value,con_tarjeta.value,con_transferencia.value,con_total);
    calcular_diferencia(con_total,cal_total,dif_total);
});
document.getElementById('contado_transferencia').addEventListener('input', () => {
    calcular_diferencia(con_transferencia,cal_transferencia,dif_transferencia);
    calcular_total(con_efectivo.value,con_tarjeta.value,con_transferencia.value,con_total);
    calcular_diferencia(con_total,cal_total,dif_total);
});

document.getElementById('calculado_efectivo').addEventListener('input', () => {
    calcular_diferencia(con_efectivo,cal_efectivo,dif_efectivo);
    calcular_total(cal_efectivo.value,cal_tarjeta.value,cal_transferencia.value,cal_total);
    calcular_diferencia(con_total,cal_total,dif_total);
});
document.getElementById('calculado_tarjeta').addEventListener('input', () => {
    calcular_diferencia(con_tarjeta,cal_tarjeta,dif_tarjeta);
    calcular_total(cal_efectivo.value,cal_tarjeta.value,cal_transferencia.value,cal_total);
    calcular_diferencia(con_total,cal_total,dif_total);
});
document.getElementById('calculado_transferencia').addEventListener('input', () => {
    calcular_diferencia(con_transferencia,cal_transferencia,dif_transferencia);
    calcular_total(cal_efectivo.value,cal_tarjeta.value,cal_transferencia.value,con_total);
    calcular_diferencia(con_total,cal_total,dif_total);
});

document.getElementById('calculadora').addEventListener('input', () => {
    cantidad_total = 0;
    inputs_cantidad.forEach((c,i) => {
        document.getElementById(`t_${i}`).value = c.value * c.id
    });
    inputs_total.forEach(t => {
        cantidad_total += parseFloat(t.value);
        document.getElementById('cantidad_total').value = parseFloat(cantidad_total).toFixed(2);
    });
});

document.getElementById('table_corte').addEventListener('focus',(e) => {
    if (e.target.matches('input')) {
        e.target.select();
    }
}, true);
document.getElementById('calculadora').addEventListener('focus',(e) => {

    if (e.target.matches('input')) {
        e.target.select();
    }
}, true);

document.getElementById('aceptar_calculadora').addEventListener('click', () => {
    con_efectivo.value = parseFloat(cantidad_total).toFixed(2);
    calcular_diferencia(con_efectivo,cal_efectivo,dif_efectivo);
    calcular_total(con_efectivo.value,con_tarjeta.value,con_transferencia.value,con_total);
    calcular_diferencia(con_total,cal_total,dif_total);
});

document.getElementById('btn_guardar').addEventListener('click',() => {
    Swal.fire({
        icon: "warning",
        text: "Estas seguro de hacer el corte de caja?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Si"
        }).then((result) => {
        if (result.isConfirmed) {
            corte_caja();
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    obtener_datos_calculado();
});