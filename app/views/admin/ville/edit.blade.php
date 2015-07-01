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
@section('title') Modifier une ville @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
{{ HTML::style('assets/select2-3.5.2/select2.css') }}
{{ HTML::style('assets/select2-3.5.2/select2-bootstrap.css') }}
{{ HTML::style('assets/jquery-ui-1.11.2/themes/base/all.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
{{ HTML::script('assets/select2-3.5.2/select2.min.js') }}
{{ HTML::script('assets/select2-3.5.2/select2_locale_fr.js') }}
{{ HTML::script('assets/jQuery-Mask-Plugin-1.11.2/dist/jquery.mask.min.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/core.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/widget.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/datepicker.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/demos/datepicker/datepicker-fr.js') }}
<script>
$(document).ready(function() {
    function repoPaysFormatResult(repo) {
      repo.id = repo.PaysID;
      var markup = '<div class="row">' +
           '<div class="col-lg-3"><i class="fa fa-university"></i> Reférence : ' + repo.Ref + '</div>' +
           '<div class="col-lg-9">Nom : ' + repo.Nom + '</div>' +
        '</div>';

      return markup;
    }

    function repoPaysFormatSelection(repo) {
      return 'Ref : ' + repo.Ref + ' - Nom : ' + repo.Nom;
    }
    
    $('#PaysID').select2({
        placeholder: "Rechercher un pays",
        minimumInputLength: 0,
        ajax: {
            url: "{{ URL::to('pays/select2/ajax') }}",
            dataType: 'json',
            quietMillis: 250,
            data: function (term, page) {
                return {
                    q: term, // search term
                    page: page
                };
            },
            results: function (data, page) { 
                var more = (page * 10) < data.recordsFiltered;
                return { results: data.data, more: more };
            },
            cache: true
        },
        formatResult: repoPaysFormatResult,
        formatSelection: repoPaysFormatSelection,
        dropdownCssClass: "bigdrop",
        escapeMarkup: function (m) { return m; } ,
        id : function(obj){
            return obj.PaysID;
        },
        initSelection: function(element, callback) {
            var id = $(element).val();
            if (id !== "") {
                var pays = {{$ville->Pays->toJson()}};
                callback(pays);
            }
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
            <h1 class="page-header">Mise-à-jour des informations de la ville </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Merci de remplir le formulaire ci-dessous
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if ( $errors->count() > 0 )
                                @foreach( $errors->all() as $message )
                                    <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                @endforeach
                            @endif
                            {{ Form::model($ville, array('route' => array('admin.ville.update', $ville->VilleID), 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal')) }}
                                <div class="form-group @if($errors->first('Ref') != '') has-error @endif">
                                    <label class="col-lg-3 control-label">Référence *</label>
                                    <div class="col-lg-9">
                                        {{ Form::text('Ref', $ville->Ref, array('class' => 'form-control', 'placeholder' => "Référence", 'id' => 'Ref') ) }}
                                        {{ $errors->first('Ref', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('Nom') != '') has-error @endif">
                                    <label class="col-lg-3 control-label">Nom *</label>
                                    <div class="col-lg-9">
                                        {{ Form::text('Nom', $ville->Nom, array('class' => 'form-control', 'placeholder' => "Nom", 'id' => 'Nom') ) }}
                                        {{ $errors->first('Nom', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('PaysID') != '')) has-error @endif">
                                    <label class="col-lg-3 control-label">Pays *</label>
                                    <div class="col-lg-9">
                                        <input type="hidden" class="bigdrop form-control" id="PaysID" name="PaysID" value="{{$ville->PaysID}}" />
                                        {{ $errors->first('PaysID', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Description *</label>
                                    <div class="col-lg-9">
                                        {{ Form::textarea('Description', $ville->Description, array('class' => 'form-control') ) }}
                                    </div>
                                </div>
                                <div class="col-lg-offset-3 col-lg-9">
                                    {{ Form::submit('Enregistrer', array('class'=>'btn btn-success')) }}
                                    {{ link_to(URL::previous(), 'Annuler', ['class' => 'btn btn-default']) }}
                                </div>
                            {{ Form::close() }}
                        </div>
                        <!-- /.col-lDescriptiong-6 (nested) -->
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