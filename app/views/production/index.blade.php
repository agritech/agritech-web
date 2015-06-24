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
@section('title') Liste des productions @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
<!-- DataTables CSS -->
{{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
{{ HTML::style('assets/js/plugins/dataTables/extensions/TableTools-2.2.3/css/dataTables.tableTools.min.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
{{ HTML::script('assets/js/plugins/dataTables/extensions/TableTools-2.2.3/js/dataTables.tableTools.min.js') }}
<script>
$(document).ready(function() {
    var baseUrl = "{{URL::to('/')}}";

    $('#dataTables-example').dataTable({
        "dom": 'T<"clear">lfrtip',
        "processing": true,
        "serverSide": true,
        "ajax": "{{ URL::to('production/datatable/ajax') }}",
        "columns": [
            {"name": "campagne_agricole.Nom", "targets": 0, "data": "campagne_agricole_nom", className: "text-left"},
            {"name": "utilisateur.Nom", "targets": 1, "data": "agriculteur_nom", className: "text-left"},
            {"name": "exploitation.Nom", "targets": 2, "data": "exploitation_nom", className: "text-left"},
            {"name": "produit.Nom", "targets": 3, "data": "produit_nom", className: "text-left"},            
            {"name": "production.Poids", "targets": 4, "data": "Poids", className: "text-right"},
            {"name": "production.StatutSoumission", "targets": 5, "data": "StatutSoumission", "type": "text", className: "text-left"},
            {"name": "production.CanalSoumission", "targets": 6, "data": "CanalSoumission", "type": "text", className: "text-left"},
            {"name": "production.DateSoumission", "targets": 7, "data": "DateSoumission", "type": "date", className: "text-right"},
            {"name": "Action", "targets": 8, "searchable": false, "orderable": false, "width":"100px"}
        ],
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    return  '<div class="pull-right">' +
                                '<a href="' + baseUrl + '/production/' + row.ProductionID + '" class="btn btn-xs btn-success"> <i class="fa fa-search"></i></a> &nbsp;' +
                                '<a href="' + baseUrl + '/production/' + row.ProductionID + '/edit" class="btn btn-xs btn-success"> <i class="fa fa-edit"></i></a> &nbsp;' +
                                '<form method="POST" action="'+baseUrl + '/production/' + row.ProductionID + '" accept-charset="UTF-8" class="pull-right"><input name="_token" type="hidden" value="{{Session::token()}}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></form>'+
                            '</div>';
                },
                "type": "html",
                "targets": 8
            },
            //{ "visible": false,  "targets": [ 3 ] }
        ],
        "tableTools": {
            "sSwfPath": "{{ URL::to('/')}}/assets/js/plugins/dataTables/extensions/TableTools-2.2.3/swf/copy_csv_xls_pdf.swf"
        },
        "language": {
            "url": "{{ URL::to('/')}}/assets/js/plugins/dataTables/French.lang"
        }
    });
});
</script>
@stop

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Productions <a href="{{ URL::to('production/create') }}" class="btn btn-success pull-right">Ajouter une production</a></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des productions saisies
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- Success-Messages -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ $message }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Campagne agricole&nbsp;</th>
                                    <th>Agriculteur&nbsp;</th>
                                    <th>Exploitation&nbsp;</th>
                                    <th>Produit</th>
                                    <th>Poids&nbsp;</th>
                                    <th>Statut&nbsp;</th>
                                    <th>Canal&nbsp;</th>
                                    <th>Date de soumission&nbsp;</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

@stop