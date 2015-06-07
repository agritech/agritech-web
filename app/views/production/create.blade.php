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
@section('title') Ajouter une production @stop

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
    $('#DateSoumission').datepicker( $.datepicker.regional["fr"]);
    $('#Poids').mask('#0.00', {reverse: true});
    
    function repoProduitFormatResult(repo) {
      repo.id = repo.ProduitID;
      var markup = '<div class="row">' +
           '<div class="col-lg-3"><i class="fa fa-code-fork"></i> Ref : ' + repo.Ref + '</div>' +
           '<div class="col-lg-3"><i class="fa fa-code-fork"></i> Nom : ' + repo.Nom + '</div>' +
        '</div>';

      return markup;
    }

    function repoProduitFormatSelection(repo) {
      return 'Ref : ' + repo.Ref + ' - Nom : ' + repo.Nom;
    }

    $('#ProduitID').select2({
        placeholder: "Rechercher un produit",
        minimumInputLength: 1,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "{{ URL::to('produit/select2/ajax') }}",
            dataType: 'json',
            quietMillis: 250,
            data: function (term, page) {
                return {
                    q: term, // search term
                    page: page
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter the remote JSON data
                var more = (page * 10) < data.recordsFiltered;
                return { results: data.data, more: more };
            },
            cache: true
        },
        formatResult: repoProduitFormatResult, 
        formatSelection: repoProduitFormatSelection,  
        dropdownCssClass: "bigdrop", 
        escapeMarkup: function (m) { return m; },
        id : function(obj){
            return obj.ProduitID;
        } 
    });
    
    function repoAgriculteurFormatResult(repo) {
      repo.id = repo.UtilisateurID;
      var markup = '<div class="row">' +
           '<div class="col-lg-3"><i class="fa fa-code-fork"></i> Login : ' + repo.Username + '</div>' +
           '<div class="col-lg-3"><i class="fa fa-code-fork"></i> Nom : ' + repo.nom + '</div>' +
           '<div class="col-lg-3"><i class="fa fa-code-fork"></i> Prénom : ' + repo.prenom + '</div>' +
        '</div>';

      return markup;
    }

    function repoAgriculteurFormatSelection(repo) {
      return 'Login : ' + repo.Username + ' - Nom : ' + repo.nom + ' - Prénom : ' + repo.prenom;
    }
    
    $('#AgriculteurID').select2({
        placeholder: "Rechercher un agriculteur",
        minimumInputLength: 1,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "{{ URL::to('agriculteur/select2/ajax') }}",
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
        formatResult: repoAgriculteurFormatResult,
        formatSelection: repoAgriculteurFormatSelection, 
        dropdownCssClass: "bigdrop", 
        escapeMarkup: function (m) { return m; },
        id : function(obj){
            return obj.UtilisateurID;
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
            <h1 class="page-header">Ajouter une production </h1>
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
                            {{ Form::open(array('url' => URL::to('production') , 'role' => 'form')) }}
                                <div class="form-group @if($errors->first('Poids') != '')) has-error @endif">
                                    <label>Poids *</label>
                                    {{ Form::text('Poids', Input::old('Poids'), array('class' => 'form-control', 'placeholder' => "Poids", 'id' => 'Poids') ) }}
                                    {{ $errors->first('Poids', '<span class="error">:message</span>' ) }}
                                </div>
                                <div class="form-group">
                                    <label>Produit *</label>
                                    <input type="hidden" class="bigdrop form-control" id="ProduitID" name="ProduitID" value="{{Input::old('ProduitID')}}" />
                                </div>
                                <div class="form-group">
                                    <label>Agriculteur *</label>
                                    <input type="hidden" class="bigdrop form-control" id="AgriculteurID" name="AgriculteurID" value="{{Input::old('AgriculteurID')}}" />
                                </div>
                                <div class="form-group @if($errors->first('Finperiode') != '')) has-error @endif">
                                    <label>Date de soumission *</label>
                                    <input type="text" name="DateSoumission" id="DateSoumission" value="{{Input::old('DateSoumission')}}" class="form-control">
                                    {{ $errors->first('DateSoumission', '<span class="error">:message</span>' ) }}
                                </div>
                                <div class="form-group">
                                    <label>Statut de la production</label>
                                    {{ Form::select('StatutSoumission', $statutSoumissions, Input::old('StatutSoumission'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Canal de soumission de la production</label>
                                    {{ Form::select('CanalSoumission', $canalSoumissions, Input::old('CanalSoumission'), array('class' => 'form-control')) }}
                                </div>
                                {{ Form::submit('Enregistrer', array('class'=>'btn btn-primary')) }}
                                {{ link_to(URL::previous(), 'Annuler', ['class' => 'btn btn-default']) }}
                            {{ Form::close() }}
                        </div>
                        <!-- /.col-lg-6 (nested) -->
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