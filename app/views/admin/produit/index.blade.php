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
@section('title') Liste des produits @stop

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
        "ajax": "{{ URL::to('admin/produit/datatable/ajax') }}",
        "columns": [
            {"name": "produit.Ref", "targets": 0, "data": "Ref", className: "text-left"},
            {"name": "produit.Nom", "targets": 1, "data": "Nom", "type": "text", className: "text-left"}
        ],
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    return  '<div class="pull-right">' +
                                '<a href="' + baseUrl + '/admin/produit/' + row.ProduitID + '/edit" class="btn btn-xs btn-success"> <i class="fa fa-edit"></i></a> &nbsp;' +
                                '<form method="POST" action="'+baseUrl + '/admin/produit/' + row.ProduitID + '" accept-charset="UTF-8" class="pull-right"><input name="_token" type="hidden" value="VgCwyBAy8xM1DsqNDnyi5VBl8x1fUNixo4h3NCcY"><input name="_method" type="hidden" value="DELETE"><button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></form>'+
                            '</div>';
                },
                "type": "html",
                "targets": 2
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
            <h1 class="page-header">Produits <a href="{{ URL::to('admin/produit/create') }}" class="btn btn-success pull-right">Ajouter un produit</a></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des produits saisis
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
                                    <th>Référence&nbsp;</th>
                                    <th>Nom&nbsp;</th>
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