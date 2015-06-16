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
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">1</div>
                            <div>Productions soumises</div>
                        </div>
                    </div>
                </div>
                <a href="{{ URL::to('production') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Voir détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">1</div>
                            <div>Négociaions de production en cours</div>
                        </div>
                    </div>
                </div>
                <a href="{{ URL::to('negociationproduction') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Voir détails</span>
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
                            <div class="huge">4</div>
                            <div>Zones de cultures</div>
                        </div>
                    </div>
                </div>
                <a href="{{ URL::to('culturezones') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Voir détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

@stop