<!DOCTYPE html>
@extends('adminlte::page')
@section('title', 'Pedidos')

@section('content_header')
<style>
    #flexSwitchCheckDefault {
        width: 40px;
        height: 20px;
    }

    .txt-ACTIVO {
        color: green;
    }

    .txt-INACTIVO {
        color: red;
        font-weight: bold;
    }

    .form-chexbox-radio {
        width: 1.5rem;
        height: 1.5rem;
    }
</style>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h1>Pedidos a Distribuidor</h1>
    </div>
</div>
<div class="card">
    <div class="card-body">

        <table id="tb" class="table table-striped table-bordered shadow-lg mt-4 table-responsive-xl">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Distribuidor</th>
                    <th scope="col">Medicamento</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Farmacia</th>
                    <th scope="col">
                        <a href="#cont" data-toggle="modal" title="Crear Nuevo pedido" class="btn btn-success"><i class="fas fa-plus"></i> Nuevo</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $p)
                <?php $id = $p->idPedido; ?>
                <tr>
                    <td>{{$p->idPedido}}</td>
                    <td>{{$p->proveedor_med}}</td>
                    <td>{{$p->nombre_med}}</td>
                    <td>{{$p->tipo_med}}</td>
                    <td>{{$p->cantidad}}</td>
                    <?php
                    $pp = ($p->f_principal == 1) ? 'SI' : 'NO';
                    $sc = ($p->f_secundaria == 1) ? 'SI' : 'NO';
                    ?>
                    <td>Ppal: [<?php echo $pp; ?>] Secd: [<?php echo $sc; ?>]</td>
                    <td><a href="pedidos/<?php echo $id; ?>/edit" class='btn btn-primary'><i class='fas fa-edit'></i></a> <a href='#' onclick='confirmarEliminacion(event, <?php echo $id; ?>)' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
<link rel=" stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="vendor/pdfmake/pdfmake.min.js"></script>
<script src="vendor/pdfmake/vfs_fonts.js"></script>
<script src="vendor/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="vendor/datatables-buttons/js/buttons.print.min.js"></script>
<script src="vendor/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="vendor/jszip/jszip.min.js"></script>

<script>
    const formatter = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
    });

    /*
    axios.get('{{ route("pedidos.getDataPedidos") }}')
        .then(response => {
            let query = response.data.data;
            console.log(response);
             $(document).ready(function() {
                $("#tb").DataTable({
                    data: query,
                    "order": [0, 'DESC'],
                    "columns": [{
                            "data": "idPedido"
                        },
                        {
                            "data": "proveedor_med"
                        },
                        {
                            "data": "nombre_med"
                        },
                        {
                            "data": "f_principal"
                        },
                        {
                            "data": null,
                            render: function(data, type, row) {
                                return "<a href='pedidos/" + data['idPedido'] + "/edit' class='btn btn-primary'><i class='fas fa-edit'></i></a> <a href='#' onclick='confirmarEliminacion(event, " + data['idPedido'] + ")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a>"
                            }
                        }
                    ],
                    bJQueryUI: true,
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "pageLength": 10,
                    "buttons": ["excel", "pdf", "print"]
                }).buttons().container().appendTo('#tb_wrapper .col-md-6:eq(0)');
            });
        })
        .catch(error => {
            console.error('Hubo un error al obtener los datos: ', error);
        });
*/

    function confirmarEliminacion(event, id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "¿Estás seguro de que deseas eliminar este registro?",
            text: "Esta acción no se podra revertir!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No, cancelar!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                if (id) {
                    axios.delete(`/pedidos/${id}`)
                        .then(function(response) {
                            if (response.status == 200) {
                                swalWithBootstrapButtons.fire({
                                    title: "Eliminado!",
                                    text: "Los registros fueron eliminados!",
                                    icon: "success"
                                }).then((result) => {
                                    window.location.href = '/pedidos';
                                });
                            } else {
                                AlertSweet("Error!", "Se produjo un error durante el proceso de eliminación, notificar al administrador del sistema", "error");
                            }
                        })
                        .catch(function(error) {
                            let errsms = error.response.data.message;
                            console.error(errsms);
                            if (errsms.includes("SQLSTATE[23000]")) {
                                errsms = 'SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails';
                            }
                            AlertSweet("Error!", errsms, "error");
                        });
                }
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Proceso cancelado",
                    text: "Your imaginary file is safe :)",
                    icon: "error"
                });
            }
        });
    }
</script>
@stop


<div class="modal fade" tabindex="-1" id="cont">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">Crear Pedido al Distribuidor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <p>
                            <center>
                                <form action="/pedidos" method="post" id="medicamentoForm">
                                    {{ csrf_field() }}
                                    <div class="row g-3">
                                        <!-- Nombre del Medicamento -->
                                        <div class="col-md-12">
                                            <label for="nombre_medicamento" class="form-label">Nombre del Medicamento</label>
                                            <input type="text" class="form-control" name="nombre_medicamento" id="nombre_medicamento" required placeholder="Ingrese el nombre del medicamento">
                                            <span id="nombre_medicamento-error" class="text-danger"></span>
                                        </div>

                                        <!-- Tipo del Medicamento -->
                                        <div class="col-md-12">
                                            <label for="tipo_medicamento" class="form-label">Tipo de Medicamento</label>
                                            <select name="tipo_medicamento" id="tipo_medicamento" class="form-control" required>
                                                <option value="">Seleccione el tipo...</option>
                                                <option value="ANALGESICO">ANALGÉSICO</option>
                                                <option value="ANALEPTICO">ANALÉPTICO</option>
                                                <option value="ANESTESICO">ANESTÉSICO</option>
                                                <option value="ANTIACIDO">ANTIÁCIDO</option>
                                                <option value="ANTIDEPRESIVO">ANTIDEPRESIVO</option>
                                                <option value="ANTIBIOTICOS">ANTIBIOTICOS</option>
                                                <option value="OTROS">OTROS</option>
                                            </select>
                                            <span id="tipo_medicamento-error" class="text-danger"></span>
                                        </div>

                                        <!-- Cantidad del Producto -->
                                        <div class="col-md-12">
                                            <label for="cantidad_producto" class="form-label">Cantidad de Producto</label>
                                            <input type="number" class="form-control" name="cantidad_producto" id="cantidad_producto" required placeholder="Ingrese la cantidad">
                                            <span id="cantidad_producto-error" class="text-danger"></span>
                                        </div>

                                        <!-- Distribuidor Farmacéutico -->
                                        <div class="col-md-12">
                                            <label class="form-label">Distribuidor Farmacéutico</label>
                                            <div class="form-check form-check-inline">
                                                <div class="form-check">
                                                    <input class="form-check-input form-chexbox-radio" type="radio" name="distribuidor" id="distribuidor1" value="Cofarma" required>
                                                    <label class="form-check-label" for="distribuidor1">Cofarma</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input form-chexbox-radio" type="radio" name="distribuidor" id="distribuidor2" value="Empsephar" required>
                                                    <label class="form-check-label" for="distribuidor2">Empsephar</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input form-chexbox-radio" type="radio" name="distribuidor" id="distribuidor3" value="Cemefar" required>
                                                    <label class="form-check-label" for="distribuidor3">Cemefar</label>
                                                </div>
                                            </div>
                                            <span id="distribuidor-error" class="text-danger"></span>
                                        </div>

                                        <!-- Sucursal de la Farmacia -->
                                        <div class="col-md-12">
                                            <label class="form-label">Sucursal de la Farmacia</label>
                                            <div class="form-check form-check-inline">
                                                <div class="form-check">
                                                    <input class="form-check-input form-chexbox-radio" type="checkbox" name="sucursal[]" id="sucursal_principal" value="principal">
                                                    <label class="form-check-label" for="sucursal_principal">Principal</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input form-chexbox-radio" type="checkbox" name="sucursal[]" id="sucursal_secundaria" value="secundaria">
                                                    <label class="form-check-label" for="sucursal_secundaria">Secundaria</label>
                                                </div>
                                            </div>
                                            <span id="sucursal-error" class="text-danger"></span>
                                        </div>

                        </p>
                        </center>
                    </div><!-- /.fin div card-body -->

                </div><!-- /.fin div card -->
            </div><!-- /.fin div modal-body -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="far fa-window-close"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="resetform()">Limpiar</button>
                <a href="#" id="btnEnvio" class="btn btn-success disabled"><i class="far fa-save"></i> Confirmar</a>
                </form>
                <br>
                <div class="justify-content-center">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    document.getElementById('cantidad_producto').addEventListener('blur', function() {
        var dni = this.value;
        if (/^\d+$/.test(dni) && parseInt(dni) > 0) {
            $('#btnEnvio').removeClass('disabled');
        } else {
            $('#btnEnvio').addClass('disabled');
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Por favor, introduce un número entero positivo."
            });
        }
    });

    function AlertSweet(title, text, icon) {
        Swal.fire({
            title,
            text,
            icon
        });
    }

    function resetform() {
        $("#medicamentoForm")[0].reset();
    }

    document.getElementById('btnEnvio').addEventListener('click', function() {
        const nom = document.getElementById('nombre_medicamento').value;
        const tipo = document.getElementById('tipo_medicamento').value;
        const cant = document.getElementById('cantidad_producto').value;
        const distribuidor = document.querySelector('input[name="distribuidor"]:checked');
        const sucursales = document.querySelectorAll('input[name="sucursal[]"]:checked');
        const regex = /^[a-zA-Z0-9\s]+$/;

        //Validar los campos y datos
        if (nom === '' || nom.length === 0 || !regex.test(nom)) {
            document.getElementById('nombre_medicamento').classList.add('bg-warning');
            document.getElementById('nombre_medicamento').setCustomValidity('Debe contener solo caracteres alfanuméricos.');
        } else {
            document.getElementById('nombre_medicamento').classList.remove('bg-warning');
            if (tipo === '' || tipo.length === 0) {
                document.getElementById('tipo_medicamento').classList.add('bg-warning');
                document.getElementById('nombre_medicamento').setCustomValidity('');
            } else {
                document.getElementById('tipo_medicamento').classList.remove('bg-warning');
                if (cant === '' || cant.length === 0 || cant <= 0) {
                    document.getElementById('cantidad_producto').classList.add('bg-warning');
                } else {
                    document.getElementById('cantidad_producto').classList.remove('bg-warning');

                    if (!distribuidor) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Por favor, seleccione un distribuidor."
                        });
                        return;
                    }

                    if (sucursales.length === 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Por favor, seleccione al menos una sucursal."
                        });
                        return;
                    }

                    const dist = document.querySelector('input[name="distribuidor"]:checked').value;

                    // Obtener las sucursales seleccionadas
                    let sucursalTexto = '';
                    const sucursalesSeleccionadas = document.querySelectorAll('input[name="sucursal[]"]:checked');
                    if (sucursalesSeleccionadas.length > 0) {
                        sucursalesSeleccionadas.forEach((sucursal) => {
                            if (sucursal.value === 'principal') {
                                sucursalTexto += '[Principal] en Calle de la Rosa No. 28 ';
                            } else if (sucursal.value === 'secundaria') {
                                if (sucursalTexto) sucursalTexto += ' y ';
                                sucursalTexto += '[Secundaria] en Calle Alcazabilla No. 3 ';
                            }
                        });
                    }

                    // Crear el resumen del pedido
                    const resumenPedido = `${cant} unidades del ${tipo} ${nom} Para la farmacia situada: ${sucursalTexto}.`;

                    // Mostrar SweetAlert con el resumen del pedido
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        buttonsStyling: false
                    });
                    swalWithBootstrapButtons.fire({
                        title: `Pedido al distribuidor ${dist}`,
                        html: `<p>${resumenPedido}</p>`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Si, Guardar",
                        cancelButtonText: "No, Cancelar!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            swalWithBootstrapButtons.fire({
                                title: "Todo Ok!",
                                text: "Su información fue almacenada correctamente",
                                icon: "success"
                            });
                            document.getElementById('medicamentoForm').submit();
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire({
                                title: "Canceledo",
                                text: "Su información NO se guardo",
                                icon: "error"
                            });
                        }
                    });

                }
            }
        }
    });
</script>