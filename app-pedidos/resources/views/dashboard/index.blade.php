@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-gradient-yellow">
            <div class="inner">
                <h3><?php echo $pedidos; ?></h3>
                <p>Pedidos</p>
            </div>
            <div class="icon">
                <i class="far fa-calendar-alt"></i>
            </div>
            <a href="/pedidos" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop