<?php
if (!isset($_SESSION['usuario'])) {
    header("location:login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corte de caja</title>
</head>
<body>

    <h1 class="text-center">Corte de caja</h1>
    <div class="container">
        <div class="row mt-5">
            <div class="col-2"></div>
            <div class="col-8">
                <table class="table table-bordered border-primary" id="table_corte">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Contado</th>
                            <th scope="col">Calculado</th>
                            <th scope="col">Diferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="contado">
                            <th scope="row">
                                Efectivo 
                                <button 
                                    class="btn btn-outline-dark ms-3"
                                    data-bs-toggle="modal" data-bs-target="#calculadora">
                                    <i class="bi bi-calculator"></i>
                                </button>
                            </th>
                            <td><input value="0.00" id="contado_efectivo" type="text" class="contado text-end pe-2"></td>
                            <td><input value="0.00" id="calculado_efectivo" type="text" class="contado text-end pe-2" disabled readonly></td>
                            <td><input value="0.00" id="diferencia_efectivo" type="text" class="contado text-end pe-2" disabled readonly></td>
                        </tr>
                        <tr>
                            <th scope="row">Tarjeta</th>
                            <td><input value="0.00" id="contado_tarjeta" type="text" class="text-end pe-2"></td>
                            <td><input value="0.00" id="calculado_tarjeta" type="text" class="text-end pe-2" disabled readonly></td>
                            <td><input value="0.00" id="diferencia_tarjeta" type="text" class="text-end pe-2" disabled readonly></td>
                        </tr>
                        <tr>
                            <th scope="row">Tranferencia</th>
                            <td><input value="0.00" id="contado_transferencia" type="text" class="text-end pe-2"></td>
                            <td><input value="0.00" id="calculado_transferencia" type="text" class="text-end pe-2" disabled readonly></td>
                            <td><input value="0.00" id="diferencia_transferencia" type="text" class="text-end pe-2" disabled readonly></td>
                        </tr>
                        <tr>
                            <th scope="row">Total</th>
                            <td><input value="0.00" id="contado_total" type="text" class="text-end pe-2 text-success" disabled readonly></td>
                            <td><input value="0.00" id="calculado_total" type="text" class="text-end pe-2 text-success" disabled readonly></td>
                            <td><input value="0.00" id="diferencia_total" type="text" class="text-end pe-2" disabled readonly></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-2">
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-2"></div>
            <div class="col-8 d-flex justify-content-center">
                <button type="button" class="btn btn-primary w-25" id="btn_guardar">Guardar</button>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <div class="modal fade" id="calculadora" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="calculadoraLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Calcula tu dinero en fisico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <p>CANTIDAD</p>
                            </div>
                            <div class="col-md-4 ms-auto">
                                <P>DENOM.</P>
                            </div>
                            <div class="col-md-4 ms-auto">
                                <P>TOTAL</P>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="1000" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 1,000.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_0" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="500" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 500.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_1" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="200" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 200.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_2" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="100" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 100.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_3" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="50" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 50.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_4" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="20" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 20.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_5" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="10" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 10.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_6" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 id ms-auto">
                                <input value="0" id="5" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 5.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_7" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="2" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 2.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_8" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="1" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 1.00</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_9" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="0.50" class="form-control form-control-sm text-end cantidad" type="text">
                            </div>
                            <div class="col-md-4 ms-auto">X $ 0.50</div>
                            <div class="col-md-4 ms-auto">
                                <input value="0" id="t_10" class="form-control form-control-sm text-end total" type="text" disabled readonly>
                            </div>
                        </div>

                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="aceptar_calculadora">Aceptar</button>
                    <div class="d-flex align-items-center">
                        <div class="px-3 fs-4">TOTAL:</div>
                        <input class="form-control form-control-sm text-end" type="text" id="cantidad_total" disabled readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="<?=JS."corte.js"?>"></script>
</body>
</html>