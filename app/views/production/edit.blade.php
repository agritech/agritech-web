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
@section('title') Modifier une production @stop

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

    function repoAgriculteurFormatResult(repo) {
      repo.id = repo.UtilisateurID;
      var markup = '<div class="row">' +
           '<div class="col-lg-6"><i class="fa fa-user"></i> Login : ' + repo.nom + '</div>' +
           '<div class="col-lg-6">Prénom : ' + repo.prenom + '</div>' +
        '</div>';

      return markup;
    }

    function repoAgriculteurFormatSelection(repo) {
      return 'Nom : ' + repo.nom + ' - Prénom : ' + repo.prenom;
    }
    
    $('#AgriculteurID').select2({
        placeholder: "Rechercher un agriculteur",
        minimumInputLength: 0,
        ajax: {
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
        escapeMarkup: function (m) { return m; } ,
        id : function(obj){
            return obj.UtilisateurID;
        },
        initSelection: function(element, callback) {
            var id = $(element).val();
            if (id !== "") {
                var utilisateur = {{$production->Agriculteur->toJson()}};
                callback(utilisateur);
            }
        }
    }).on("change", function (e) { 
        //Initialiser le select2
        $('#ExploitationID').select2('val', null).trigger('change');
    });
    
    function repoExploitationFormatResult(repo) {
      repo.id = repo.ExploitationID;
      var markup = '<div class="row">' +
           '<div class="col-lg-6"><i class="fa fa-home"></i> Nom : ' + repo.Ref + '</div>' +
           '<div class="col-lg-6">Prénom : ' + repo.Nom + '</div>' +
        '</div>';

      return markup;
    }
    
    function repoExploitationFormatSelection(repo) {
      return 'Réference : ' + repo.Ref + ' - Nom : ' + repo.Nom;
    }
    
    $('#ExploitationID').select2({
        placeholder: "Rechercher une exploitation ...",
        minimumInputLength: 0,
        query: function (query) {
            var agriculteurID = $('#AgriculteurID').val();
            if(agriculteurID){
                $.getJSON("{{ URL::to('exploitation/select2/ajax') }}/" + agriculteurID, function(data){
                    var more = (query.page * 10) < data.recordsFiltered;
                    query.callback({results: data.data, more: more }); 
                });
            }else{
                query.callback({results: [], more: false });
            }
        },
        initSelection: function (element, callback) {
            var id = $(element).val();
            if (id !== "") {
                var exploitation = {{$production->Exploitation->toJson()}};
                callback(exploitation);
            }
        },
        formatResult: repoExploitationFormatResult,
        formatSelection: repoExploitationFormatSelection, 
        dropdownCssClass: "bigdrop", 
        escapeMarkup: function (m) { return m; },
        id : function(obj){
            return obj.ExploitationID;
        } 
    }).on("change", function (e) { 
        $('#ProduitID').select2('val', null).trigger('change'); 
    });
    
    function repoProduitFormatResult(repo) {
      repo.id = repo.ProduitID;
      var markup = '<div class="row">' +
           '<div class="col-lg-6"><i class="fa fa-tree"></i> Ref : ' + repo.Ref + '</div>' +
           '<div class="col-lg-6">Nom : ' + repo.Nom + '</div>' +
        '</div>';

      return markup;
    }

    function repoProduitFormatSelection(repo) {
      return 'Ref : ' + repo.Ref + ' - Nom : ' + repo.Nom;
    }

    $('#ProduitID').select2({
        placeholder: "Rechercher un produit",
        minimumInputLength: 0,
        query: function (query) {
            var exploitationID = $('#ExploitationID').val();
            if(exploitationID){
                $.getJSON("{{ URL::to('produit/select2/ajax') }}/" + exploitationID, function(data){
                    var more = (query.page * 10) < data.recordsFiltered;
                    query.callback({results: data.data, more: more }); 
                });
            }else{
                query.callback({results: [], more: false });
            }
        },
        initSelection: function (element, callback) {
            var id = $(element).val();
            if (id !== "") {
                var produit = {{$production->Produit->toJson()}};
                callback(produit);
            }
        },
        formatResult: repoProduitFormatResult, 
        formatSelection: repoProduitFormatSelection,  
        dropdownCssClass: "bigdrop", 
        escapeMarkup: function (m) { return m; },
        id : function(obj){
            return obj.ProduitID;
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
            <h1 class="page-header">Mise-à-jour des informations de la production </h1>
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
                            {{ Form::model($production, array('route' => array('production.update', $production->ProductionID), 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal')) }}
                                <div class="form-group @if($errors->first('CampagneAgricoleID') != '')) has-error @endif">
                                    <label class="col-lg-3 control-label">Campagne agricole *</label>
                                    <div class="col-lg-9">
                                    {{ Form::select('CampagneAgricoleID', $campagneAgricoles, $production->CampagneAgricoleID, array('class' => 'form-control')) }}
                                    {{ $errors->first('CampagneAgricoleID', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('AgriculteurID') != '')) has-error @endif">
                                    <label class="col-lg-3 control-label">Agriculteur *</label>
                                    <div class="col-lg-9">
                                        <input type="hidden" class="bigdrop form-control" id="AgriculteurID" name="AgriculteurID" value="{{$production->AgriculteurID}}" />
                                        {{ $errors->first('AgriculteurID', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('ExploitationID') != '')) has-error @endif">
                                    <label class="col-lg-3 control-label">Exploitation *</label>
                                    <div class="col-lg-9">
                                        <input type="hidden" class="bigdrop form-control" id="ExploitationID" name="ExploitationID" value="{{$production->ExploitationID}}" />
                                        {{ $errors->first('ExploitationID', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('ProduitID') != '')) has-error @endif">
                                    <label class="col-lg-3 control-label">Produit *</label>
                                    <div class="col-lg-9">
                                        <input type="hidden" class="bigdrop form-control" id="ProduitID" name="ProduitID" value="{{$production->ProduitID}}" />
                                        {{ $errors->first('ProduitID', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('Poids') != '') has-error @endif">
                                    <label class="col-lg-3 control-label">Poids *</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('Poids', Input::old('Poids'), array('class' => 'form-control', 'placeholder' => "Poids (Kg)", 'id' => 'Poids') ) }}
                                    {{ $errors->first('Poids', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('DateSoumission') != '')) has-error @endif">
                                    <label class="col-lg-3 control-label">Date de soumission *</label>
                                    <div class="col-lg-9">
                                    <input type="text" name="DateSoumission" id="DateSoumission" value="{{$production->datesoumission_f}}" class="form-control">
                                    {{ $errors->first('DateSoumission', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Statut de la production</label>
                                    <div class="col-lg-9">
                                    {{ Form::select('StatutSoumission', $statutSoumissions, Input::old('StatutSoumission'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Canal de soumission de la production</label>
                                    <div class="col-lg-9">
                                    {{ Form::select('CanalSoumission', $canalSoumissions, Input::old('CanalSoumission'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-lg-offset-3 col-lg-9">
                                {{ Form::submit('Enregistrer', array('class'=>'btn btn-success')) }}
                                {{ link_to(URL::previous(), 'Annuler', ['class' => 'btn btn-default']) }}
                                </div>
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