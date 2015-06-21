<?php
/**
 * login.blade.php 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */
?>
{{-- Page template --}}
@extends('templates.normal')

{{-- Page title --}}
@section('title') Tableau de bord @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
<!-- DataTables CSS -->
{{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
@stop

{{-- Page specific JS files --}}
@section('scripts')

<script>
$(document).ready(function() {
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Rendement individuel",
            value: 120
        }, {
            label: "Rendement production 1",
            value: 30
        }, {
            label: "Rndement production 1",
            value: 200
        }],
        resize: true
    });
    
    Morris.Donut({
        element: 'morris-donut-chart-1',
        data: [{
            label: "Rendement individuel",
            value: 120
        }, {
            label: "Rendement production 1",
            value: 30
        }, {
            label: "Rndement production 1",
            value: 200
        }],
        resize: true
    });
});//fin document.ready
</script>

@stop

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tableau de bord</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{URL::to('alerte')}}">Alertes réscentes</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @if(count($alertes) >0)
                        @foreach($alertes as $key => $value)
                        <div class="list-group">
                                <a href="{{URL::to('alerte/' . $value->AlerteID)}}" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> {{$value->Titre}}
                                    <span class="pull-right text-muted small"><em>{{$value->Datecreation_f}}</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                        @endforeach
                        <a href="{{URL::to('alerte')}}" class="btn btn-default btn-block">Consulter toutes les alertes</a>
                    @else
                        Aucune alerte importante enregistrée sur le système
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{URL::to('production')}}">Rendement de mes productions</span></a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <a href="{{URL::to('production')}}" class="btn btn-default btn-block">Gérer mes productions</a>
                    <div id="morris-donut-chart"></div>
                    <div id="morris-donut-chart-1"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <!-- /.col -->
    </div>
    
</div>
<!-- /#page-wrapper -->

@stop