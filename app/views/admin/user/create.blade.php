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
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
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
                            {{ Form::open(array('url' => URL::to('admin/user') , 'role' => 'form')) }}
                                <div class="form-group @if($errors->first('Username') != '') has-error @endif">
                                    <label>Login *</label>
                                    {{ Form::text('Username', Input::old('Username'), array('class' => 'form-control', 'autofocus' => '' ) ) }}
                                    {{ $errors->first('Username', '<span class="error">:message</span>' ) }}
                                </div>
                                <div class="form-group">
                                    <label>Nom</label>
                                    {{ Form::text('nom', Input::old('nom'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Prénom</label>
                                    {{ Form::text('prenom', Input::old('prenom'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    {{ Form::email('Mail', Input::old('Mail'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Téléphone</label>
                                    {{ Form::text('telephone', Input::old('telephone'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Adresse</label>
                                    {{ Form::text('adresse', Input::old('adresse'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Ville</label>
                                    {{ Form::text('ville', Input::old('ville'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Pays</label>
                                    {{ Form::text('pays', Input::old('pays'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Fonction</label>
                                    {{ Form::text('fonction', Input::old('fonction'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Société</label>
                                    {{ Form::text('societe', Input::old('societe'), array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    <label>Est un administrateur ?</label>
                                    {{ Form::checkbox('isadmin', Input::old('isadmin') ) }}
                                </div>
                                <div class="form-group @if($errors->first('password') != '') has-error @endif">
                                    <label>Mot de passe *</label>
                                    {{ Form::password('password', array('class' => 'form-control')) }}
                                    {{ $errors->first('password', '<span class="error">:message</span>' ) }}
                                </div>
                                <div class="form-group">
                                    <label>Vérifier le mot de passe</label>
                                    {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
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