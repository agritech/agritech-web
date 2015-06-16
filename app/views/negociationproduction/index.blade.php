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
@section('title') Liste des négociations des productions @stop

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
        "ajax": "{{ URL::to('negociationproduction/datatable/ajax') }}",
        "columns": [
            {"name": "production.Poids", "targets": 0, "data": "Poids", className: "text-right"},
            {"name": "production.StatutSoumission", "targets": 1, "data": "StatutSoumission", "type": "text", className: "text-left"},
            {"name": "agri.agri_nom", "targets": 2, "data": "agri_nom", "type": "text", className: "text-left"},
            {"name": "production.DateSoumission", "targets": 3, "data": "DateSoumission", "type": "date", className: "text-right"},
            {"name": "produit.Ref", "targets": 4, "data": "produit_ref", "type": "text", className: "text-left"},
            {"name": "production.nbr_negociation", "targets": 5, "data": "nbr_negociation", "type": "text", className: "text-right"},
            {"name": "Action", "targets": 6, "searchable": false, "orderable": false, "width":"60px"}
        ],
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    return row.Poids + ' (Kg)';
                },
                "type": "html",
                "targets": 0
            },{
                "render": function ( data, type, row ) {
                    return row.agri_nom + ' ' + row.agri_prenom;
                },
                "type": "html",
                "targets": 2
            },{
                "render": function ( data, type, row ) {
                    return 'Ref : ' + row.produit_ref + ' Nom : ' + row.produit_nom;
                },
                "type": "html",
                "targets": 4
            },{
                "render": function ( data, type, row ) {
                    return  '<div class="pull-right">' +
                                '<div class="col-xs-9 text-center">' +
                                    '<div>' + row.nbr_negociation + '</div>' +
                                '</div>'
                            '</div>';
                },
                "type": "html",
                "targets": 5
            },{
                "render": function ( data, type, row ) {
                    return  '<div class="pull-right">' +
                                '<a href="' + baseUrl + '/negociationproduction/' + row.ProductionID + '/create" class="btn btn-xs btn-success"> <i class="fa fa-edit"></i></a> &nbsp;' +
                            '</div>';
                },
                "type": "html",
                "targets": 6
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
            <h1 class="page-header">Liste des productions pour lesquelles on peut encore proposer un prix</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des productions à négocier
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
                                    <th>Poids&nbsp;</th>
                                    <th>Statut&nbsp;</th>
                                    <th>Agriculeur&nbsp;</th>
                                    <th>Date de la proposition&nbsp;</th>
                                    <th>Produit</th>
                                    <th>Nombre de propositions&nbsp;</th>
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