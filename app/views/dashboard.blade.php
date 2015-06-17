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
{{ HTML::script('assets/Highcharts-4.0.4/js/highcharts.js') }}
{{ HTML::script('assets/Highcharts-4.0.4/js/modules/data.js') }}
{{ HTML::script('assets/Highcharts-4.0.4/js/modules/exporting.js') }}

<script>
$(document).ready(function() {
    $(function () {
        // Get the CSV and create the chart
        $.getJSON('{{URL::to('')}}/jsonp?filename=analytics.csv&callback=?', function (jsonData) {
            
            $('#container').highcharts({
                
                series: jsonData.series,
                
                chart: {
                    type: 'column'
                },
        
                title: {
                    text: 'Utilisateurs groupés par types'
                },
        
                xAxis: {
                    categories: ['Agriculteur', 'Acheteur', 'Partenaire', 'Professionnel']
                },
        
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Nombre d\'utilisateurs'
                    }
                },
        
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
                    }
                },
        
                plotOptions: {
                    column: {
                        stacking: 'normal'
                    }
                }
            });
        });
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
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Alertes importantes
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @if(count($alertes) >0)
                        @foreach($alertes as $key => $value)
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h3 id="thumbnail-label">
                                        <i class="fa fa-{{$value->Icone}} fa-1x"></i>
                                        <a href="{{ URL::to('alerte/' . $value->AlerteID ) }}" >
                                            {{$value->Titre}}
                                        </a>
                                        <a class="anchorjs-link" href="#thumbnail-label">
                                            <span class="anchorjs-icon"></span>
                                        </a>
                                    </h3>
                                    <p>
                                        <a href="{{ URL::to('alerte/' . $value->AlerteID ) }}" >
                                            {{$value->Message}}
                                        </a>
                                    </p>    
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        Aucune alerte importante enregistrée sur le système
                    @endif
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Statistiques générales de la communauté
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-tasks fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{$nbalertes}}</div>
                                            <div>Alertes importantes</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ URL::to('alerte') }}">
                                    <div class="panel-footer">
                                        <span class="pull-left">Consulter les alertes</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{$nbexploitations}}</div>
                                            <div>Exploitations enregistrées</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ URL::to('exploitation') }}">
                                    <div class="panel-footer">
                                        <span class="pull-left">Consulter les exploitations</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-shopping-cart fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{$nbproductions}}</div>
                                            <div>Productions renseignées</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ URL::to('production') }}">
                                    <div class="panel-footer">
                                        <span class="pull-left">Consulter les productions</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Nombre d'utilisateurs dans la communauté
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

@stop