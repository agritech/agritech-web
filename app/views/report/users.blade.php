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
@section('title') Répartition des utilisateurs @stop

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
            <h1 class="page-header">Répartition des utilisateurs</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Répartition des utilisateurs par type
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