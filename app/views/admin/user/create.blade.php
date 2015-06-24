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
@section('title') Ajouter un utilisateur @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
{{ HTML::style('assets/jquery-ui-1.11.2/themes/base/all.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
{{ HTML::script('assets/jquery-ui-1.11.2/ui/datepicker.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/demos/datepicker/datepicker-fr.js') }}
<script>
$(document).ready(function() {
    $('#date_naissance').datepicker( $.datepicker.regional["fr"]);
});
</script>
@stop

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Ajouter un utilisateur </h1>
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
                            {{ Form::open(array('url' => URL::to('admin/user') , 'role' => 'form', 'class' => 'form-horizontal')) }}
                                <div class="form-group @if($errors->first('Username') != '') has-error @endif">
                                    <label class="col-lg-3 control-label">Login *</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('Username', Input::old('Username'), array('class' => 'form-control', 'autofocus' => '' ) ) }}
                                    {{ $errors->first('Username', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Nom</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('nom', Input::old('nom'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Prénom</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('prenom', Input::old('prenom'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Date de naissance</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="date_naissance" id="date_naissance" value="{{Input::old('date_naissance')}}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Sexe</label>
                                    <div class="col-lg-9">
                                        {{ Form::select('sexe', array('MASCULIN' => 'Masculin', 'FEMININ' => 'Feminin'), Input::old('sexe'), array('class' => 'form-control' ) ) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Email</label>
                                    <div class="col-lg-9">
                                    {{ Form::email('Mail', Input::old('Mail'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Téléphone</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('telephone', Input::old('telephone'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Adresse</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('adresse', Input::old('adresse'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Ville</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('ville', Input::old('ville'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Pays</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('pays', Input::old('pays'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Fonction</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('fonction', Input::old('fonction'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Société</label>
                                    <div class="col-lg-9">
                                    {{ Form::text('societe', Input::old('societe'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Est un administrateur ?</label>
                                    <div class="col-lg-9">
                                    {{ Form::checkbox('isadmin', Input::old('isadmin') ) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('password') != '') has-error @endif">
                                    <label class="col-lg-3 control-label">Mot de passe *</label>
                                    <div class="col-lg-9">
                                    {{ Form::password('password', array('class' => 'form-control')) }}
                                    {{ $errors->first('password', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Vérifier le mot de passe</label>
                                    <div class="col-lg-9">
                                    {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
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