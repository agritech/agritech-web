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
            label: "Mon rendement",
            value: 90
        }, {
            label: "Rendement global",
            value: 100
        }, {
            label: "Rendement pays",
            value: 200
        }, {
            label: "Rendement région",
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
        <div class="col-lg-3">
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
                        <a href="{{URL::to('alerte')}}" class="btn btn-success btn-block">Consulter toutes les alertes</a>
                    @else
                        Aucune alerte importante enregistrée sur le système
                    @endif
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{URL::to('production')}}">Prix des productions réscents</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @if(count($negociationproductions) >0)
                        @foreach($negociationproductions as $key => $value)
                        <div class="list-group">
                                <a href="{{URL::to('production/' . $value->ProductionID)}}" class="list-group-item">
                                    <i class="fa fa-compass fa-fw"></i> {{$value->Production->Produit->Nom}}
                                    <span class="pull-right text-muted small"><em>{{$value->Prix}}</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                        @endforeach
                        <a href="{{URL::to('production')}}" class="btn btn-success btn-block">Consulter toutes les productions</a>
                    @else
                        Aucun prix de production enregistrée. Avez-vous renseigné vos productions ?
                    @endif
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{URL::to('produit')}}">Produits cultivés près de chez vous</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @if(count($produits) >0)
                        @foreach($produits as $key => $value)
                        <div class="list-group">
                                <a href="{{URL::to('produit/' . $value->ProduitID)}}" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> {{$value->Nom}}
                                    <span class="pull-right text-muted small"><em>{{$value->Ref}}</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                        @endforeach
                        <a href="{{URL::to('produit')}}" class="btn btn-success btn-block">Consulter toutes les produits</a>
                    @else
                        Aucune produit près de chez vous. Avez vous renseigner votre adresse complète dans votre profile ?
                    @endif
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{URL::to('production')}}">Mon rendement de production</span></a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-donut-chart"></div>
                    <a href="{{URL::to('production')}}" class="btn btn-success btn-block">Gérer mes productions</a>
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