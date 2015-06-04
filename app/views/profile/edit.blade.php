<?php
/**
 * view.blade.php 
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
@section('title') Modification du profile de l'utilisateur @stop

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
            <h1 class="page-header">Profile de <small>{{(isset($user->prenom)) ? $user->prenom : $user->Username}}</small></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Merci de remplir le formulaire ci-dessous pour modifier le profile
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
                            {{ Form::model($user, array('route' => array('profile.update', $user->UtilisateurID), 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal')) }}
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Login</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">&nbsp;{{$user->Username}}</p>
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
                                    <label class="col-lg-3 control-label">Mot de passe</label>
                                    <div class="col-lg-9">
                                        {{ Form::password('password', array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Vérifier le mot de passe</label>
                                    <div class="col-lg-9">
                                        {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                                    </div>
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
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Ajouter une photo à l'utilisateur
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-3">
                            @if(isset($user->photo))
                                <img src="{{ URL::to('profile/'. $user->UtilisateurID . '/photo/' . $user->photo) }}" alt="Photo" width="100px" height="100px"/>
                            @else
                                <i class="fa fa-user fa-fw fa-5x"></i>
                            @endif
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                        <div class="col-lg-9">
                            {{ Form::open(array('url' => URL::to('profile/'. $user->UtilisateurID .'/photo') , 'role' => 'form','files' => true)) }}
                                <div class="form-group @if($errors->first('photo') != '') has-error @endif">
                                    <label>Photo (100x100 px) *</label>
                                    {{ Form::file('photo', array('class' => 'form-control' ) ) }}
                                    {{ $errors->first('photo', '<span class="error">:message</span>' ) }}
                                </div>
                                {{ Form::submit('Ajouter', array('class'=>'btn btn-primary')) }}
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
    
</div>
<!-- /#page-wrapper -->

@stop