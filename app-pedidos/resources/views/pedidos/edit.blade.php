@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
<h1>Pedido No. {{$p[0]->idPedido}}</h1>
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
        <!-- Main content -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Pedido:</strong> {{$p[0]->fechaPedido}} - <strong>Medicamento:</strong> {{$p[0]->nombre_med}} <strong>Proveedor:</strong> {{$p[0]->proveedor_med}}</h5>
            </div>
            <div class="modal-body">
                <form action="/pedidos/{{$p[0]->idPedido}}" method="POST" id="medicamentoForm" name="medicamentoForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nombre_medicamento" class="form-label">Nombre del Medicamento</label>
                        <input type="text" class="form-control" name="nombre_medicamento" id="nombre_medicamento" required placeholder="Ingrese el nombre del medicamento" value="{{$p[0]->nombre_med}}" />
                        <span id="nombre_medicamento-error" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="tipo_medicamento" class="form-label">Tipo de Medicamento</label>
                        <select name="tipo_medicamento" id="tipo_medicamento" class="form-control" required>
                            <option value="{{$p[0]->tipo_med}}">{{$p[0]->tipo_med}}</option>
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
                    <div class="form-group">
                        <label for="cantidad_producto" class="form-label">Cantidad de Producto</label>
                        <input type="number" class="form-control" name="cantidad_producto" id="cantidad_producto" required placeholder="Ingrese la cantidad" value="{{$p[0]->cantidad}}">
                        <span id="cantidad_producto-error" class="text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Distribuidor Farmacéutico</label>
                        <div class="form-check-inline">
                            <div class="form-check">
                                <input class="form-check-input form-chexbox-radio" type="radio" name="distribuidor" id="distribuidor1" value="Cofarma" required {{ $p[0]->proveedor_med === 'COFARMA' ? 'checked' : '' }}>
                                <label class="form-check-label" for="distribuidor1">Cofarma</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-chexbox-radio" type="radio" name="distribuidor" id="distribuidor2" value="Empsephar" required {{ $p[0]->proveedor_med === 'EMPSEPHAR' ? 'checked' : '' }}>
                                <label class="form-check-label" for="distribuidor2">Empsephar</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-chexbox-radio" type="radio" name="distribuidor" id="distribuidor3" value="Cemefar" required {{ $p[0]->proveedor_med === 'CEMEFAR' ? 'checked' : '' }}>
                                <label class="form-check-label" for="distribuidor3">Cemefar</label>
                            </div>
                        </div>
                        <span id="distribuidor-error" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sucursal de la Farmacia</label>
                        <div class="form-check form-check-inline">
                            <div class="form-check">
                                <input class="form-check-input form-chexbox-radio" type="checkbox" name="sucursal[]" id="sucursal_principal" value="principal" {{ ($p[0]->f_principal == 1 ) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sucursal_principal">Principal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-chexbox-radio" type="checkbox" name="sucursal[]" id="sucursal_secundaria" value="secundaria" {{ ($p[0]->f_secundaria == 1 ) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sucursal_secundaria">Secundaria</label>
                            </div>
                        </div>
                        <span id="sucursal-error" class="text-danger"></span>
                    </div>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-success" id="btnEnvio">Actualizar Pedido</a>
                <a href="/pedidos" class="btn btn-secondary">Cerrar</a>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="../vendor/fontawesome-free/css/all.min.css">
<!-- fullCalendar -->
<link rel="stylesheet" href="../vendor/fullcalendar/main.css">
<!-- Theme style -->
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="text/javascript">
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

                    document.getElementById('medicamentoForm').submit();

                }
            }
        }
    });
</script>
@stop