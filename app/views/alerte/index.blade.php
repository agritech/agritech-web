<?php
/**
 * login.blade.php 
 * {File description}
 * 
 * @author alompo
 * @created May 2015
 * 
 */
?>
{{-- Page template --}}
@extends('templates.normal')

{{-- Page title --}}
@section('title') Liste des alertes @stop

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
        "ajax": "{{ URL::to('alerte/datatable/ajax') }}",
        "columns": [
            {"name": "Icone", "targets": 0, "searchable": false, "orderable": false, "width":"30px"},
            {"name": "alerte.Titre", "targets": 1, "data": "Titre", "type": "text", className: "text-left", "width":"70%"},
            {"name": "alerte.DateCreation", "targets": 2, "data": "DateCreation", "type": "date", className: "text-left", "width":"10%"},
            {"name": "evenement.Nom", "targets": 3, "data": "EvenementNom", "type": "text", className: "text-left", "width":"10%"},
            {"name": "utilisateur.nom", "targets": 4, "data": "InitiateurNom", "type": "text", className: "text-left", "width":"10%"},
            {"name": "Action", "targets": 5, "searchable": false, "orderable": false, "width":"60px"}
        ],
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    return  '<div class="text-center">' +
                                '<i class="fa fa-' + row.Icone + ' fa-2x"></i>' +
                            '</div>';
                },
                "type": "html",
                "targets": 0
            },
            {
                "render": function ( data, type, row ) {
                    return  '<div class="pull-right">' +
                                '<a href="' + baseUrl + '/alerte/' + row.AlerteID + '/edit" class="btn btn-xs btn-success"> <i class="fa fa-edit"></i></a> &nbsp;' +
                                '<form method="POST" action="'+baseUrl + '/alerte/' + row.AlerteID + '" accept-charset="UTF-8" class="pull-right"><input name="_token" type="hidden" value="{{Session::token()}}"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></form>'+
                            '</div>';
                },
                "type": "html",
                "targets": 5
            }
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
            <h1 class="page-header">Alertes <a href="{{ URL::to('alerte/create') }}" class="btn btn-success pull-right">Ajouter une alerte</a></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des alertes saisies
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
                                    <th>&nbsp;</th>
                                    <th>Titre&nbsp;</th>
                                    <th>Date&nbsp;</th>
                                    <th>Type&nbsp;</th>
                                    <th>Initiateur&nbsp;</th>
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